<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;

class PaymentWebhookController extends Controller
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

        $sale = Sale::find($data->merchantTransactionId);

        if($sale){
            $sale->payment_status = "success";
            $sale->save();
        }
    
        return response()->json($data->merchantTransactionId, 200);

        
        
    }

}
