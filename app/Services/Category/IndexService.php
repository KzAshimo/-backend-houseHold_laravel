<?php

namespace App\Services\Category;

use App\Models\Category;

class IndexService
{
    public function __invoke()
    {
        // データ一覧取得(対象データと関係のある [user / expense / income] )
        return Category::with(['user', 'expenses', 'incomes'])->orderBy('created_at', 'desc')->paginate(10);
    }
}
