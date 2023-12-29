<?php

namespace App\Http\Controllers;

use App\Jobs\DynamicsCCOrders;
use App\Jobs\DynamicsCreateOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use App\Services\MSDynamic;
use App\Services\PaymentSense\PaymentSenseInterface;
use App\Sale;
use App\ProductPricingManagement;
use App\Product_Sale;
use App\Slots;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $baseURL = "https://cater-choice-assets.s3.eu-west-2.amazonaws.com/storage/thumbnail/";
        $user = Auth::user();
        $page = $request->page??0;

        $per_page = $request->per_page ?? 10;
        $query = Sale::with(["items"=>function($query){

            $query->with("product");

        }])->where("customer_id",$user->id)->where(function($query) use($request){

        });
        $products = $query->paginate($per_page);
        $products->getCollection()->transform(function ($sale) use ($baseURL) {
            $sale->items->each(function ($item) use ($baseURL) {
                $images = explode(',', $item->product->image);
                $firstImage = !empty($images) ? $baseURL . trim($images[0]) : null;
                $item->product->image = $firstImage;
            });
            return $sale;
        });


        $data['data'] = $products->items();
        $data['total'] = $products->total();
        $data['is_more'] = $products->hasMorePages();
        $data['page'] = $page+1;
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MSDynamic $api, PaymentSenseInterface $payment)
    {

        if($request->extra['shipping_method']==0){
             $validator = Validator::make($request->all(), [
                'extra.email' => 'required|email|min:3|max:50',
                'extra.phone_number' => 'required',
                'extra.address' => 'required',
                'extra.postal_code' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'extra.pickup_date' => 'required',
                'extra.selectedSlot' => 'required',
            ]);
        }


        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $cart = $request->cart;
        $webItems = $cart;
        $extra = $request->extra;

        try {

            $user = Auth::user();
            $collection = new Collection($cart);

            $totalPrice = $collection->sum('price');
            //$totalvatPrice = $collection->sum('vat');
            //dd( $totalvatPrice);
            $data = [];
            $sale_data = [];
            $data['reference_no'] = 'ORD-'.strtoupper(Str::random(10));
            $data['user_id'] = $user->user_id;
            $data['customer_id'] = $user->id;
            $data['branch_id'] = $user->id;
            $data['grand_total'] =  $totalPrice;
            $data['total_price'] =  $totalPrice;
            $data['paid_amount'] =  $totalPrice;
            $data['sale_status'] =  1;
            $data['payment_status']="Success";
            if($extra['shipping_method']==0){
                $data['email'] = $extra['email']??null;
                $data['phone'] = $extra['phone_number']??null;
                $data['address1'] = $extra['address']??null;
                $data['post_code'] = $extra['postal_code']??null;

            } else {
                $data['pick_date'] = Carbon::parse($extra['pickup_date'])->format("Y-m-d");
                $data['pick_time'] = Carbon::parse($extra['selectedSlot'])->format("HH:mm");
            }

            $ids = [];

            $sale = Sale::create($data);
            if($cart){
                foreach($cart as $item){
                    $tax = $item['vat']??0;
                    $ids[] = $item['id'];
                    $product_sale['sale_id'] = $sale->id;
                    $product_sale['product_id'] = $item['id'];
                    $product_sale['type'] = $item['type'];
                    $product_sale['qty'] = $item['quantity']??0;
                    $product_sale['net_unit_price'] = $item['price']??0;
                    $product_sale['tax'] = $tax;
                    $product_sale['total'] = $item['price']+$tax;
                    $sale_data[] = $product_sale;
                }
            }
            $price = ProductPricingManagement::where('user_id',$user->user_id)->whereIn("product_id", $ids)->sum("company_price");
            $sale->product_cost = $price;
            $sale->sale_status = 2;

            Product_Sale::insert($sale_data);
            $body = [
              'merchantUrl' => "demo-dot-connect-e-build-non-pci.appspot.com",
              "currencyCode"=> "826",
              "amount"=> floatval(number_format($totalPrice*100, 2, ".", "")),
              "transactionType"=> "SALE",
              "orderId"=> $data['reference_no'],
              "orderDescription"=> $data['reference_no'],
              "merchantTransactionId"=>"$sale->id",
              'webHookUrl'=>url('payment/webhook')
            ];
            $data = $payment->sale($body);
            \Log::info($body);
            \Log::info($data);
            if(isset($data['id'])){
                $sale->payment_token = $data['id'];
            }
            $sale->save();

            if($extra['shipping_method'] == 1){
                $collectData['HeaderNo'] = "WEB".$sale->id;
                $collectData['DocumentType'] = "order";
                $collectData['LocationCode'] = "LDS";//$order->warehouse->name;
                $collectData['ResponsibilityCenter'] = "LEEDS";// $order->user->name;
                $collectData['PostingDate'] = date('Y-m-d');
                $collectData['SelltoCustomerNo'] = $user->ms_number;
                $collectData['Status'] = "Open";
                $collectData['YourReference'] = "Click & Collect";
                $collectData['postingno'] = "CC-".$sale->id;
                $collectData['posnotes'] = null;
                $collectData['ExtDocumentNo'] = "WEB".$sale->id;
                $collectData['PaymentTerms'] = "";
                $collectData['Source'] = "Click & Collect";
                $dateToFormat = strtotime($extra['pickup_date']);
                $dateToFormat = date('Y-m-d',$dateToFormat);

                $collectionTime = date("H:i:s", strtotime($extra['selectedSlot']));
                $collectData['CollectionTime'] = $collectionTime;
                $collectData['CollectionDate'] = $dateToFormat;
                foreach($webItems as $item){
                    $itemDataCC['DocumentType'] = "Order";
                    $itemDataCC['Type'] = "Item";
                    $itemDataCC['PostingDate'] = date('Y-m-d');
                    $itemDataCC['No'] = $item['ms_id'];
                    $itemDataCC['Quantity'] = $item['quantity'];
                    $itemDataCC['UnitofMeasureCode'] = "SINGLE";
                    $itemDataCC['LocationCode'] = "LDS";// $order->warehouse->name;
                    $itemDataCC['UnitPrice'] = $item['price'];
                    $collectData['cclines'][] = $itemDataCC;
                }
                // dd($collectData);
              //  dispatch(new DynamicsCCOrders($collectData, $user));
            }else{
              //  dispatch(new DynamicsCreateOrder($sale_data, $user));
            }
            // dispatch(new DynamicsCreateOrder($sale_data, $user));
            // $api->order($sale_data, $user);
        } catch(\Throwable $e){
            \Log::info($e->getMessage());
            return response()->json(['message'=>["Something went wrong from the server"]], 400);
        }

        return response()->json(['message'=>"Order Successfully saved", 'data'=>$sale]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getAvailableSlots(Request $request)
    {
        \Log::info($request->all());
        $user = Auth::user();

        $available_slots = Slots::getAvailableSlots($request->date, $request->time, 10, $user->warehouse);

        return response()->json($available_slots);
    }

    public function checkout($id){
        $sale = Sale::find($id);
        return view('mobile.checkout', compact('sale'));
    }
}
