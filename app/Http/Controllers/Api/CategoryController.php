<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // --- カテゴリ一覧取得 ---
    public function index()
    {
        return response()->json();
    }
}
