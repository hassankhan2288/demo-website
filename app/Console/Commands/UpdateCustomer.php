<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Customer;

class UpdateCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:customer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push and pull the customer from MS Dynamic';

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

        $branches = Customer::whereNull("ms_id")->get();

        if($branches){
            foreach($branches as $branch){
                $email = $branch->email;
                $result =  Http::withToken($payload['access_token']??"")->get('https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/'.$this->environment.'/api/v2.0/companies('.$this->company.')/customers?$filter=email%20eq%20\''.$email.'\'')->body();
                $result = json_decode($result);

                $items = collect($result->value);

                if($items->count()>0){
                    $branch->ms_id = $items[0]->id;
                    $branch->ms_number = $items[0]->number;
                    $branch->save();
                } else {
                    try {

                        $data = [
                            'displayName'=>$branch->name,
                            'type'=>'Company',
                            'addressLine1'=>$branch->address,
                            'email'=>$branch->email,
                            'phoneNumber'=>$branch->phone_number,
                        ];

                        $customer =  Http::withToken($payload['access_token']??"")->post("https://api.businesscentral.dynamics.com/v2.0/101a8ff1-cdf5-4497-a35c-bb53032e7f9a/$this->environment/api/v2.0/companies($this->company)/customers",$data
                        )->body();

                        $customer = json_decode($customer);
                        if(isset($customer->id)){

                            $branch->ms_id = $customer->id;
                            $branch->ms_number = $customer->number;
                            $branch->save();
                            
                        }

                    } catch(\Exception $e){
                        \Log::info($e->getMessage());
                    }
                }
                
            }
        }

    }
}
