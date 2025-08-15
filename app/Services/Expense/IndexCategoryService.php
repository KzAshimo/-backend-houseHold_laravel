<?php

namespace App\Services\Expense;

use App\Models\Expense;

class IndexCategoryService
{
    public function __invoke()
    {
        // カテゴリデータ取得
        return Expense::with('category')->orderBy('created_at', 'desc')->get();
    }
}