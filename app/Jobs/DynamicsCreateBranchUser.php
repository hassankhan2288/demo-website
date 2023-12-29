<?php

namespace App\Jobs;

use App\Services\MSDynamic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DynamicsCreateBranchUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $admin;
    protected $branch;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($branch,$admin)
    {
        $this->admin = $admin;
        $this->branch = $branch;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api = new MSDynamic();
        $api->customer($this->branch, $this->admin);
    }
}
