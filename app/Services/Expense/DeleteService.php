<?php
namespace App\Services\Expense;

use App\Models\Expense;

class DeleteService
{
    public function __invoke(Expense $expense): void
    {
        // 対象データ削除
        $expense->delete();
    }
}