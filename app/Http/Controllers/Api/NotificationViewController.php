<?php

namespace App\Http\Controllers\Api;

use App\Dto\NotificationView\StoreDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationView\StoreRequest;
use App\Models\Notification;
use App\Services\NotificationView\StoreService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationViewController extends Controller
{
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
}
