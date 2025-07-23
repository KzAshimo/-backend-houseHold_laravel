<?php

namespace App\Services\Notification;

use App\Models\Notification;

class IndexService{
    public function __invoke()
    {
        // データ一覧取得(対象データと関係ある[user]も取得)
        return Notification::with(['user'])->orderBy('created_at', 'desc')->paginate(10);
    }
}