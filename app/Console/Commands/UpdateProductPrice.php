<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Product;

class UpdateProductPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the products prices and MS id';

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
        
        $payload = getAccessToken();

        $result =  Http::withToken($payload['access_token']??"")->get("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/api/v2.0/companies($this->company)/items")->body();
        $result = json_decode($result);

        $items = collect($result->value);

        foreach ($items->chunk(500) as $chunk) {
           $cases = [];
           $ids = [];
           $params = [];
           $ms_ids = [];

           foreach ($chunk as $transaction) {
                if(is_numeric($transaction->number)){
                    $cases[] = "WHEN {$transaction->number} then ?";
                       $params[] = $transaction->unitPrice;
                       $ids[] = $transaction->number;
                       $ms_ids[] = $transaction->id;
                }
               
           }

           $ids = implode(',', $ids);
           $cases = implode(' ', $cases);

           if (!empty($ids)) {
            
            \DB::update("UPDATE products SET `price` = CASE `ms_id` {$cases} END WHERE `ms_id` in ($ids)", $params);
             \DB::update("UPDATE products SET `ms_item_id` = CASE `ms_id` {$cases} END WHERE `ms_id` in ($ids)", $ms_ids);
             
           }
        }
    }
}
