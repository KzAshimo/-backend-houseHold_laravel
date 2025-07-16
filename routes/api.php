<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    Route::prefix('user')->group(function () {
        Route::post('store', [UserController::class], 'store');
    });
});
