<?php
return [
    'name' => 'subscription-system',
    'env' => env('APP_ENV')  ?: 'dev', // dev, testing, production
    'url' => env('APP_URL')  ?: 'http://localhost:8080',
    'debug' => env('APP_DEBUG') === 'true' ? true : false,
];
