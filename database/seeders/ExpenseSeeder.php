<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        Expense::insert([
            [
                'user_id' => 1,
                'category_id' => 2,
                'amount' => 5500,
                'content' => '電気代',
                'memo' => '7月',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2,
                'category_id' => 3,
                'amount' => 10000,
                'content' => '電化製品',
                'memo' => '7月',
                'created_at' => $now,
                'updated_at' => $now,
            ],

        ]);
    }
}
