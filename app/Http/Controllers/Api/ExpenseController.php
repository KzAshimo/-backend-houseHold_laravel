<?php

namespace App\Http\Controllers\Api;

use App\Dto\Expense\StoreDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\StoreRequest;
use App\Http\Resources\Expense\IndexResource;
use App\Models\Expense;
use App\Services\Expense\IndexService;
use App\Services\Expense\StoreService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        // リクエストでーら取得(dtoクラス使用)
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
            $expenses = $service($dto);

            DB::commit();

            return response()->json([
                'result' => true,
                'expense' => $expenses,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error();
            throw $e;
        }
    }
}
