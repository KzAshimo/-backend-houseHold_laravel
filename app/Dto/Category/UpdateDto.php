<?php

namespace App\Dto\Category;

class UpdateDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
    ) {}
}
