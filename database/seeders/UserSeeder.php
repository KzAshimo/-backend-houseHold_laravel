<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'アムロ',
                'email' => 'amuro@sample.com',
                'password' => 'password',
                'role' => 'user',
            ],
            [
                'name' => 'セイラ',
                'email' => 'seira@sample.com',
                'password' => 'password',
                'role' => 'user',
            ],
            [
                'name' => 'ブライト',
                'email' => 'blight@sample.com',
                'password' => 'password',
                'role' => 'admin',
            ],

        ]);
    }
}
