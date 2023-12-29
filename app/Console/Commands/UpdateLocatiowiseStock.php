<?php

namespace App\Console\Commands;

use App\Jobs\CroneUpdateProductPrice;
use App\Product;
use App\Services\MSDynamic;
use App\Stock;
use App\Warehouse;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateLocatiowiseStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:location_stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all the stock of products locally after pulling from dynamics API';

    protected $company = '';
    protected $environment = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->company = config("msdynamic.company_id");
        $this->environment = config("msdynamic.environment");
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $api = new MSDynamic();
        $stocks = $api->getLocationWiseStock();
        $stocks1 = $stocks->value;
       // var_dump($stocks);
        if(!empty($stocks1)){
          //  echo 'ss';
            foreach($stocks1 as $stock){
                // dd($stock->Location_Code);
                $warehouse = Warehouse::where('name',$stock->Location_Code)->first();
                $product = Product::where('ms_id', $stock->Item_No_)->first();
                if($warehouse && $product) {
                    $warehouse_check = Stock::where('warehouse_id', $warehouse->id)->where('product_id', $product->id)->first();

                    if(isset($warehouse_check->stocks)){
                        if($stock->Remaining_Quantity != $warehouse_check->stocks) {
                       // echo 'faisal___ ';
                       Stock::where('warehouse_id', $warehouse->id)->where('product_id', $product->id)->update(['stocks' => $stock->Remaining_Quantity]);
                        }
                    } else {
                      //  echo 'ahmed___ ';
                        Stock::create(['product_id' => $product->id, 'warehouse_id' => $warehouse->id, 'stocks' => $stock->Remaining_Quantity, 'is_active' => 1]);
                    }

                }
            }
            \Log::info('Cron called');
        }
    }
}
