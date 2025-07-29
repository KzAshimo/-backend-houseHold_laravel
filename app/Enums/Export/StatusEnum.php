<?php

namespace App\Enums\Export;

enum StatusEnum: string
{
    case PENDING = 'pending'; // 受付
    case PROCESSING = 'processing'; // 生成中
    case COMPLETE = 'complete'; // 完了
    case FAILED = 'failed'; // 失敗
}
