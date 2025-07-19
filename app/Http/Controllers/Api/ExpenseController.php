<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Expense\IndexResource;
use App\Models\Expense;
use App\Services\Expense\IndexService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    // --- 支出一覧取得 ---
    public function Index(IndexService $service)
    {
        // データ一覧取得(serviceクラス使用)
        $expenses = $service();

        // データ返却(resourceクラス使用)
        return IndexResource::collection($expenses);
    }
}
