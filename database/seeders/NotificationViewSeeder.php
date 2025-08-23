<?php

namespace Database\Seeders;

use App\Models\NotificationView;
use Illuminate\Database\Seeder;

class NotificationViewSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        NotificationView::insert([
            [
                'user_id' => 1,
                'notification_id' => 1,
                'viewed_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 1,
                'notification_id' => 2,
                'viewed_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}
