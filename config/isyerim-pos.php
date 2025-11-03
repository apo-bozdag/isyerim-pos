<?php

// config for Abdullah/IsyerimPos
return [

    /*
    |--------------------------------------------------------------------------
    | IsyerimPOS API Credentials
    |--------------------------------------------------------------------------
    |
    | Your IsyerimPOS API credentials. You can get these from your
    | IsyerimPOS merchant panel.
    |
    */

    'merchant_id' => env('ISYERIMPOS_MERCHANT_ID'),
    'user_id' => env('ISYERIMPOS_USER_ID'),
    'api_key' => env('ISYERIMPOS_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for IsyerimPOS API. Use test URL for development and
    | production URL for live transactions.
    |
    | Test: https://apitest.isyerimpos.com/v1/
    | Production: https://api.isyerimpos.com/v1/
    |
    */

    'base_url' => env('ISYERIMPOS_BASE_URL', 'https://apitest.isyerimpos.com/v1/'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Settings
    |--------------------------------------------------------------------------
    */

    'timeout' => env('ISYERIMPOS_TIMEOUT', 30),
    'connect_timeout' => env('ISYERIMPOS_CONNECT_TIMEOUT', 10),
    'retry_times' => env('ISYERIMPOS_RETRY_TIMES', 3),
    'retry_sleep' => env('ISYERIMPOS_RETRY_SLEEP', 100), // milliseconds

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Enable or disable API request/response logging. Useful for debugging.
    |
    */

    'logging' => [
        'enabled' => env('ISYERIMPOS_LOGGING', false),
        'channel' => env('ISYERIMPOS_LOG_CHANNEL', 'stack'),
        'log_requests' => env('ISYERIMPOS_LOG_REQUESTS', true),
        'log_responses' => env('ISYERIMPOS_LOG_RESPONSES', true),
    ],

];
