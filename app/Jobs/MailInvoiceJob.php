<?php

namespace App\Jobs;

use App\Mail\CaterMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MailInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    public $order_id;
    public $user_mail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $order_id, $user_mail)
    {
        $this->data['name'] = $data['name'];
        $this->data['msg'] = $data['msg'];
        $this->order_id = $order_id;
        $this->user_mail = $user_mail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user_mail)->send(new CaterMail($this->data,$this->order_id));
    }
}
