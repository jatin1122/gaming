<?php

return [
    'app_name' => 'Genie Gaming',
    'username' => env('PAYMENT_USERNAME'),
    'password' => env('PAYMENT_PASSWORD'),
    'merchantAccount' => env('PAYMENT_MERCHANT_ACCOUNT'),
    'environment' => env('PAYMENT_ENVIRONMENT', 'test') == 'test' ? \Adyen\Environment::TEST : \Adyen\Environment::LIVE,
    'cse_library_url' => env('PAYMENT_CSE_LIBRARY_URL'),
    'cse_public_key' => env('PAYMENT_CSE_PUBLIC_KEY'),
    'cse_token' => env('PAYMENT_CSE_TOKEN'),

    'payout' => [
        'store' => [
            'cse_library_url' => env('PAYMENT_PAYOUT_STORE_CSE_LIBRARY_URL'),
            'cse_public_key' => env('PAYMENT_PAYOUT_STORE_CSE_PUBLIC_KEY'),
            'cse_token' => env('PAYMENT_PAYOUT_STORE_CSE_TOKEN'),
            'username' => env('PAYMENT_PAYOUT_STORE_USERNAME'),
            'password' => env('PAYMENT_PAYOUT_STORE_PASSWORD'),
        ],

        'review' => [
            'username' => env('PAYMENT_PAYOUT_REVIEW_USERNAME'),
            'password' => env('PAYMENT_PAYOUT_REVIEW_PASSWORD'),
        ]
    ]
];