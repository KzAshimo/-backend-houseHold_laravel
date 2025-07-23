<?php

namespace App\Dto\Category;

class StoreDto
{
    public function __construct(
        public readonly int $userId,
        public readonly string $name,
        public readonly string $type,
    ) {}
}
