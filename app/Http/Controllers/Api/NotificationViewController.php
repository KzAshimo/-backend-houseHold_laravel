<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationViewController extends Controller
{
    // --- お知らせ既読 登録 ---
    public function store()
    {
        return response()->json();
    }
}
