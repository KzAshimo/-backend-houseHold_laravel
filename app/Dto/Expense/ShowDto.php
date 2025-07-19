<?php

namespace App\Dto\Expense;

class ShowDto
{
    public function __construct(
        public readonly int $id,
    ) {}
}
