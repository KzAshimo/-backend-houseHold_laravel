<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// ユーザ認証不必要
Route::prefix('v1')->group(function () {
    // ユーザ登録
    Route::prefix('user')->group(function () {
        Route::post('store', [UserController::class, 'store']);
    });
});

// ユーザ認証必要
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

});
