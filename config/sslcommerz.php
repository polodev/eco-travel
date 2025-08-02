<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SSL Commerz Configuration
    |--------------------------------------------------------------------------
    |
    | SSL Commerz payment gateway configuration for different stores.
    | You can configure multiple stores for different projects or environments.
    |
    */

    'main-store' => [
        'apiCredentials' => [
            'store_id' => env('SSLCOMMERZ_STORE_ID'),
            'store_password' => env('SSLCOMMERZ_STORE_PASSWORD'),
        ],
        'apiDomain' => env('SSLCOMMERZ_SANDBOX', true) ? 'https://sandbox.sslcommerz.com' : 'https://securepay.sslcommerz.com',
        'connect_from_localhost' => env('SSLCOMMERZ_LOCALHOST', true),
        'success_url' => '/payment/success',
        'failed_url' => '/payment/fail',
        'cancel_url' => '/payment/cancel',
        'ipn_url' => '/payment/ipn',
    ],

    'zaytoon-store' => [
        'apiCredentials' => [
            'store_id' => env('SSLCOMMERZ_ZAYTOON_STORE_ID'),
            'store_password' => env('SSLCOMMERZ_ZAYTOON_STORE_PASSWORD'),
        ],
        'apiDomain' => env('SSLCOMMERZ_SANDBOX', true) ? 'https://sandbox.sslcommerz.com' : 'https://securepay.sslcommerz.com',
        'connect_from_localhost' => env('SSLCOMMERZ_LOCALHOST', true),
        'success_url' => '/payment/success',
        'failed_url' => '/payment/fail',
        'cancel_url' => '/payment/cancel',
        'ipn_url' => '/payment/ipn',
    ],

    /*
    |--------------------------------------------------------------------------
    | SSL Commerz Environment Settings
    |--------------------------------------------------------------------------
    |
    | Sandbox mode for testing
    | Set to false for production
    |
    */
    'sandbox' => env('SSLCOMMERZ_SANDBOX', true),
    
    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    |
    | Default currency for transactions
    |
    */
    'currency' => env('SSLCOMMERZ_CURRENCY', 'BDT'),
    
    /*
    |--------------------------------------------------------------------------
    | Connection Settings
    |--------------------------------------------------------------------------
    |
    | Timeout and other connection settings
    |
    */
    'timeout' => env('SSLCOMMERZ_TIMEOUT', 30),
    'connect_timeout' => env('SSLCOMMERZ_CONNECT_TIMEOUT', 10),
];