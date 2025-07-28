<?php

namespace Tests\Feature\NotificationView;

use App\Models\NotificationView;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_indexNotificationView_成功(): void
    {
        // ユーザデータ取得
        $user = User::first();

        //ログイン処理 / indexリクエスト
        $response = $this->actingAs($user)->getJson('/api/v1/notification_view/index');

        $notificationViews = NotificationView::with(['user', 'notification'])->get();

        $response->assertStatus(200);

        foreach ($notificationViews as $notificationView) {
            $response->assertJsonFragment([
                'id' => $notificationView->id,
                'user' => $notificationView->user->name,
                'title' => $notificationView->notification->title,
                'created_at' => $notificationView->created_at->toJson(),
                'updated_at' => $notificationView->updated_at->toJson(),
            ]);
        }
    }
}
