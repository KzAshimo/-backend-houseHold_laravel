<?php
namespace App\Services\Export;

use App\Models\Export;

class IndexService
{
    public function __invoke()
    {
        // データ一覧取得(対象データと関係のある[user]も取得)
        return Export::with(['user'])->orderBy('created_at', 'desc')->paginate(10);
    }
}