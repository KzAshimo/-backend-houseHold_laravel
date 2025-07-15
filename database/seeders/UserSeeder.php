<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'セイラ',
                'email' => 'seira@sample.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ],
            [
                'name' => 'ブライト',
                'email' => 'blight@sample.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],

        ]);
    }
}
