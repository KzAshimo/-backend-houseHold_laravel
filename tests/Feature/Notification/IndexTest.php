<?php

namespace Tests\Feature\Notification;

use App\Models\Notification;
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

    public function test_indexNotification_成功(): void
    {
        // ユーザデータ取得
        $user = User::first();

        //ログイン処理 / indexリクエスト
        $response = $this->actingAs($user)->getJson('/api/v1/notification/index');

        $notifications = Notification::with(['user'])->get();

        $response->assertStatus(200);

        foreach ($notifications as $notification) {
            $response->assertJsonFragment([
                'id' => $notification->id,
                'user' => $notification->user->name,
                'title' => $notification->title,
                'content' => $notification->content,
                'type'=> $notification->type,
                'start_date' => $notification->start_date,
                'end_date' => $notification->end_date,
                'created_at' => $notification->created_at,
                'updated_at' => $notification->updated_at,
            ]);
        }
    }
}
