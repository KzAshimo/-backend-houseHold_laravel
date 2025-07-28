<?php

namespace App\Services\NotificationView;

use App\Dto\NotificationView\StoreDto;
use App\Models\NotificationView;

class StoreService
{
    public function __invoke(StoreDto $dto): void
    {
        NotificationView::firstOrCreate(
            [
                'user_id' => $dto->userId,
                'notification_id' => $dto->notificationId,
                'viewed_at' => now(),
            ],
        );
    }
}
