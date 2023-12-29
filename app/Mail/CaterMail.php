<?php

namespace App\Mail;

use App\Product_Sale;
use App\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;
use Picqer\Barcode\BarcodeGeneratorHTML;

class CaterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$id)
    {
        $this->data = $data;
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'noreply@cater-choice.com'; //For live
        // $address = 'stallyons.tester2@gmail.com'; // Tetsing
        $subject = 'Order Confirmation';
        $name = 'CaterChoice';
        $items = Product_Sale::where("sale_id",$this->id)->get();
        $sale = Sale::find($this->id);

        return $this->view('emails.mailInvoice')
                    ->from($address, $name)
                    // ->cc($address, $name)
                    // ->bcc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([ 'test_message' => $this->data['msg'] , 'name' => $this->data['name'], 'sale' => $sale , 'items' => $items]);
                    // ->attachData($pdf->output(), "invoice.pdf", ['mime' => 'application/pdf']);
        // return $this->view('view.name');
    }
}
