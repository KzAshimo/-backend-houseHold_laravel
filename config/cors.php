<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://householdnextjs.vercel.app'],
    'allowed_headers' => ['*'],
    'supports_credentials' => true,
];
