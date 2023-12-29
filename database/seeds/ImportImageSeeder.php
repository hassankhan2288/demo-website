<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Product;

class ImportImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = file_get_contents(public_path("import/products_images.json"), true);
        $data = json_decode($data);
        foreach($data as $datum){
            $image = "";
            if($datum->images1){
                $image = str_replace("Document-Uploads/","images/product/",$datum->images1);
            }
            if($datum->images2){
                $image .= ",".str_replace("Document-Uploads/","images/product/",$datum->images2);
            }
            if($datum->images3){
                $image .= ",".str_replace("Document-Uploads/","images/product/",$datum->images3);
            }
            if($datum->images4){
                $image .= ",".str_replace("Document-Uploads/","images/product/",$datum->images4);
            }
            if($datum->images5){
                $image .= ",".str_replace("Document-Uploads/","images/product/",$datum->images5);
            }
            $product = Product::find($datum->product_id);
            if($product){
                $product->image = rtrim($image,",");
                $product->save();
            }
           
        }
    }
}
