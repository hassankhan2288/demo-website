<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Product;
use App\Warehouse;
use App\Transaction;

class PaymentSense{

    protected $account_id = "";
	protected $merchant_id = "";

	public function __construct()
    {
        $this->account_id = config("paymentsense.account_id");
        $this->account_id = config("paymentsense.merchant_id");
    }
}