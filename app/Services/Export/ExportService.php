<?php

namespace App\Services\Export;

use App\Dto\Export\ExportDto;
use App\Models\Export;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ExportService
{
    public function __invoke(Export $export): void
    {
        // status変更 / 生成中
        $export->update(['status' => 'processing']);

        // csv行を構築
        $csvData = [
            ['ID', 'ユーザ名', 'タイプ', '開始日', '終了日'],
            [
                $export->id,
                $export->user->name,
                $export->type,
                $export->period_from,
                $export->period_to,
            ],
        ];

        // csv文字列へ変換
        $csvString = $this->arrayToCsv($csvData);

        // ファイル名生成
        $fileName = $export->file_name
            ? $export->file_name . 'csv'
            : 'export' . $export->id . 'csv';

        $filePath = 'exports/' . Str::slug($fileName);

        // ファイル保存
        Storage::put($filePath, $csvString);

        $export->update([
            'file_path' => $filePath,
            'status' => 'complete',
        ]);
    }

    public function arrayToCsv(array $data): string
    {
        $handle = fopen('php://temp', 'r+');

        foreach ($data as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return $csv;
    }
}
