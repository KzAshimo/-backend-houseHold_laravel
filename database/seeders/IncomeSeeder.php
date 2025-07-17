<?php

namespace Database\Seeders;

use App\Models\Income;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        Income::insert([
            [
                'user_id' => 1,
                'category_id' => 1,
                'amount' => 300000,
                'content' => '給与',
                'memo' => '7月',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 1,
                'category_id' => 1,
                'amount' => 500000,
                'content' => '賞与',
                'memo' => '7月',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2,
                'category_id' => 1,
                'amount' => 75000,
                'content' => '投資',
                'memo' => '7月',
                'created_at' => $now,
                'updated_at' => $now,
            ],

        ]);
    }
}
