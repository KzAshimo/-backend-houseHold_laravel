<?php

namespace App\Http\Controllers\Api;

use App\Dto\Income\ShowDto;
use App\Dto\Income\StoreDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Income\ShowRequest;
use App\Http\Requests\Income\StoreRequest;
use App\Http\Resources\Income\IndexResource;
use App\Http\Resources\Income\ShowResource;
use App\Http\Resources\User\ShowResource as UserShowResource;
use App\Models\Income;
use App\Services\Income\IndexService;
use App\Services\Income\ShowService;
use App\Services\Income\StoreService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
    public function store(StoreRequest $request, StoreService $service): JsonResponse
    {
        // リクエストデータをdtoへ渡す
        $dto = new StoreDto(
            userId: Auth::user()->id,
            categoryId:$request->input('category_id'),
            amount:$request->input('amount'),
            content:$request->input('content'),
            memo:$request->input('memo'),
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
            Log::error($e);
            throw $e;
        }
    }

    // 収入詳細
    public function show(ShowRequest $request, ShowService $service): ShowResource
    {
        $dto = new ShowDto((int)$request->route('income_id'));

        $income = $service($dto);

        return new ShowResource($income);
    }

    // 収入編集
    public function put(Request $request)
    {
        request()->json([]);
    }
}
