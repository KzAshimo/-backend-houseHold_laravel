<?php
namespace App\Services\Notification;

use App\Dto\Notification\StoreDto;
use App\Models\Notification;

class StoreService{
    public function __invoke(StoreDto $dto)
    {
        // 新規データ作成
        return Notification::create([
            'user_id' => $dto->userId,
            'title' => $dto->title,
            'content' => $dto->content,
            'type' => $dto->type,
            'start_date'=> $dto->startDate,
            'end_date' => $dto->endDate,
        ]);
    }
}