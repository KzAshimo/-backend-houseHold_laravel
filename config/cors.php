<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],
    'allowed_methods' => ['*'],

    'allowed_origins' => ['https://householdnextjs.vercel.app'],
    'allowed_origins_patterns' => [
        '~^https://householdnextjs\.vercel\.app$~',

        '~^https://householdnext-.*\.vercel\.app$~',
    ],


    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
