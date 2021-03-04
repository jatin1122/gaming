<?php

return [
    "authType" => env('AUTH_TYPE'),
    "enableLog" => env('ENABLE_LOG'),
    "logSize" => env('LOG_SIZE'),
    "logFile" => env('LOG_FILE'),
    "logFilename" => env('LOG_FILENAME'),
    "merchantID" => env('MERCHANT_ID'),
    "apiKeyID" => env('API_KEY_ID'),
    "secretKey" => env('SECRETE_KEY'),
    "runEnv" => env('PAYMENT_ENV'),
    'flex_library_url' => 'https://flex.cybersource.com/cybersource/assets/microform/0.11/flex-microform.min.js'
];
