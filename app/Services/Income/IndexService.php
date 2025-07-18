<?php

namespace App\Services\Income;

use App\Models\Income;

class IndexService
{
    public function __invoke()
    {
        // データ一覧取得(Incomeと関係のある [user / category] )
        return Income::with(['user', 'category'])->get();
    }
}