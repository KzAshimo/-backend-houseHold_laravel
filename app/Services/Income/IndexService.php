<?php

namespace App\Services\Income;

use App\Models\Income;

class IndexService
{
    public function __invoke()
    {
        // データ一覧取得(対象データと関係のある [user / category] )
        return Income::with(['user', 'category'])->orderBy('created_at', 'desc')->paginate(10);
    }
}