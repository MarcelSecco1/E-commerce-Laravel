<?php

return [
    'mercado-pago' => [
        'client_id' => env('MERCADO_PAGO_CLIENT_ID', 'your-mercadopago-client-id'),
        'client_secret' => env('MERCADO_PAGO_CLIENT_SECRET', 'your-mercadopago-client-secret'),
        'public_key' => env('MERCADO_PAGO_PUBLIC_KEY', 'your-mercadopago-public-key'),
        'access_token' => env('MERCADO_PAGO_ACCESS_TOKEN', 'your-mercadopago-access-token'),
        'sandbox_mode' => env('MERCADO_PAGO_SANDBOX_MODE', true),
    ],
];
