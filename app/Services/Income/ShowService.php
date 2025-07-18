<?php

namespace App\Services\Income;

use App\Dto\Income\ShowDto;
use App\Models\Income;

class ShowService
{
    public function __invoke(ShowDto $dto): Income
    {
        return Income::with(['user', 'category'])->find($dto->id);
    }
}