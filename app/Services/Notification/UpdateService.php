<?php

namespace App\Services\Notification;

use App\Dto\Notification\UpdateDto;
use App\Models\Notification;

class UpdateService
{
    public function __invoke(UpdateDto $dto, Notification $notification): void
    {
        // データ編集 一時保存(登録処理はcontroller)
        $notification->fill([
            'title' => $dto->title,
            'content' => $dto->content,
            'type' => $dto->type,
            'start_date' => $dto->startDate,
            'end_date' => $dto->endDate,
        ])->save();
    }
}
