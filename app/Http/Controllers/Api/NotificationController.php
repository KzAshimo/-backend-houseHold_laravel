<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\IndexResource;
use App\Services\Notification\IndexService;
use Illuminate\Http\Resources\Json\JsonResource;

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
    public function store()
    {
        return response()->json();
    }
}
