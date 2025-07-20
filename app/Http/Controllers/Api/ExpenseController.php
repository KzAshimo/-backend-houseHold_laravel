<?php

namespace App\Http\Controllers\Api;

use App\Dto\Expense\ShowDto;
use App\Dto\Expense\StoreDto;
use App\Dto\Expense\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\ShowRequest;
use App\Http\Requests\Expense\StoreRequest;
use App\Http\Requests\Expense\UpdateRequest;
use App\Http\Resources\Expense\IndexResource;
use App\Http\Resources\Expense\ShowResource;
use App\Models\Expense;
use App\Services\Expense\IndexService;
use App\Services\Expense\ShowService;
use App\Services\Expense\StoreService;
use App\Services\Expense\UpdateService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
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
    public function show(ShowRequest $request, ShowService $service): ShowResource
    {
        // 対象データ取得(dtoクラス使用)
        $dto = new ShowDto((int)$request->route('expense_id'));

        // データ取得(serviceクラス使用)
        $expense = $service($dto);

        // データ返却(resourceクラス使用)
        return new ShowResource($expense);
    }

    // --- 支出編集 ---
    public function update(UpdateRequest $request, UpdateService $service): JsonResponse
    {
        // 対象のデータ取得
        $expense = Expense::findOrFail($request->expense_id);

        // 認可処理
        $user = Auth::user();
        if ($user->role !== 'admin' && $expense->user_id !== $user->id) {
            throw new AuthorizationException('この収入データを更新する権限がありません。');
        }

        DB::beginTransaction();
        try {
            // リクエストデータ取得(dtoクラス使用)
            $dto = new UpdateDto(
                amount: $request->amount,
                content: $request->content,
                memo: $request->memo,
            );

            // 編集処理(serviceクラス使用)
            $service($dto, $expense);

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
}
