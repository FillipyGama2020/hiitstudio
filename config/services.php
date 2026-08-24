<?php

return [
    'pagarme' => [
        'secret_key' => env('PAGARME_SECRET_KEY'),
        'webhook_token' => env('PAGARME_WEBHOOK_TOKEN'),
        'base_url' => 'https://api.pagar.me/core/v5',
    ],
    'mercadopago' => [
        'access_token' => env('MERCADOPAGO_ACCESS_TOKEN'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
    ],
];
