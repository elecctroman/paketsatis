<?php
return [
    'app' => [
        'name' => 'PaketSatis',
        'env' => 'production',
        'debug' => false,
        'url' => 'https://example.com',
        'locale' => 'tr',
        'fallback_locale' => 'en',
        'key' => 'base64:REPLACE_WITH_GENERATED_KEY',
        'csrf_salt' => 'replace-with-random-salt',
        'version' => '1.0.0'
    ],
    'database' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'paketsatis',
        'username' => 'dbuser',
        'password' => 'dbpass',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci'
    ],
    'mail' => [
        'driver' => 'smtp',
        'host' => 'smtp.example.com',
        'port' => 587,
        'username' => 'mailer@example.com',
        'password' => 'secret',
        'encryption' => 'tls',
        'from' => ['address' => 'no-reply@example.com', 'name' => 'PaketSatis']
    ],
    'payment' => [
        'iyzico' => [
            'api_key' => '',
            'secret_key' => '',
            'base_url' => 'https://sandbox-api.iyzipay.com'
        ],
        'paytr' => [
            'merchant_id' => '',
            'merchant_key' => '',
            'merchant_salt' => '',
            'base_url' => 'https://test.paytr.com'
        ]
    ],
    'security' => [
        'rate_limit' => [
            'login' => ['max_attempts' => 5, 'decay_minutes' => 15],
            'webhook' => ['max_attempts' => 30, 'decay_minutes' => 1]
        ]
    ],
];
