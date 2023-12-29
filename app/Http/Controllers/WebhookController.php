<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Product;

class WebhookController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->getContent();
        
        $payload = getAccessToken();
        $items = json_decode($data);
        if(isset($items->value)){
            foreach($items->value as $item){
                $result =  Http::withToken($payload['access_token']??"")->get($item->resource)->body();
                \Log::info($result);
                $product = json_decode($result);
                if($product){
                    $setting = Product::updateOrCreate(
                    ['ms_id' =>  $product->number],
                    [
                        'name' => $product->displayName,
                        'code' => $product->itemCategoryCode,
                        'code' => $product->itemCategoryCode,
                        'type' => "standard",
                        'cost' => $product->unitCost,
                        'price' => $product->unitPrice,
                        'qty' => $product->inventory,
                    ]
                );
                }
                
                
            }
        }
        return $request->validationToken;
    }
}
