<?php

namespace App\Services\Expense;

use App\Dto\Expense\ShowDto;
use App\Models\Expense;

class ShowService
{
    public function __invoke(ShowDto $dto): Expense
    {
        // 対象データ取得取得(関係のある [user / category] も取得)
        return Expense::with(['user', 'category'])->find($dto->id);
    }
}
