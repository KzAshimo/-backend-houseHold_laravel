<?php

use App\Http\Controllers\Api\IncomeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// ユーザ認証必要なし
Route::prefix('v1')->group(function () {
    // ユーザ関係
    Route::prefix('user')->group(function () {
        Route::post('store', [UserController::class, 'store']); // ユーザ 新規登録
    });
});

// ユーザ認証必要
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // ユーザ関係
    Route::prefix('user')->group(function () {
        Route::get('show', [UserController::class, 'show']); // ユーザ 情報取得
    });

    // 収入関係
    Route::prefix('income')->group(function () {
        Route::get('index', [IncomeController::class, 'index']); // 収入 一覧取得
        Route::post('store', [IncomeController::class, 'store']); // 収入 新規登録
        Route::prefix('{income_id}')->group(function () {
            Route::get('/', [IncomeController::class, 'show']); // 収入 詳細取得
            Route::put('/', [IncomeController::class, 'update']); // 収入 編集
        });
    });
});
