<?php

namespace Tests\Feature\Notification;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_showCategory_成功(): void
    {
        // ユーザー認証
        $user = User::first();
        // ログイン処理
        $this->actingAs($user);

        $notification = Notification::find(1);

        $response = $this->getJson("/api/v1/notification/{$notification->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $notification->id,
                    'user' => $notification->user->name,
                    'title' => $notification->title,
                    'content' => $notification->content,
                    'type' => $notification->type,
                    'start_date' => $notification->start_date,
                    'end_date' => $notification->end_date,
                ]
            ]);
    }

    public function test_showCategory_存在しないデータ(): void
    {
        // ユーザー認証
        $user = User::first();
        // ログイン処理
        $this->actingAs($user);

        $response = $this->getJson("/api/v1/notification/4");

        $response->assertStatus(422);
    }

    public function test_showCategory_バリデーションエラー(): void
    {
        // ユーザー認証
        $user = User::first();
        // ログイン処理
        $this->actingAs($user);

        $response = $this->getJson("/api/v1/notification/aaaa");

        $response->assertStatus(422);
    }
}
