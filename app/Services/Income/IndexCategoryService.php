<?php

namespace App\Services\Income;

use App\Models\Income;

class IndexCategoryService
{
    public function __invoke()
    {
        // カテゴリデータ取得
        return Income::select('category_id')
        ->with('category')
        ->distinct() // 重複除外
        ->orderBy('category_id')
        ->get();
    }
}