<?php

namespace App\Service\category;

use App\Models\Category;

class IndexService
{
    public function __invoke()
    {
        // データ一覧取得(対象データと関係のある [user / expense / income] )
        return Category::with(['user', 'expense', 'income'])->paginate(10);
    }
}
