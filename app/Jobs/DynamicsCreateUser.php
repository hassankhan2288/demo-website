<?php

namespace App\Jobs;

use App\Branch;
use App\Customer;
use App\Services\MSDynamic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DynamicsCreateUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $customer_id;
    protected $branch_id;
    protected $customerObj;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($customerObj,$customer_id,$branch_id)
    {
        $this->customer_id = $customer_id;
        $this->branch_id = $branch_id;
        $this->customerObj = $customerObj;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api = new MSDynamic();

        $dynamic = $api->createCustomer($this->customerObj,$this->customer_id,$this->branch_id);
        \Log::info('this is return object from createCustomer in dynamics',[$dynamic]);
        if($dynamic){
            $customerUpdate = Customer::where('id', $this->customer_id)->update(['ms_number' => $dynamic]);
            $update = Branch::where('id', $this->branch_id)->update(['ms_number' => $dynamic]);

            // $customerUpdate = Customer::where('id', $this->customer_id)->update(['ms_id'=> $dynamic['customer_id'] , 'ms_number' => $dynamic['number'] ]);
            // $update = Branch::where('id', $this->branch_id)->update(['ms_id'=>  $dynamic['customer_id'] , 'ms_number' => $dynamic['number'] ]);
        }
    }
}
