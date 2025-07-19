<?php

namespace App\Services\Expense;

use App\Dto\Expense\StoreDto;
use App\Models\Expense;

class StoreService
{
    public function __invoke(StoreDto $dto)
    {
        // 新規データ作成
        return Expense::create([
            'user_id' => $dto->userId,
            'category_id' => $dto->categoryId,
            'amount' => $dto->amount,
            'content' => $dto->content,
            'memo' => $dto->memo,
        ]);
    }
}
