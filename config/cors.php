<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://householdnext-fqwfybjev-ashimos-projects.vercel.app'],
    'allowed_headers' => ['*'],
    'supports_credentials' => true,
];
