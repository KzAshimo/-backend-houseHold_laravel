<?php

namespace App\Http\Controllers\Api;

use App\Dto\Income\ShowDto;
use App\Dto\Income\StoreDto;
use App\Dto\Income\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Income\DeleteRequest;
use App\Http\Requests\Income\ShowRequest;
use App\Http\Requests\Income\StoreRequest;
use App\Http\Requests\Income\UpdateRequest;
use App\Http\Resources\Income\IndexCategoryResource;
use App\Http\Resources\Income\IndexResource;
use App\Http\Resources\Income\ShowResource;
use App\Models\Income;
use App\Services\Income\DeleteService;
use App\Services\Income\IndexCategoryService;
use App\Services\Income\IndexService;
use App\Services\Income\ShowService;
use App\Services\Income\StoreService;
use App\Services\Income\UpdateService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IncomeController extends Controller
{
    // --- 収入一覧取得 ---
    public function index(IndexService $service): JsonResource
    {
        // データ一覧取得(serviceクラス使用)
        $incomes = $service();

        // データ返却(resourceクラス使用)
        return IndexResource::collection($incomes);
    }

    // --- 収入カテゴリ一覧取得 ---
    public function indexCategory(IndexCategoryService $service): JsonResource
    {
        // カテゴリデータ一覧取得(serviceクラス使用)
        $categories = $service();

        // データ返却(resourceクラス使用)
        return IndexCategoryResource::collection($categories);
    }

    // --- 収入新規登録 ---
    public function store(StoreRequest $request, StoreService $service): JsonResponse
    {
        // リクエストデータ取得(dtoクラス使用)
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
            $income = $service($dto);

            DB::commit();

            return response()->json([
                'result' => true,
                'income' => $income,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            throw $e;
        }
    }

    // --- 収入詳細取得 ---
    public function show(ShowRequest $request, ShowService $service): ShowResource
    {
        // 対象のデータ取得(dtoクラス使用)
        $dto = new ShowDto((int)$request->route('income_id'));

        // データ取得(serviceクラス使用)
        $income = $service($dto);

        // データ返却(resourceクラス使用)
        return new ShowResource($income);
    }

    // --- 収入編集 ---
    public function update(UpdateRequest $request, UpdateService $service): JsonResponse
    {
        // 対象のデータ取得
        $income = Income::findOrFail($request->income_id);

        // 認可処理
        $user = Auth::user();
        if ($user->role !== 'admin' && $income->user_id !== $user->id) {
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
            $service($dto, $income);

            DB::commit();

            return response()->json([
                'result' => true,
                'income' => $income
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }

    // --- 収入削除 ---
    public function delete(DeleteRequest $request, DeleteService $service): JsonResponse
    {
        // 対象データ取得
        $income = Income::findOrFail($request->income_id);

        // 認可処理
        $user = Auth::user();
        if ($user->role !== 'admin' && $income->user_id !== $user->id) {
            throw new AuthorizationException('この収入データを更新する権限がありません。');
        }

        DB::beginTransaction();
        try {
            // 削除処理(serviceクラス使用)
            $service($income);

            DB::commit();

            return response()->json([
                'result' => true,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }
}
