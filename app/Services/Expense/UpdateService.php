<?php

namespace App\Services\Expense;

use App\Dto\Expense\UpdateDto;
use App\Models\Expense;

class UpdateService
{
    public function __invoke(UpdateDto $dto, Expense $expense): void
    {
        // データ編集 一時保存(登録処理はcontroller)
        $expense->fill([
            'amount' => $dto->amount,
            'content' => $dto->content,
            'memo' => $dto->memo,
        ])->save();
    }
}
