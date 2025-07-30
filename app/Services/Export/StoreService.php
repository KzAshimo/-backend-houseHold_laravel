<?php

namespace App\Services\Export;

use App\Dto\Export\StoreDto;
use App\Models\Export;

class StoreService
{
    public function __invoke(StoreDto $dto)
    {
        // 新規データ作成
        return Export::create([
            'user_id' => $dto->userId,
            'type' => $dto->type,
            'period_from' => $dto->periodFrom,
            'period_to' => $dto->periodTo,
            'file_name' => $dto->fileName,
        ]);
    }
}