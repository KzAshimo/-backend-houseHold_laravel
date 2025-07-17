<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    // 収入一覧
    public function index()
    {
        $income = Income::with(['user', 'category'])->get();

        return response()->json($income);
    }
}
