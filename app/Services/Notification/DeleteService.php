<?php

namespace App\Services\Notification;

use App\Models\Notification;

class DeleteService{
    public function __invoke(Notification $notification): void
    {
        // 対象データ削除
        $notification->delete();
    }
}