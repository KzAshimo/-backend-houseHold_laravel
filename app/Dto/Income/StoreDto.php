<?php

namespace App\Dto\Income;


class StoreDto
{
    public function __construct(
        public readonly int $userId,
        public readonly int $categoryId,
        public readonly int $amount,
        public readonly string $content,
        public readonly ?string $memo,
    ) {}
}
