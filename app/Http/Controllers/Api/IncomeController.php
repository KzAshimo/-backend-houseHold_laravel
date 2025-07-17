<?php

namespace App\Http\Controllers\Api;

use App\Dto\Income\StoreDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Income\StoreRequest;
use App\Http\Resources\Income\IndexResource;
use App\Models\Income;
use App\Services\Income\IndexService;
use App\Services\Income\StoreService;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IncomeController extends Controller
{
    // 収入一覧
    public function index(IndexService $service): JsonResource
    {
        $incomes = $service();

        return IndexResource::collection($incomes);
    }

    // 収入追加
    public function store(StoreRequest $request, StoreService $service): JsonResource
    {
        // リクエストデータをdtoへ渡す
        $dto = new StoreDto(
            usrId: auth()->id,
            categoryId:$request->input('category_id'),
            amount:$request->input('amount'),
            content:$request->input('content'),
            memo:$request->input('memo'),
            date:$request->input('date'),
        );

        DB::beginTransaction();
        try {
            $income = $service($dto);
            DB::commit();

            return response()->json([
                'result' => true,
                'income' => $income,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error();
            throw $e;
        }
    }

}
