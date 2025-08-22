<?php

namespace App\Http\Controllers\Api;

use App\Dto\NotificationView\StoreDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationView\StoreRequest;
use App\Http\Resources\NotificationView\IndexResource;
use App\Models\Notification;
use App\Services\NotificationView\IndexService;
use App\Services\NotificationView\StoreService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationViewController extends Controller
{
    public function forLogin()
    {
        return response()->json();
    }

    // --- お知らせ既読 登録 ---
    public function store(StoreRequest $request, StoreService $service): JsonResponse
    {
        // 対象データ取得
        $notification = Notification::findOrFail($request->notification_id);
        // リクエストデータをdtoへ渡す
        $dto = new StoreDto(
            userId: Auth::user()->id,
            notificationId: (int)$notification->id,
        );

        DB::beginTransaction();
        try {
            // お知らせデータを一時保存
            $notificationView = $service($dto);

            DB::commit();

            return response()->json([
                'result' => true,
                'notification_view' => $notificationView,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }

    // --- お知らせ既読 一覧取得 ---
    public function index(IndexService $service): JsonResource
    {
        // お知らせ既読一覧データ取得：serviceクラス使用
        $notificationView = $service();

        // データを整形し返却：resourceクラス使用
        return IndexResource::collection($notificationView);
    }
}
