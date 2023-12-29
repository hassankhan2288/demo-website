<?php

namespace App\Jobs;

use App\Services\MSDynamic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DynamicsCreateOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $sale_data;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sale_data, $user)
    {
        $this->sale_data = $sale_data;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api = new MSDynamic();
        $api->order($this->sale_data, $this->user);
    }
}
