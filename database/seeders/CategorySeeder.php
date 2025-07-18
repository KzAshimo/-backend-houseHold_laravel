<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        Category::insert([
            [
                'user_id' => 1,
                'name' => '給与',
                'type' => 'income',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 1,
                'name' => '固定費',
                'type' => 'expense',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2,
                'name' => '雑費',
                'type' => 'expense',
                'created_at' => $now,
                'updated_at' => $now,
            ],

        ]);
    }
}
