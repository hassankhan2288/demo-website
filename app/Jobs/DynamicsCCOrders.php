<?php

namespace App\Jobs;

use App\Sale;
use App\Services\MSDynamic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DynamicsCCOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $collectData;
    protected $user;
    protected $order_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($collectData,$order_id)
    {
        $this->collectData = $collectData;
        // $this->user = $user;
        $this->order_id = $order_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('ORDER ID HERE: ', [$this->order_id]);
        $api = new MSDynamic();
        $orderId = $api->createClickAndCollectOrder($this->collectData,$this->order_id);
        \Log::info('This Click & Collect API ID IN JOB: ', [$orderId]);
        $flag = Sale::where('id',$this->order_id)->update(['ms_order_no' => $orderId]);
        \Log::info('This IS FLAG: ', [$flag]);
    }
}
