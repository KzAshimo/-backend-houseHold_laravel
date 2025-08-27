<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        Notification::insert([
            [
                'title' => 'notification1',
                'user_id' => 1,
                'content' => 'this is notification no.1',
                'type' => 'always',
                'start_date' => $now,
                'end_date' => now()->addMonth(),
                'created_at' => $now,
                'updated_at' => $now,

            ],
            [
                'title' => 'notification2',
                'user_id' => 2,
                'content' => 'this is notification no.2',
                'type' => 'once',
                'start_date' => $now,
                'end_date' => now()->addMonth(),
                'created_at' => $now,
                'updated_at' => $now,

            ],
            [
                'title' => 'notification3',
                'user_id' => 3,
                'content' => 'this is notification no.3',
                'type' => 'once',
                'start_date' => $now,
                'end_date' => now()->addMonth(),
                'created_at' => $now,
                'updated_at' => $now,

            ],
        ]);
    }
}
