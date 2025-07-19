<?php

namespace App\Services\Expense;

use App\Models\Expense;

class IndexService
{
    public function __invoke()
    {
        // データ一覧取得(対象データと関係のある [user / category] )
        return Expense::with(['user', 'category'])->get();
    }
}