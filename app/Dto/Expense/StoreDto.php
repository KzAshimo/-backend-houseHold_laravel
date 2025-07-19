<?php

namespace App\Dto\Expense;

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
