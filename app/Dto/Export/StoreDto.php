<?php

namespace App\Dto\Export;

class StoreDto
{
    public function __construct(
        public readonly int $userId,
        public readonly string $type,
        public readonly string $periodFrom,
        public readonly string $periodTo,
        public readonly ?string $fileName,
    ) {}
}
