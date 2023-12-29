<?php

namespace App\Http\Controllers\Front;

use App\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
use App\Customer;
use App\Order;
use App\Shipping;
use App\User;
use App\Sale;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
use App\Product_Sale;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Pos\SaleController;
use App\Jobs\DynamicsCCOrders;
use App\Jobs\DynamicsCreateDeliveryOrder;
use App\Jobs\DynamicsCreateOrder;
use App\Jobs\DynamicsPaymentJob;
use App\Jobs\MailInvoiceJob;
use App\Services\MSDynamic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CaterMail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $period = new CarbonPeriod('09:00', '30 minutes', '17:00'); // for create use 24 hours format later change format
        $slots = [];
        foreach($period as $item){
            array_push($slots,$item->format("h:i A"));
        }
        $orders=Order::orderBy('id','DESC')->paginate(10);
        return view('backend.order.index',compact('orders','slots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         
        $this->validate($request,[
            // 'first_name'=>'string|required',
            // 'last_name'=>'string|required',
            'address1'=>'string|nullable',
            // 'address2'=>'string|nullable',
            'coupon'=>'nullable|numeric',
            'phone'=>'numeric|nullable',
            'post_code'=>'string|nullable',
            'email'=>'string|required_if:payment_method,delivery',

            'pick_time'=>'required_if:payment_method,self',
            'pick_date'=>'required_if:payment_method,self',
            'delivery_date'=>'required_if:payment_method,delivery'
        ]);
       //echo config('msdynamic.app_env');
        if(empty(Cart::where('user_id',\Auth::guard('customer')->user()->id)->where('order_id',null)->first())){
            request()->session()->flash('error','Cart is Empty !');
            return back();
        }

        try {

            DB::beginTransaction();
            $sale_data = [];

            // dd($request->all());
            $order=new Sale();
            if(request('payment_method') =='self' || isset($request->pick_time)){
                $checkAvailability = $order->checkSlotsAvailability(\Auth::guard('customer')->user()->warehouse, $request->pick_time, $request->pick_date);
                if(!$checkAvailability){
                    request()->session()->flash('error','Slot is full');
                    return back();
                }
            }
            $order_data=$request->all();
            // $order_data['reference_no']='ORD-'.strtoupper(Str::random(10));
            if(!$request->reference_no){
                $reference_no = "ORD-".now();
            }else{
                $reference_no = $request->reference_no;
            }
            $order_data['reference_no']=$reference_no;
            // $order_data['payment_token'] = $request->paymensense_token;
            $order_data['total_tax'] = Helper::totalCartVatPrice();
            $order_data['customer_id']=\Auth::guard('customer')->user()->id;
            if($order_data['customer_id'] != null){
                $user = \Auth::guard('customer')->user();
                $branch = Branch::where('email',$user->email)->first();
                if(isset($branch->user_id)){
                    $order_data['user_id'] = $branch->user_id;
                    $order_data['branch_id'] = $branch->id;
                }else{
                    $order_data['user_id'] = 0;
                    $order_data['branch_id'] = 0;
                }


            }
           
            $order_data['item']=Helper::cartCount();
            $order_data['total_qty']=Helper::cartCountQuantity();
            if(session('coupon')){
               // $order_data['coupon']=session('coupon')['value'];
            }
            if($request->shipping == 67){
                if(session('coupon')){
                    //$order_data['total_amount']=Helper::totalCartPrice()+$shipping[0]-session('coupon')['value'];
                    $order_data['total_price']=Helper::totalCartPrice()+$shipping[0]-session('coupon')['value'];
                }
                else{
                    //$order_data['total_amount']=Helper::totalCartPrice()+$shipping[0];
                    $order_data['total_price']=Helper::totalCartPrice()+$shipping[0];
                }
            }
            else{
                if(session('coupon')){
                    //$order_data['total_amount']=Helper::totalCartPrice()-session('coupon')['value'];
                    $order_data['total_price']=Helper::totalCartPrice()-session('coupon')['value'];
                }
                else{
                    //$order_data['total_amount']=Helper::totalCartPrice();
                    $order_data['total_price']=Helper::totalCartPrice();
                }
            }
            // return $order_data['total_amount'];
            $order_data['product_cost']=$order_data['total_price'];
            if(request('payment_method') =='delivery'){
                $delivery_charges = Helper::getDeliveryCharges(\Auth::guard('customer')->user()->id,\Auth::guard('customer')->user()->warehouse);
                if($delivery_charges){
                    $order_data['delivery_charges'] = $delivery_charges;
                    $order_data['grand_total']= $order_data['total_price'] + $delivery_charges + $order_data['total_tax'];
                    $order_data['paid_amount']= $order_data['total_price'] + $delivery_charges + $order_data['total_tax'];
                }else{
                    $order_data['grand_total']= $order_data['total_price'] + $order_data['total_tax'];
                    $order_data['paid_amount']= $order_data['total_price'] + $order_data['total_tax'];
                }
            }else{
                $order_data['grand_total']= $order_data['total_price'] + $order_data['total_tax'];
                $order_data['paid_amount']= $order_data['total_price'] + $order_data['total_tax'];
                $order_data['delivery_charges'] = 0;
            }
            $order_data['sale_status']=1;
            if($request->paid_by == "card"){
                $order_data['payment_status']="Pending";
            }else{
                $order_data['payment_status']="Pending";
            }
            $order_data['address2']=$request->address2;
            if(isset($request->address3)){
                $order_data['address3']=$request->address3;
            }
            $order_data['status']="Website";
          
            $order_data['order_type']= $request->payment_method;
            $order_data['warehouse_id']= \Auth::guard('customer')->user()->warehouse;
            //$order_data['pick_date']=$request->pick_date;
            //$order_data['pick_time']=$request->pick_time;
            if($request->payment_method =='delivery'){
                $order_data['pick_date']= null;
                $order_data['pick_time']= null;
                $order_data['delivery_date']= $request->delivery_date;
              //  $order_data['payment_method']='self';
              //  $order_data['payment_status']='Unpaid';
            }
            // else{
               // $order_data['payment_method']='cod';
               // $order_data['payment_status']='Unpaid';
            // }
            //dd($order_data);
            $order->fill($order_data);
            
            $status=$order->save();
            
            if(isset($request->address2)){
                $customer = Customer::where('id',\Auth::guard('customer')->user()->id)->update(['address_2' => $request->address2]);
            }
            if(isset($request->address3)){
                $customer3 = Customer::where('id',\Auth::guard('customer')->user()->id)->update(['address_3' => $request->address3]);
            }
            if(isset($request->address)){
                $customer2 = Customer::where('id',\Auth::guard('customer')->user()->id)->update(['address' => $request->address1]);
            }


            if($order){
                $items = Cart::where('user_id',\Auth::guard('customer')->user()->id)->where('order_id',null)->get();
                $webItems = $items;
                foreach($items as $item){
                    $itemData['sale_id'] = $order->id;
                    $itemData['product_id'] = $item->product_id;
                    $itemData['qty'] = $item->quantity;
                    $itemData['net_unit_price'] = $item->price;
                    $itemData['total'] = $item->amount;
                    $itemData['sale_unit_id'] = 0;
                    $itemData['discount'] = 0;
                    $itemData['tax_rate'] = 0;
                    $itemData['tax'] = $item->vat;
                    $itemData['type'] = $item->type;
                    // $itemData['uom'] = $item->type;
                    $sale_data[] = $itemData;
                    $NewItem = Product_Sale::create($itemData);
                }
                session()->forget('cart');
                session()->forget('coupon');
            }
            //Payment array
            $payment['TransactionDate'] = date('Y-m-d');
            $payment['DocumentType'] ="Invoice";
            $payment['CustomerNo'] = \Auth::guard('customer')->user()->ms_number;
            $payment['CustomerName'] = \Auth::guard('customer')->user()->name;
            $payment['PaymentAgainst'] = "";
            $payment['Amount'] = $order_data['total_price'] + $order_data['total_tax'];
            $payment['Cash'] = 0;
            $payment['Card'] = $order_data['total_price'] + $order_data['total_tax'] ;
            $payment['Cheque'] = 0;
            $payment['BankTransfer'] = 0;
            $payment['Others'] = 0;
            $payment['CreditMemo'] = 0;
            $payment['Total'] = $order_data['total_price'] + $order_data['total_tax'];
            //Payment array end
            switch ($order->warehouse->name) {
                case 'BFD':
                    // $salespersonCode = "BFD MANGR";
                    $resposibilityCenter = "BRADFORD";
                    // $customerPriceGroup = "BFD CC";
                    break;
                case 'BDC':
                    // $salespersonCode = "BDC MANGR";
                    $resposibilityCenter = "JACKSON ST";
                    // $customerPriceGroup = "BELLA PIZZ";
                    break;
                case 'BOL':
                    // $salespersonCode = "BOL MANGR";
                    $resposibilityCenter = "BOLTON";
                    // $customerPriceGroup = "BOL CC";
                    break;
                case 'DIS':
                    // $salespersonCode = "DIST MANGR";
                    $resposibilityCenter = "JACKSON ST";
                    // $customerPriceGroup = "DISTRIBUT";
                    break;
                case 'LDS':
                    // $salespersonCode = "LDS MANGR";
                    $resposibilityCenter = "LEEDS";
                    // $customerPriceGroup = "LDS CC";
                    break;
                case 'SHE':
                    // $salespersonCode = "SHEFF MANG";
                    $resposibilityCenter = "JACKSON ST";
                    // $customerPriceGroup = "SHEFFIELD";
                    break;
                case 'BIR':
                    // $salespersonCode = "BIR MAN";
                    // $resposibilityCenter = "BIRMINGHAM";
                    $resposibilityCenter = "BIRG";
                    // $customerPriceGroup = "BARNIS";
                    break;
                default:
                    // $salespersonCode = "LEEDS MANG";
                    $resposibilityCenter = "LEEDS";
                    // $customerPriceGroup = "LDS CC";
                    break;
            }
            $current_time = \Carbon\Carbon::now()->timestamp;
            $orderid= $order->id.'-'.$current_time;
            if(request('payment_method') =='self'){                   // Click & Collect
                $collectData['HeaderNo'] = $orderid;
                $collectData['DocumentType'] = "order";
                $collectData['LocationCode'] = $order->warehouse->name;
                $collectData['ResponsibilityCenter'] =  $resposibilityCenter;
                $collectData['PostingDate'] = date('Y-m-d');
                $collectData['SelltoCustomerNo'] = \Auth::guard('customer')->user()->ms_number;
                $collectData['Status'] = "Open";
                $collectData['YourReference'] = "Click & Collect";
                $collectData['postingno'] = "CC-".$orderid;
                $collectData['posnotes'] = null;
                $collectData['ExtDocumentNo'] = $orderid;
                $collectData['PaymentTerms'] = "PREPAID";
                $collectData['Source'] = "Click & Collect";
                $dateToFormat = strtotime($request->pick_date);
                $dateToFormat = date('Y-m-d',$dateToFormat);

                // $collectionTime = date(DATE_ATOM,strtotime($dateToFormat." ".$request->pick_time));
                $collectionTime = date("H:i:s", strtotime($request->pick_time));
                $collectData['CollectionTime'] = $collectionTime;
                $collectData['CollectionDate'] = $dateToFormat;
                $collectData['PaymentTerms'] = "PREPAID";
                // $collectionTime = substr($collectionTime, 0, strpos($collectionTime, '+'));
                // $collectionTime = str_replace("UTC", "T", $collectionTime);
                // $collectData['CollectionTime'] = $collectionTime."Z";//"2023-01-01T13:00:00Z";
                foreach($webItems as $item){
                    $itemDataCC['DocumentType'] = "Order";
                    $itemDataCC['Type'] = "Item";
                    $itemDataCC['PostingDate'] = date('Y-m-d');
                    $itemDataCC['No'] = $item->product->ms_id;
                    $itemDataCC['Quantity'] = $item->quantity;
                    $itemDataCC['UnitofMeasureCode'] = $item->type;
                    $itemDataCC['LocationCode'] = $order->warehouse->name;
                    $itemDataCC['UnitPrice'] = $item->price;
                    $collectData['cclines'][] = $itemDataCC;
                }
                $payment['No'] = $orderid;
                $payment['ExtDocumentNo'] = $orderid;
                $payment['Source'] = "Click & Collect";
                // dd(json_encode($collectData));
                \Log::info('This is Click & Collect', [json_encode($collectData)]);
                // dispatch(new DynamicsCCOrders($collectData,$order->id));
                // dispatch(new DynamicsPaymentJob($payment));
            }elseif(request('payment_method') =='delivery'){               // Click & Delivery
                $collectData['HeaderNo'] = "WED".$orderid;
                $collectData['DocumentType'] = "Order";
                $collectData['LocationCode'] = $order->warehouse->name;//$order->warehouse->name;
                // $collectData['ResponsibilityCenter'] = "LEEDS";// $order->user->name;
                $collectData['PostingDate'] = date('Y-m-d');
                $collectData['SelltoCustomerNo'] = \Auth::guard('customer')->user()->ms_number;
                $collectData['Status'] = "Open";
                $collectData['YourReference'] = "Click & Delivery";
                $collectData['postingno'] = "WED".$orderid;
                $collectData['posnotes'] = "";
                $collectData['ExternalDocumentNo'] = "WED".$orderid;
                $collectData['PaymentTermsCode'] = "PREPAID";
                $collectData['Source'] = "Click & Delivery";
                // $dateToFormat = strtotime($request->pick_date);
                // $dateToFormat = date('Y-m-d',$dateToFormat);

                // $collectionTime = date(DATE_ATOM,strtotime($dateToFormat." ".$request->pick_time));
                // $collectionTime = date("H:i:s", strtotime($request->pick_time));
                // $collectData['CollectionTime'] = $collectionTime;
                // $collectData['CollectionDate'] = $dateToFormat;
                // $collectionTime = substr($collectionTime, 0, strpos($collectionTime, '+'));
                // $collectionTime = str_replace("UTC", "T", $collectionTime);
                // $collectData['CollectionTime'] = $collectionTime."Z";//"2023-01-01T13:00:00Z";
                foreach($webItems as $item){
                    $itemDataCC['DocumentType'] = "Order";
                    $itemDataCC['Type'] = "Item";
                    // $itemDataCC['PostingDate'] = date('Y-m-d');
                    $itemDataCC['No'] = $item->product->ms_id;
                    $itemDataCC['Quantity'] = $item->quantity;
                    // $itemDataCC['UnitofMeasureCode'] = "SINGLE";//item->type;
                    $itemDataCC['UnitofMeasureCode'] = $item->type;
                    // $itemDataCC['LocationCode'] = $order->warehouse->name;
                    $itemDataCC['UnitPrice'] = $item->price;
                    $collectData['lines'][] = $itemDataCC;
                }
                $payment['No'] = "WED".$orderid;
                $payment['ExtDocumentNo'] = $orderid;
                $payment['Source'] = "Click & Delivery";
                // dd(json_encode($collectData));
                // dispatch(new DynamicsCreateDeliveryOrder($collectData,$order->id));
                // dispatch(new DynamicsPaymentJob($payment));
            }else{
                // dispatch(new DynamicsCreateOrder($sale_data, $user));
            }
            // $data = ['msg' => 'Your order has been recieved.%0D Thank you for placing your order with us. We\'re excited to fulfil your request. Below you\'ll find the details of your order, along with the attached invoice for your reference.', 'name' => \Auth::guard('customer')->user()->name];
            // dispatch(new MailInvoiceJob($data, $order->id, \Auth::guard('customer')->user()->email));

            
            Cart::where('user_id', \Auth::guard('customer')->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);
            DB::commit();
            // Stock::where('user_id', \Auth::guard('customer')->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);

            // dd($users);
            //request()->session()->flash('success','Your product successfully placed in order');
            // return redirect()->route('thankYou')->with('success', 'Your Order is placed successfully.');
            //dd($order_data);
            //return redirect()->route('payment');
           // dd(session()->get('order_id'));
            return redirect()->route('payment')->with([
                'success' => 'Order Saved, Please pay to complete order.',
                'order_id' => $order->id,
                'reference_no' => $orderid,
                'order_type' => $request->payment_method
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('cart')->with('error', 'Fatal Error '.$th);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order=Order::find($id);
        // return $order;
        return view('backend.order.show')->with('order',$order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order=Order::find($id);
        return view('backend.order.edit')->with('order',$order);
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
        $order=Order::find($id);
        $this->validate($request,[
            'status'=>'required|in:new,process,delivered,cancel'
        ]);
        $data=$request->all();
        // return $request->status;
        if($request->status=='delivered'){
            foreach($order->cart as $cart){
                $product=$cart->product;
                // return $product;
                $product->stock -=$cart->quantity;
                $product->save();
            }
        }
        $status=$order->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated order');
        }
        else{
            request()->session()->flash('error','Error while updating order');
        }
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order=Order::find($id);
        if($order){
            $status=$order->delete();
            if($status){
                request()->session()->flash('success','Order Successfully deleted');
            }
            else{
                request()->session()->flash('error','Order can not deleted');
            }
            return redirect()->route('order.index');
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    public function orderTrack(){
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request){
        // return $request->all();
        $order=Order::where('user_id',auth()->user()->id)->where('order_number',$request->order_number)->first();
        if($order){
            if($order->status=="new"){
            request()->session()->flash('success','Your order has been placed. please wait.');
            return redirect()->route('home');

            }
            elseif($order->status=="process"){
                request()->session()->flash('success','Your order is under processing please wait.');
                return redirect()->route('home');

            }
            elseif($order->status=="delivered"){
                request()->session()->flash('success','Your order is successfully delivered.');
                return redirect()->route('home');

            }
            else{
                request()->session()->flash('error','Your order canceled. please try again');
                return redirect()->route('home');

            }
        }
        else{
            request()->session()->flash('error','Invalid order numer please try again');
            return back();
        }
    }

    // PDF generate
    public function pdf(Request $request){
        $order=Order::getAllOrder($request->id);
        // return $order;
        $file_name=$order->order_number.'-'.$order->first_name.'.pdf';
        // return $file_name;
        $pdf=PDF::loadview('backend.order.pdf',compact('order'));
        return $pdf->download($file_name);
    }
    // Income chart
    public function incomeChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        // dd($year);
        $items=Order::with(['cart_info'])->whereYear('created_at',$year)->where('status','delivered')->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
            // dd($items);
        $result=[];
        foreach($items as $month=>$item_collections){
            foreach($item_collections as $item){
                $amount=$item->cart_info->sum('amount');
                // dd($amount);
                $m=intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
