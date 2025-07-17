<?php

namespace App\Services\Income;

use App\Models\Income;

class IndexService
{
    public function __invoke()
    {
        return Income::with(['user', 'category'])->get();
    }
}