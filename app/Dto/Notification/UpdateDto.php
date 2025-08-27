<?php

namespace App\Dto\Notification;

use Carbon\Carbon;

class UpdateDto
{
    public function __construct(
        public readonly string $title,
        public readonly string $content,
        public readonly string $type,
        public readonly Carbon $startDate,
        public readonly Carbon $endDate,
    ) {}
}
