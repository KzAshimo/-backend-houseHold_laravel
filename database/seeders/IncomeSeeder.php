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
                'memo' => 'test',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 1,
                'category_id' => 1,
                'amount' => 500000,
                'content' => '賞与',
                'memo' => 'test',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2,
                'category_id' => 2,
                'amount' => 75000,
                'content' => '投資',
                'memo' => 'test',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2,
                'category_id' => 2,
                'amount' => 30000,
                'content' => '配当金',
                'memo' => 'test',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 1,
                'category_id' => 3,
                'amount' => 60000,
                'content' => 'せどり',
                'memo' => 'test',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 1,
                'category_id' => 1,
                'amount' => 300000,
                'content' => '給与',
                'memo' => 'test',
                'created_at' => $now->addMonth(),
                'updated_at' => $now->addMonth(),
            ],
            [
                'user_id' => 1,
                'category_id' => 1,
                'amount' => 500000,
                'content' => '賞与',
                'memo' => 'test',
                'created_at' => $now->addMonth(),
                'updated_at' => $now->addMonth(),
            ],
            [
                'user_id' => 2,
                'category_id' => 2,
                'amount' => 75000,
                'content' => '投資',
                'memo' => 'test',
                'created_at' => $now->addMonth(),
                'updated_at' => $now->addMonth(),
            ],
            [
                'user_id' => 2,
                'category_id' => 2,
                'amount' => 30000,
                'content' => '配当金',
                'memo' => 'test',
                'created_at' => $now->addMonth(),
                'updated_at' => $now->addMonth(),
            ],
            [
                'user_id' => 1,
                'category_id' => 3,
                'amount' => 60000,
                'content' => 'せどり',
                'memo' => 'test',
                'created_at' => $now->addMonth(),
                'updated_at' => $now->addMonth(),
            ],
            [
                'user_id' => 1,
                'category_id' => 1,
                'amount' => 300000,
                'content' => '給与',
                'memo' => 'test',
                'created_at' => $now->addMonth(2),
                'updated_at' => $now->addMonth(2),
            ],
            [
                'user_id' => 1,
                'category_id' => 1,
                'amount' => 500000,
                'content' => '賞与',
                'memo' => 'test',
                'created_at' => $now->addMonth(2),
                'updated_at' => $now->addMonth(2),
            ],
            [
                'user_id' => 2,
                'category_id' => 2,
                'amount' => 75000,
                'content' => '投資',
                'memo' => 'test',
                'created_at' => $now->addMonth(2),
                'updated_at' => $now->addMonth(2),
            ],
            [
                'user_id' => 2,
                'category_id' => 2,
                'amount' => 30000,
                'content' => '配当金',
                'memo' => 'test',
                'created_at' => $now->addMonth(2),
                'updated_at' => $now->addMonth(2),
            ],
            [
                'user_id' => 1,
                'category_id' => 3,
                'amount' => 60000,
                'content' => 'せどり',
                'memo' => 'test',
                'created_at' => $now->addMonth(2),
                'updated_at' => $now->addMonth(2),
            ],
            [
                'user_id' => 1,
                'category_id' => 1,
                'amount' => 300000,
                'content' => '給与',
                'memo' => 'test',
                'created_at' => $now->subMonth(),
                'updated_at' => $now->subMonth(),
            ],
            [
                'user_id' => 1,
                'category_id' => 1,
                'amount' => 500000,
                'content' => '賞与',
                'memo' => 'test',
                'created_at' => $now->subMonth(),
                'updated_at' => $now->subMonth(),
            ],
            [
                'user_id' => 2,
                'category_id' => 2,
                'amount' => 75000,
                'content' => '投資',
                'memo' => 'test',
                'created_at' => $now->subMonth(),
                'updated_at' => $now->subMonth(),
            ],
            [
                'user_id' => 2,
                'category_id' => 2,
                'amount' => 30000,
                'content' => '配当金',
                'memo' => 'test',
                'created_at' => $now->subMonth(),
                'updated_at' => $now->subMonth(),
            ],
            [
                'user_id' => 1,
                'category_id' => 3,
                'amount' => 60000,
                'content' => 'せどり',
                'memo' => 'test',
                'created_at' => $now->subMonth(),
                'updated_at' => $now->subMonth(),
            ],

        ]);
    }
}
