<?php

namespace App\Services\Category;

use App\Models\Category;

class DeleteService
{
    public function __invoke(Category $category): void
    {
        // 対象データ削除
        $category->delete();
    }
}