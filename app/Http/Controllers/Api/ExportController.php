<?php

namespace App\Http\Controllers\Api;

use App\Dto\Export\StoreDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Export\StoreRequest;
use App\Services\Export\StoreService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExportController extends Controller
{
    // --- csv出力データ新規登録 ---
    public function store(StoreRequest $request, StoreService $service): JsonResponse
    {
        // リクエストデータをdtoへ渡す
        $dto = new StoreDto(
            userId: Auth::user()->id,
            type: $request->input('type'),
            periodFrom: $request->input('period_from'),
            periodTo: $request->input('period_to'),
            fileName: $request->input('file_name'),
        );

        DB::beginTransaction();
        try {
            // csv出力データを一時保存
            $export = $service($dto);

            DB::commit();

            return response()->json([
                'result' => true,
                'export' => $export,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }
}
