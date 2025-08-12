<?php

namespace App\Services\Income;

use App\Models\Income;

class IndexCategoryService
{
    public function __invoke()
    {
        // カテゴリデータ取得
        return Income::with('category')->orderBy('created_at', 'desc')->get();
    }
}