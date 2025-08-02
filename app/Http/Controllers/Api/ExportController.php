<?php

namespace App\Http\Controllers\Api;

use App\Dto\Export\StoreDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Export\StoreRequest;
use App\Http\Resources\Export\IndexResource;
use App\Models\Export;
use App\Services\Export\DownloadService;
use App\Services\Export\ExportService;
use App\Services\Export\IndexService;
use App\Services\Export\StoreService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExportController extends Controller
{
    // --- csvデータ一覧取得 ---
    public function index(IndexService $service): JsonResource
    {
        // csvデータ一覧取得：serviceクラス使用
        $export = $service();

        // データを整形し返却：resourceクラス使用
        return IndexResource::collection($export);
    }

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

    // --- csvファイル作成 ---
    public function export(int $exportId, ExportService $service): JsonResponse
    {
        DB::beginTransaction();
        try {
            // 対象データを検索
            $export = Export::findOrFail($exportId);

            // 作成処理：serviceクラスを使用
            $updateExport = $service($export);

            DB::commit();

            return response()->json([
                'result' => true,
                'export' => $updateExport,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }

    // --- csvファイル ダウンロード ---
    public function download(int $exportId, DownloadService $service): StreamedResponse
    {
        $export = Export::findOrFail($exportId);

        $filePath = $service($export);

        $downloadName = ($export->file_name ?? 'export_' . $export->id) . '.csv';

        return Storage::disk('local')->download($filePath, $downloadName,[
            'Content-Type' => 'text/csv',
        ]);
    }
}
