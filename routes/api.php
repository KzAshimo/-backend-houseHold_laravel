<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// ユーザ認証必要なし
Route::prefix('v1')->group(function () {
    // ユーザ関係
    Route::prefix('user')->group(function () {
        Route::post('store', [UserController::class, 'store']); // ユーザ新規登録
    });
});

// ユーザ認証必要
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // ユーザ関係
    Route::prefix('user')->group(function () {
        Route::get('show', [UserController::class, 'show']); // ユーザ情報取得
    });
});
