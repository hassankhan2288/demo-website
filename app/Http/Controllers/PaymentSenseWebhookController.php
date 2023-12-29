<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Jobs\DynamicsCCOrders;
use App\Jobs\DynamicsCreateDeliveryOrder;
use App\Jobs\DynamicsPaymentJob;
use App\Jobs\MailInvoiceJob;
use App\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentSenseWebhookController extends Controller
{
    public function __construct()
    {

    }

    /**
     * [__invoke description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function __invoke(Request $request){

        $data = $request->getContent();

        $data = json_decode($data);
        \Log::info('This is HOOK info: ',[$data]);
        //https://e.test.connect.paymentsense.cloud/v1/payments/WEV2IGFzt-yOb1bAQFv5gByq38zz1OdMdyvIXHHJdn7CRzBrdd9VZJNdwhAKMW0b-ar6KDJMFivr6NlKiimxljV6kXDC2pCAVoJT6SoEP5GzrmwvPg6EIe7FKE2Bn83HHkd8S4pxSrksSCl6cg%3D%3D
       
        $endpoint = "https://e.connect.paymentsense.cloud/v1/payments/".$data->id;
        $jwt_token = config('paymentsense.jwt_token');
        $getstatus =  Http::withHeaders([
            'authorization' => $jwt_token,
            'content-type' => 'application/json'
        ])->get($endpoint)->body();
        $status = json_decode($getstatus);
        if($status->statusCode == 0)
        {

            $sale = Sale::where('reference_no',$data->merchantTransactionId)->first();
            $user = Customer::where('id',$sale->customer_id)->first();
            \Log::info('This is the HELPERS SALE FROM DB', [$sale]);
            $DynamicData = \Helper::makeDynamicsJobData($sale,$user);
            \Log::info('This is the HELPERS new Data', [$DynamicData]);
            if($sale->pick_time == null){
                dispatch(new DynamicsCreateDeliveryOrder($DynamicData['collectData'],$sale->id));
                dispatch(new DynamicsPaymentJob($DynamicData['payment']));
            }else{
                dispatch(new DynamicsCCOrders($DynamicData['collectData'],$sale->id));
                dispatch(new DynamicsPaymentJob($DynamicData['payment']));
            }
            $dataMsg = ['msg' => 'Your order has been recieved.%0D Thank you for placing your order with us. We\'re excited to fulfil your request. Below you\'ll find the details of your order, along with the attached invoice for your reference.', 'name' => $user->name];
            dispatch(new MailInvoiceJob($dataMsg, $sale->id, $user->email));


            if($sale){
                $sale->payment_status = "success";
                // $sale->ms_order_id = $data->orderId;
                $sale->save();
                return response()->json($data->merchantTransactionId, 200);
            }
         }
    
        return response()->json($data->merchantTransactionId, 404);

        
        
    }
}
