<?php

namespace App\Services\Category;

use App\Enums\Category\ShowDto;
use App\Models\Category;

class ShowService{
    public function __invoke(ShowDto $dto): Category
    {
        // 対象データ取得(関係のある [user] も取得)
        return Category::with(['user'])->find($dto->id);
    }
}