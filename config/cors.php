<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],

    'allowed_methods' => ['*'],

    // Vercelの本番URLとプレビューURLの両方に対応。
    // Cloud Runの環境変数にCORS_ALLOWED_ORIGINS=https://householdnextjs.vercel.app のように設定します。
    'allowed_origins' => explode(',', env('CORS_ALLOWED_ORIGINS', 'http://localhost:3000')),

    // Vercelのプレビューデプロイで生成されるURL（例: householdnext-xxxxx.vercel.app）に対応するための正規表現です。
    'allowed_origins_patterns' => [
        '~^https://householdnext-.*\.vercel\.app$~',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];