<?php

namespace App\Services\Notification;

use App\Dto\Notification\ShowDto;
use App\Models\Notification;

class ShowService
{
    public function __invoke(ShowDto $dto)
    {
        // 対象データ取得
        return Notification::with(['user'])->findOrFail($dto->id);
    }
}
