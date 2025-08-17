<?php

namespace App\Services\Category;

use App\Models\Category;

class IndexExpenseService
{
    public function __invoke()
    {
        return Category::where('type', 'expense')->get();
    }
}