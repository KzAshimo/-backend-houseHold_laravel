<?php

namespace App\Services\Category;

use App\Dto\Category\StoreDto;
use App\Models\Category;

class StoreService
{
    public function __invoke(StoreDto $dto)
    {
        // 新規データ作成
        return Category::create([
            'user_id' => $dto->userId,
            'name' => $dto->name,
            'type' => $dto->type,
        ]);
    }
}