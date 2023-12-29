<?php

namespace App\Jobs;

use App\Product;
use App\Product_price;
use App\ProductPricingManagement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AssignBranchProductPrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $items;
    protected $companyid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($items,$companyid)
    {
        $this->items = $items;
        $this->companyid= $companyid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $items = $this->items;
       
         //
        $company_id= $this->companyid;
        $count = 0;
        try {
            foreach($items as $item){
                // dd($item->Product_No);
              //  $data='';
                $test= 'looptest';
                
                if($item->Unit_of_Measure_Code == 'SINGLE'){
                    $product = Product::where('ms_id', $item->Product_No)->first();
                   // $product_price = Product_price::where('product_ms_id', $item->Product_No)->first();
                    if(!$product){
                      //  \Log::info('log check',[json_encode($test)]);
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
                        ProductPricingManagement::updateOrCreate(
                            ['product_ms_id' => $item->Product_No,'user_id'=>$company_id],
                            ['product_id' => $create->id,
                            'price' => number_format((float)$item->Unit_Price,2,'.', '')]
                        );
                    }else{
                        if($item->VAT_Prod_Posting_Group == 'STANDARD'){
                            $tax_id = 1;
                        }else{
                            $tax_id = 2;
                        }
                        ProductPricingManagement::updateOrCreate(
                            ['product_ms_id' => $item->Product_No,'user_id'=>$company_id],
                            ['product_id' =>  $product->id,
                            'price' => number_format((float)$item->Unit_Price,2,'.', '')]
                        );
                    }
                    $count++;
                }
                elseif ($item->Unit_of_Measure_Code == 'CASE') {
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
                        ProductPricingManagement::updateOrCreate(
                            ['product_ms_id' => $item->Product_No,'user_id'=>$company_id],
                            ['product_id' =>  $create->id,
                            'p_price' => number_format((float)$item->Unit_Price,2,'.', '')]
                        );
                    }else{
                        if($item->VAT_Prod_Posting_Group == 'STANDARD'){
                            $tax_id = 1;
                        }else{
                            $tax_id = 2;
                        }
                        //Product::where('ms_id', $item->Product_No)->update(['p_price'=> number_format((float)$item->Unit_Price,2,'.', ''),'tax_id'=>$tax_id,  'name' => $item->Description,'StartingDate'=>$item->StartingDate,'EndingDate'=>$item->EndingDate]);
                        ProductPricingManagement::updateOrCreate(
                            ['product_ms_id' => $item->Product_No,'user_id'=>$company_id],
                            ['product_id' =>  $product->id,
                            'p_price' => number_format((float)$item->Unit_Price,2,'.', '')]
                        );
                    }

                    $count++;
                }
                else{
                    echo 'echo blank else true';
                }
                //break;
            }
            echo $count;
            \Log::info('Price assign to branch by Crone ',[json_encode($count)]);
        } catch (\Throwable $th) {
            \Log::info('Price error Crone ',[json_encode($th)]);
        }
    }
}
