<?php

namespace Database\Seeders;

use App\Models\Export;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExportSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        Export::insert([
            [
                'user_id' => 1,
                'type' => 'income',
                'period_from' => $now,
                'period_to' => now()->addMonth(),
                'file_name' => 'test_file',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
