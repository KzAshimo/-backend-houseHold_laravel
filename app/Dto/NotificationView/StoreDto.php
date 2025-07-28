<?php

namespace App\Dto\NotificationView;

class StoreDto
{
    public function __construct(
        public readonly int $userId,
        public readonly int $notificationId,
    ) {}
}
