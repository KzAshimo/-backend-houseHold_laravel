<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ユーザ認証必要なし
Route::prefix('v1')->group(function () {
    // ユーザ関係
    Route::prefix('user')->group(function () {
        Route::post('store', [UserController::class, 'store']); // ユーザ 新規登録
    });
});

Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->name('logout');
