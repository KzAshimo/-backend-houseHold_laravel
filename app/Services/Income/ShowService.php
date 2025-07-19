<?php

namespace App\Services\Income;

use App\Dto\Income\ShowDto;
use App\Models\Income;

class ShowService
{
    public function __invoke(ShowDto $dto): Income
    {
        // 対象データ取得(関係のある [user / category] も取得)
        return Income::with(['user', 'category'])->find($dto->id);
    }
}