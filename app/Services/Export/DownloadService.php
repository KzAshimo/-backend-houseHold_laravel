<?php

namespace App\Services\Export;

use App\Models\Export;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DownloadService
{
    public function __invoke(Export $export): string
    {
        if (!$export->file_path || !Storage::disk('local')->exists($export->file_path)) {
            throw new NotFoundHttpException('csvファイルが見つかりませんでした。');
        }

        return $export->file_path;
    }
}
