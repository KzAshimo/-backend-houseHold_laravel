<?php

namespace App\Services\NotificationView;

use App\Models\NotificationView;

class IndexService {
    public function __invoke()
    {
        // データ一覧取得(対象データと関係のある[user, notification]も取得)
        return NotificationView::with(['user', 'notification'])->orderBy('updated_at', 'desc')->paginate(10);
    }
}