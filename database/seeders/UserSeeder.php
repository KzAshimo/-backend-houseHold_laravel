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
        $now = now();

        User::insert([
            [
                'name' => 'アムロ',
                'email' => 'amuro@sample.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'セイラ',
                'email' => 'seira@sample.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'created_at' => $now,
                'updated_at' => $now,

            ],
            [
                'name' => 'ブライト',
                'email' => 'blight@sample.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,

            ],

        ]);
    }
}
