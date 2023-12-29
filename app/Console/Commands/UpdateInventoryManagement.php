<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Stock;

class UpdateInventoryManagement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:inventory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        

        $this->fetchInventory('https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/production/api/v2.0/companies(fca22e7b-c141-ec11-bb7c-000d3abb1711)/generalLedgerEntries?tenant=msweua9310t54161154&aid=FIN&$skiptoken=d85bbe40-c0ab-ed11-9a88-00224801d10d');

    }

    private function fetchInventory($link){
        $payload = getAccessToken();

        $result =  Http::withToken($payload['access_token']??"")->get($link)->body();
        $result = json_decode($result);

        $items = collect($result->value);

        foreach ($items->chunk(500) as $chunk) {
            $data = [];
            foreach($chunk as $item){
                if(isset($item->itemNumber)){
                    $data[] = [
                        'product_id'=>$item->itemNumber,
                        'warehouse_id'=>$item->sourceNumber,
                        'stocks'=>$item->quantity,
                        'price'=>$item->salesAmountActual
                     ];
                }
                 
            }
            Stock::upsert($data, 'product_id');
        }

        if(isset($result->{"@odata.nextLink"})){
            echo "------";
            //sleep(5);
            //$this->fetchInventory($result->{"@odata.nextLink"});
        }

    }
}
