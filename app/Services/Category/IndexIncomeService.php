<?php

namespace App\Services\Category;

use App\Models\Category;

class IndexIncomeService
{
    public function __invoke()
    {
        return Category::where('type', 'income')->get();
    }
}