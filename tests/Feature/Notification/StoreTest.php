<?php

namespace Tests\Feature\Notification;

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

    public function test_storeNotification_成功(): void
    {
        // ログイン用にユーザデータ取得
        $user = User::first();

        // ログイン処理
        $this->actingAs($user);

        $start = now()->startOfSecond();
        $end = now()->addMonth()->startOfSecond();

        $data = [
            'user_id' => $user->id,
            'title' => 'testについて',
            'content' => 'これはtestです',
            'type' => 'always',
            'start_date' => $start->toISOString(),
            'end_date' => $end->toISOString(),
        ];

        $response = $this->postJson(('api/v1/notification/store'), $data);

        $response->assertStatus(200);

        // DB確認
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user->id,
            'title' => 'testについて',
            'content' => 'これはtestです',
            'type' => 'always',
            'start_date' => $start->toDateTimeString(),
            'end_date'   => $end->toDateTimeString(),
        ]);
    }

        public function test_storeNotification_バリデーションエラー(): void
    {
        // ログイン用にユーザデータ取得
        $user = User::first();

        // ログイン処理
        $this->actingAs($user);

        $start = now()->startOfSecond();
        $end = now()->addMonth()->startOfSecond();

        $data = [
            'user_id' => $user->id,
            'title' => 'testについて',
            'content' => 11111,
            'type' => 'always',
            'start_date' => $start->toISOString(),
            'end_date' => $end->toISOString(),
        ];

        $response = $this->postJson(('api/v1/notification/store'), $data);

        $response->assertStatus(422);
    }
}
