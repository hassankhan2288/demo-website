<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Warehouse;

class UpdateLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:location';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update and pull the warehouse from dynamic';

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

        $result =  Http::withToken($payload['access_token']??"")->get('https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/'.$this->environment.'/api/v2.0/companies('.$this->company.')/locations')->body();
        $result = json_decode($result);

        $items = collect($result->value);

        foreach ($items->chunk(500) as $chunk) {
            $data = [];
            foreach($chunk as $item){
                $data[] = [
                    'name'=>$item->displayName,
                    'ms_id'=>$item->id,
                    'phone'=>$item->contact,
                    'email'=>$item->email,
                    'address'=>$item->addressLine1,
                    'is_active'=>1,
                 ];    
            }
            Warehouse::upsert($data, 'ms_id');
        }
    }
}
