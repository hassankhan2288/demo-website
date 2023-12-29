<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;

class AddUpdateCompanyProductPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:company-product-pricing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this Command will handle company price, add and update purposes';

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
           $response = getAccessToken();

        // $result =  \Http::withToken($response['access_token']??"")->get("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/ICSProdCopy_23032023/ODataV4/Company('ICS%20UK%20LIMITED%20COPY%2005122022')/SalesPrice?\$expand=SalesPriceLines")->body();
        $result =  Http::withToken($response['access_token']??"")->get("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/ODataV4/Company('$this->company')/SalesPrice?\$expand=SalesPriceLines&\$filter=Code eq 'CHICKANOS'")->body();
       // $result_c =  Http::withToken($response['access_token']??"")->get("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/ODataV4/Company('My%20Company')/SalesPrice?\$expand=SalesPriceLines&\$filter=Code eq 'LDS WEB C'")->body();
        $result_d = json_decode($result);
       // $result_c = json_decode($result_c);
        $items_d = collect($result_d->value);
       // $items_c = collect($result_c->value);

        //$items_webc = $items_c[0]->SalesPriceLines;
        $items_webd = $items_d[0]->SalesPriceLines;
        // dd($items);
        dispatch(new CroneUpdateProductPrice($items_webc));
       // $itemsD = $items[4]->SalesPriceLines;
        dispatch(new CroneUpdateProductPrice($items_webd));
    }
    
}
