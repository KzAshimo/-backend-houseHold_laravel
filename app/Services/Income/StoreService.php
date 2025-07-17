<?php

namespace App\Services\Income;

use App\Dto\Income\StoreDto;
use App\Models\Income;

class StoreService
{
    public function __invoke(StoreDto $dto)
    {
        return Income::create([
            'user_id' => $dto->userId,
            'category_id' => $dto->categoryId,
            'amount' => $dto->amount,
            'content' => $dto->content,
            'memo' => $dto->memo,
        ]);
    }
}
