<?php
/**
* Here is the serverless function entry
* for deployment with Vercel.
*/
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: https://householdnextjs.vercel.app");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization");
    http_response_code(204);
    exit(0);
}

require __DIR__.'/../public/index.php';
