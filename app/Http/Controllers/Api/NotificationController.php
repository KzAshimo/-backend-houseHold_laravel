<?php

namespace App\Http\Controllers\Api;

use App\Dto\Notification\ShowDto;
use App\Dto\Notification\StoreDto;
use App\Dto\Notification\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\DeleteRequest;
use App\Http\Requests\Notification\ShowRequest;
use App\Http\Requests\Notification\StoreRequest;
use App\Http\Requests\Notification\UpdateRequest;
use App\Http\Resources\Notification\IndexResource;
use App\Http\Resources\Notification\ShowResource;
use App\Models\Notification;
use App\Services\Notification\DeleteService;
use App\Services\Notification\IndexService;
use App\Services\Notification\ShowService;
use App\Services\Notification\StoreService;
use App\Services\Notification\UpdateService;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
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

    // --- お知らせ詳細取得 ---
    public function show(ShowRequest $request, ShowService $service): ShowResource
    {
        // ルートパラメータをdtoへ渡す
        $dto = new ShowDto((int)$request->route('notification_id'));

        // 対象データ取得：serviceクラス使用
        $notification = $service($dto);

        //データを整形し返却：resourceクラス使用
        return new ShowResource($notification);
    }

    // --- お知らせ編集 ---
    public function update(UpdateRequest $request, UpdateService $service): JsonResponse
    {
        // 対象データ取得
        $notification = Notification::findOrFail($request->notification_id);

        // 認可処理
        $user = Auth::user();
        if ($user->role !== 'admin' && $notification->user_id !== $user->id) {
            throw new AuthorizationException('このお知らせデータを更新する権限がありません。');
        }

        DB::beginTransaction();
        try {
            // リクエストデータをdtoへ渡す
            $dto = new UpdateDto(
                title: $request->input('title'),
                content: $request->input('content'),
                type: $request->input('type'),
                startDate: Carbon::parse($request->input('start_date')),
                endDate: Carbon::parse($request->input('end_date')),
            );

            // 編集処理：serviceクラス使用
            $service($dto, $notification);

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

    // --- お知らせ削除 ---
    public function delete(DeleteRequest $request, DeleteService $service): JsonResponse
    {
        // 対象データ取得
        $notification = Notification::findOrFail($request->notification_id);

        // 認可確認
        $user = Auth::user();
        if ($user->role !== 'admin' && $notification->user_id !== $user->id) {
            throw new AuthorizationException('このお知らせデータを更新する権限がありません。');
        }

        DB::beginTransaction();
        try {
            // 削除処理：serviceクラス使用
            $service($notification);

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
