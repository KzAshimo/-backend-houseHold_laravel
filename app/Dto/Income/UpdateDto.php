<?php

namespace App\Dto\Income;


class UpdateDto
{
    public function __construct(
        public readonly int $amount,
        public readonly string $content,
        public readonly ?string $memo,
    ) {}
}
