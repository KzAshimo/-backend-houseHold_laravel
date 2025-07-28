<?php

namespace Tests\Feature\NotificationView;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_storeNotificationView_成功(): void
    {
        // ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $notification = Notification::find(3);

        $response = $this->postJson("api/v1/notification_view/$notification->id");

        $response->assertStatus(200);

        $this->assertDatabaseHas('notification_views', [
            'user_id' => $user->id,
            'notification_id' => $notification->id,
        ]);
    }
}
