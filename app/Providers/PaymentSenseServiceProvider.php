<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PaymentSense\PaymentSense;
use App\Services\PaymentSense\PaymentSenseInterface;
use Illuminate\Support\Facades\Http;

class PaymentSenseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PaymentSenseInterface::class, PaymentSense::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Http::macro('payment', function () {
            return Http::withToken(config("paymentsense.jwt_token"))->baseUrl(config("paymentsense.base_url"));
        });
    }
}
