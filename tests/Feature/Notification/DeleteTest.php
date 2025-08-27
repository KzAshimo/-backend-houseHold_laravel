<?php

namespace Tests\Feature\Notification;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_deleteNotification_成功(): void
    {
        // ユーザデータ取得 / ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $notification = Notification::find(1);

        $response = $this->deleteJson("/api/v1/notification/$notification->id");

        $response->assertStatus(200);
        $response->assertJson([
            'result' => true,
        ]);

        // DB確認
        $this->assertSoftDeleted('notifications', ['id' => 1]);
    }

    public function test_deleteNotification_権限無し(): void
    {
        // ユーザデータ取得 / ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $notification = Notification::find(2);

        $response = $this->deleteJson("/api/v1/notification/$notification->id");

        $response->assertStatus(403);
    }

    public function test_deleteNotification_存在しないデータ(): void
    {
        // ユーザデータ取得 / ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->deleteJson("/api/v1/notification/4");

        $response->assertStatus(422);
    }
}
