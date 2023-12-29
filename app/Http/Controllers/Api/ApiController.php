<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Banner;
use App\Brand;
use App\Category;
use App\Jobs\CroneUpdateProductPrice;
use App\Product_Sale;
use App\Services\MSDynamic;
use App\Stock;
use App\Warehouse;

class ApiController extends Controller
{
    //
    public function products()
    {
        $products = Product::with('category', 'brand', 'unit')
                        //->offset($start)
                        ->where('is_active', true)
                       // ->limit($limit)
                       // ->orderBy($order,$dir)
                        ->get()->toArray();

                        return $products;
    }

    public function banners()
    {
        $banners = Banner::
        //with('category', 'brand', 'unit')
                        //->offset($start)
                       // ->where('is_active', true)
                       // ->limit($limit)
                       // ->orderBy($order,$dir)
                        get()->toArray();

                        return $banners;
    }

    public function brands()
    {
        $brand = Brand::get()->toArray();

                        return $brand;
    }

    public function categories()
    {
        $brand = Category::get()->toArray();

                        return $brand;
    }

    public function productSales(){
        $productsales = Product_Sale::with('product')
                        //->offset($start)
                       // ->where('is_active', true)
                       // ->limit($limit)
                       // ->orderBy($order,$dir)
                        ->get()->toArray();

                        return $productsales;

    }

    public function productPriceUpdate(){
        $response = getAccessToken(); 

        $company = config("msdynamic.company_id");
        $environment = config("msdynamic.environment");

        // $result =  \Http::withToken($response['access_token']??"")->get("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/ICSProdCopy_23032023/ODataV4/Company('ICS%20UK%20LIMITED%20COPY%2005122022')/SalesPrice?\$expand=SalesPriceLines")->body();
        // $result =  \Http::withToken($response['access_token']??"")->get("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$environment/ODataV4/Company('My%20Company')/SalesPrice?\$expand=SalesPriceLines")->body();
        $result =  \Http::withToken($response['access_token']??"")->get("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/Production/ODataV4/Company('My%20Company')/SalesPrice?\$expand=SalesPriceLines")->body();
        $result = json_decode($result);
        // $items = collect($result->value);
        // dd($items[4]);
        $items = collect($result->value);
        $itemsO = $items[3]->SalesPriceLines;
        // dd($items);
        dispatch(new CroneUpdateProductPrice($itemsO));
        $itemsD = $items[4]->SalesPriceLines;
        dispatch(new CroneUpdateProductPrice($itemsD));
        return true;
    }

    public function LocationWiseStock(){
        $api = new MSDynamic();
        $stocks = $api->getLocationWiseStock();
        $stocks = $stocks->value;
        if(!empty($stocks)){
            foreach($stocks as $stock){
                // dd($stock->Location_Code);
                $warehouse = Warehouse::where('name',$stock->Location_Code)->first();
                $product = Product::where('ms_id', $stock->Item_No_)->first();
                if(($warehouse && $product) && $stock->Remaining_Quantity != $warehouse->stocks){
                    $warehouse_check = Stock::where('warehouse_id',$warehouse->id)->where('product_id',$product->id)->first();
                    if($warehouse_check){
                        Stock::where('warehouse_id',$warehouse->id)->where('product_id',$product->id)->update(['stocks' => $stock->Remaining_Quantity]);
                    }else{
                        Stock::create(['product_id' => $product->id, 'warehouse_id' => $warehouse->id, 'stocks' => $stock->Remaining_Quantity, 'is_active' => 1 ]);
                    }
                }
            }
            \Log::info('Cron called');
        }
    }


    public function payment(Request $request){
        echo $request->all();
    }
}
