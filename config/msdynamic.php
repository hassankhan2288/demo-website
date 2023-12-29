<?php

return [
   
    'company_id' => env('MS_DYNAMIC_COMPANY_ID', ""),

    'environment' => env('MS_DYNAMIC_ENVIRONMENT', ""),

    'app_env' => env('APP_ENV', 'live'), //local or live
    
    'app_live' => env('APP_LIVE','live'), // live or local

    'app_url' => env('APP_URL', ''),
];