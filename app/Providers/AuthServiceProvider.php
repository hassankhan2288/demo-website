<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('key-secret', function ($request) {
            $id = $request->header()['php-auth-user'][0]??null;
            $secret = $request->header()['php-auth-pw'][0]??null;
            return User::whereHas('oauth_client', function($query) use ($id, $secret){
                $query->where(['id'=>$id, 'secret'=>$secret]);
            })->first();
        });
    }
}
