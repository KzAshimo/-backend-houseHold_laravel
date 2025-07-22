<?php

namespace App\Http\Controllers\Api;

use App\Dto\Category\ShowDto;
use App\Dto\Category\StoreDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\ShowRequest;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Resources\Category\IndexResource;
use App\Http\Resources\Category\ShowResource;
use App\Services\Category\IndexService;
use App\Services\Category\ShowService;
use App\Services\Category\StoreService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    // --- カテゴリ一覧取得 ---
    public function index(IndexService $service): JsonResource
    {
        // カテゴリ一覧データ取得：serviceクラス使用
        $categories = $service();

        // データを整形し返却：resourceクラス使用
        return IndexResource::collection($categories);
    }

    // --- カテゴリ新規登録 ---
    public function store(StoreRequest $request, StoreService $service): JsonResponse
    {
        // リクエストデータをdtoへ渡す
        $dto = new StoreDto(
            userId: Auth::user()->id,
            name: $request->input('name'),
            type: $request->input('type'),
        );

        DB::beginTransaction();
        try {
            // 支出データを一時保存：serviceクラス使用
            $category = $service($dto);

            DB::commit();

            return response()->json([
                'result' => true,
                'category' => $category,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }

    // --- カテゴリ詳細取得 ---
    public function show(ShowRequest $request, ShowService $service): ShowResource
    {
        // ルートパラメータをdtoへ渡す
        $dto = new ShowDto((int)$request->route('category_id'));

        // 対象データ取得：serviceクラス使用
        $category = $service($dto);

        //データを整形し返却：resourceクラス使用
        return new ShowResource($category);
    }

    public function update()
    {
        return response()->json();
    }
}
