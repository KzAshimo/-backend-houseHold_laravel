<?php

namespace App\Http\Controllers\Api;

use App\Dto\Notification\StoreDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\StoreRequest;
use App\Http\Resources\Notification\IndexResource;
use App\Services\Notification\IndexService;
use App\Services\Notification\StoreService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    // --- お知らせ一覧取得 ---
    public function index(IndexService $service): JsonResource
    {
        // お知らせ一覧データ取得：serviceクラス使用
        $notification = $service();

        // データを整形し返却：resourceクラス使用
        return IndexResource::collection($notification);
    }

    // --- お知らせ新規登録 ---
    public function store(StoreRequest $request, StoreService $service): JsonResponse
    {
        // リクエストデータをdtoへ渡す
        $dto = new StoreDto(
            userId: Auth::user()->id,
            title: $request->input('title'),
            content: $request->input('content'),
            type: $request->input('type'),
            startDate: Carbon::parse($request->input('start_date')),
            endDate: Carbon::parse($request->input('end_date')),
        );

        DB::beginTransaction();
        try {
            // お知らせデータを一時保存
            $notification = $service($dto);

            DB::commit();

            return response()->json([
                'result' => true,
                'notification' => $notification,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }

    public function show()
    {
        return response()->json();
    }
}
