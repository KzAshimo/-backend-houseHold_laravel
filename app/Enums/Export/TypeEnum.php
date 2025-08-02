<?php

namespace App\Enums\Export;

enum TypeEnum: string
{
    case INCOME = 'income'; // 収入
    case EXPENSE = 'expense'; // 支出
    case All = 'all'; //全て
}
