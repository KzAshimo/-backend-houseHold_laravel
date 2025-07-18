<?php

namespace App\Services\Income;

use App\Models\Income;

class DeleteService
{
    public function __invoke(Income $income): void
    {
        // 対象データ削除
        $income->delete();
    }
}