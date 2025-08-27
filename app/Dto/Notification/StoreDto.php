<?php

namespace App\Dto\Notification;

use Carbon\Carbon;

class StoreDto
{
    public function __construct(
        public readonly int $userId,
        public readonly string $title,
        public readonly string $content,
        public readonly string $type,
        public readonly Carbon $startDate,
        public readonly Carbon $endDate,
    ) {}
}
