<?php

namespace App\Services\Income;

use App\Dto\Income\UpdateDto;
use App\Models\Income;

class UpdateService
{
    public function __invoke(UpdateDto $dto, Income $income): void
    {
        $income->fill([
            'amount' => $dto->amount,
            'content' => $dto->content,
            'memo' => $dto->memo,
        ])->save();
    }
}