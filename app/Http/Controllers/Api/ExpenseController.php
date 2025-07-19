<?php

namespace App\Http\Controllers\Api;

use App\Dto\Expense\StoreDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\StoreRequest;
use App\Http\Resources\Expense\IndexResource;
use App\Services\Expense\IndexService;
use App\Services\Expense\StoreService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{
    // --- 支出一覧取得 ---
    public function index(IndexService $service)
    {
        // データ一覧取得(serviceクラス使用)
        $expenses = $service();

        // データ返却(resourceクラス使用)
        return IndexResource::collection($expenses);
    }

    // --- 支出新規登録 ---
    public function store(StoreRequest $request, StoreService $service): JsonResponse
    {
        // リクエストデータ取得(dtoクラスへ渡す)
        $dto = new StoreDto(
            userId: Auth::user()->id,
            categoryId: $request->input('category_id'),
            amount: $request->input('amount'),
            content: $request->input('content'),
            memo: $request->input('memo'),
        );

        DB::beginTransaction();
        try {
            // データ新規登録(serviceクラス使用)
            $expense = $service($dto);

            DB::commit();

            return response()->json([
                'result' => true,
                'expense' => $expense,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }

    // --- 支出詳細取得 ---
    public function show()
    {
        return response()->json();
    }
}
