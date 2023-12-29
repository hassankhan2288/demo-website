<?php

namespace App\Services\PaymentSense;

use Illuminate\Support\Facades\Http;

class PaymentSense implements PaymentSenseInterface {


    private function get($resource, $params)
    {
        return Http::payment()->get($resource, $params);
    }

    private function post($resource, $body)
    {
        return Http::payment()->post($resource, $body);
    }

    public function sale($data)
    {
        return $this->post("/access-tokens", $data)->json();
    }

    
}