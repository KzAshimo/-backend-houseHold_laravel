<?php

namespace App\Services\Category;

use App\Dto\Category\UpdateDto;
use App\Models\Category;

class UpdateService{
    public function __invoke(UpdateDto $dto, Category $category): void
    {
        // データ編集 一時保存(登録処理はcontroller)
        $category->fill([
            'name' => $dto->name,
            'type' => $dto->type,
        ])->save();
    }
}