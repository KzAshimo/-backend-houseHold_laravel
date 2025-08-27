<?php

namespace App\Services\Expense;

use App\Models\Expense;

class IndexCategoryService
{
    public function __invoke()
    {
        // カテゴリデータ取得
        return Expense::select('category_id')
        ->with('category')
        ->distinct() // 重複除外
        ->orderBy('category_id')
        ->get();
    }
}