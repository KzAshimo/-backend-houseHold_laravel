<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(IncomeSeeder::class);
        $this->call(ExpenseSeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(NotificationViewSeeder::class);
    }

}
