<?php

namespace App\Jobs;

use App\Product;
use App\Product_price;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CroneUpdateProductPrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $items;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $items = $this->items;
        $count = 0;
        try {
            foreach($items as $item){
                // dd($item->Product_No);
              //  $data='';

                if($item->Unit_of_Measure_Code == 'SINGLE' && $item->SourceNo == 'LDS WEB C'){
                    $product = Product::where('ms_id', $item->Product_No)->first();
                    $product_price = Product_price::where('product_ms_id', $item->Product_No)->first();
                    if(!$product){
                        $data['name'] = $item->Description;
                        $data['slug'] = str_replace(' ','-',strtolower($item->Description));
                        $slu_count = Product::where('slug', $data['slug'])->count();
                        if($slu_count >= 0){
                            $slu_count++;
                            $data['slug'] = $data['slug'].'-'.$slu_count;
                        }
                        $data['code'] = $item->Product_No;
                        $data['ms_id'] = $item->Product_No;
                        $data['price']  = number_format((float)$item->Unit_Price,2,'.', '');
                        $data['p_price'] =0;
                        $data['cost'] = 0;
                        $data['brand_id']=1;
                        $data['category_id']=258;// using static category id for new products
                        $data['is_active'] = 0;
                        if($item->VAT_Prod_Posting_Group == 'STANDARD'){
                            $data['tax_id'] = 1;
                        }else{
                            $data['tax_id'] = 2;
                        }
                        $create = Product::create($data);
                        Product_price::updateOrCreate(
                            ['product_ms_id' => $item->Product_No],
                            [
                            'price' => number_format((float)$item->Unit_Price,2,'.', ''),
                            'warehouse_id' => 7 //where house id staticly 7 is birmingham
                            ]
                        );
                    }else{
                        if($item->VAT_Prod_Posting_Group == 'STANDARD'){
                            $tax_id = 1;
                        }else{
                            $tax_id = 2;
                        }

                        Product::where('ms_id', $item->Product_No)->update(['price'=> number_format((float)$item->Unit_Price,2,'.', ''),'tax_id'=>$tax_id, 'name' => $item->Description,'StartingDate'=>$item->StartingDate,'EndingDate'=>$item->EndingDate]);
                        Product_price::updateOrCreate(
                            ['product_ms_id' => $item->Product_No],
                            [
                            'price' => number_format((float)$item->Unit_Price,2,'.', ''),
                            'warehouse_id' => 7 //where house id staticly 7 is birmingham
                            ]
                        );
                    }
                    $count++;
                }
                elseif ($item->Unit_of_Measure_Code == 'CASE' && $item->SourceNo == 'LDS WEB C') {
                    $product = Product::where('ms_id', $item->Product_No)->first();
                    if(!$product){
                        $data['name'] = $item->Description;
                        $data['slug'] = str_replace(' ','-',strtolower($item->Description));
                        $slu_count = Product::where('slug', $data['slug'])->count();
                        if($slu_count >= 0){
                            $slu_count++;
                            $data['slug'] = $data['slug'].'-'.$slu_count;
                        }
                        $data['code'] = $item->Product_No;
                        $data['ms_id'] = $item->Product_No;
                        $data['p_price']  = number_format((float)$item->Unit_Price,2,'.', '');
                        $data['price']  = 0;
                        $data['cost'] = 0;
                        $data['brand_id']=1;
                        $data['category_id']=258;// using static category id for new products
                        $data['is_active'] = 0;
                       
                        if($item->VAT_Prod_Posting_Group == 'STANDARD'){
                            $data['tax_id'] = 1;
                        }else{
                            $data['tax_id'] = 2;
                        }
                        $create = Product::create($data);
                        Product_price::updateOrCreate(
                            ['product_ms_id' => $item->Product_No],
                            [
                            'p_price' => number_format((float)$item->Unit_Price,2,'.', ''),
                            'warehouse_id' => 7 //where house id staticly 7 is birmingham
                            ]
                        );
                    }else{
                        if($item->VAT_Prod_Posting_Group == 'STANDARD'){
                            $tax_id = 1;
                        }else{
                            $tax_id = 2;
                        }
                        Product::where('ms_id', $item->Product_No)->update(['p_price'=> number_format((float)$item->Unit_Price,2,'.', ''),'tax_id'=>$tax_id,  'name' => $item->Description,'StartingDate'=>$item->StartingDate,'EndingDate'=>$item->EndingDate]);
                        Product_price::updateOrCreate(
                            ['product_ms_id' => $item->Product_No],
                            [
                            'p_price' => number_format((float)$item->Unit_Price,2,'.', ''),
                            'warehouse_id' => 7 //where house id staticly 7 is birmingham
                            ]
                        );
                    }

                    $count++;
                }
                elseif ($item->Unit_of_Measure_Code == 'SINGLE' && $item->SourceNo == 'LDS WEB D') {
                    $product = Product::where('ms_id', $item->Product_No)->first();
                    if(!$product){
                        $data['name'] = $item->Description;
                        $data['slug'] = str_replace(' ','-',strtolower($item->Description));
                        $slu_count = Product::where('slug', $data['slug'])->count();
                        if($slu_count >= 0){
                            $slu_count++;
                            $data['slug'] = $data['slug'].'-'.$slu_count;
                        }
                        $data['code'] = $item->Product_No;
                        $data['ms_id'] = $item->Product_No;
                        $data['delivery_single']  = number_format((float)$item->Unit_Price,2,'.', '');
                        $data['delivery_pack']=0;
                        $data['price']  = 0;
                        $data['cost'] = 0;
                        $data['brand_id']=1;
                        $data['category_id']=258;// using static category id for new products
                        $data['is_active'] = 0;
                        if($item->VAT_Prod_Posting_Group == 'STANDARD'){
                            $data['tax_id'] = 1;
                        }else{
                            $data['tax_id'] = 2;
                        }
                        $create = Product::create($data);
                        Product_price::updateOrCreate(
                            ['product_ms_id' => $item->Product_No],
                            [
                            'delivery_single' => number_format((float)$item->Unit_Price,2,'.', ''),
                            'warehouse_id' => 7 //where house id staticly 7 is birmingham
                            ]
                        );
                    }else{
                        if($item->VAT_Prod_Posting_Group == 'STANDARD'){
                            $tax_id = 1;
                        }else{
                            $tax_id = 2;
                        }
                        Product::where('ms_id', $item->Product_No)->update(['delivery_single'=> number_format((float)$item->Unit_Price,2,'.', ''), 'tax_id'=>$tax_id, 'name' => $item->Description]);
                        Product_price::updateOrCreate(
                            ['product_ms_id' => $item->Product_No],
                            [
                            'delivery_single' => number_format((float)$item->Unit_Price,2,'.', ''),
                            'warehouse_id' => 7 //where house id staticly 7 is birmingham
                            ]
                        );
                    }

                    $count++;
                }
                elseif ($item->Unit_of_Measure_Code == 'CASE' && $item->SourceNo == 'LDS WEB D') {
                    $product = Product::where('ms_id', $item->Product_No)->first();
                    if(!$product){
                        $data['name'] = $item->Description;
                        $data['slug'] = str_replace(' ','-',strtolower($item->Description));
                        $slu_count = Product::where('slug', $data['slug'])->count();
                        if($slu_count >= 0){
                            $slu_count++;
                            $data['slug'] = $data['slug'].'-'.$slu_count;
                        }
                        $data['code'] = $item->Product_No;
                        $data['ms_id'] = $item->Product_No;
                        $data['delivery_pack']  = number_format((float)$item->Unit_Price,2,'.', '');
                        $data['delivery_single']=0;
                        $data['price']  = 0;
                        $data['cost'] = 0;
                        $data['brand_id']=1;
                        $data['category_id']=258;// using static category id for new products
                        $data['is_active'] = 0;
                        if($item->VAT_Prod_Posting_Group == 'STANDARD'){
                            $data['tax_id'] = 1;
                        }else{
                            $data['tax_id'] = 2;
                        }
                        $create = Product::create($data);
                        Product_price::updateOrCreate(
                            ['product_ms_id' => $item->Product_No],
                            [
                            'delivery_pack' => number_format((float)$item->Unit_Price,2,'.', ''),
                            'warehouse_id' => 7 //where house id staticly 7 is birmingham
                            ]
                        );
                    }else{
                        if($item->VAT_Prod_Posting_Group == 'STANDARD'){
                            $tax_id = 1;
                        }else{
                            $tax_id = 2;
                        }
                        Product::where('ms_id', $item->Product_No)->update(['delivery_pack'=> number_format((float)$item->Unit_Price,2,'.', ''),'tax_id'=>$tax_id, 'name' => $item->Description]);
                        Product_price::updateOrCreate(
                            ['product_ms_id' => $item->Product_No],
                            [
                            'delivery_pack' => number_format((float)$item->Unit_Price,2,'.', ''),
                            'warehouse_id' => 7 //where house id staticly 7 is birmingham
                            ]
                        );
                     }

                    $count++;
                }
                else{
                    echo 'echo blank else true';
                }
            }
            echo ' finished cron_'.$count;
            \Log::info('Price Update Crone ',[json_encode($count)]);
        } catch (\Throwable $th) {
            \Log::info('Price Update Crone ',[json_encode($th)]);
        }
    }
}
