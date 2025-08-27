<?php

namespace Tests\Feature\Notification;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForLoginTest extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_example(): void
    {
        // ユーザデータ取得
        $user = User::first();

        //ログイン処理 / for_loginリクエスト
        $response = $this->actingAs($user)->getJson('/api/v1/notification/for_login');

        $notifications = Notification::all();
        $response->assertStatus(200);

        // 期待される通知だけを確認 (notification [1, 3])
        $response->assertJsonFragment([
            'id' => 1,
            'title' => 'notification1',
            'content' => 'this is notification no.1',
            'type' => 'always',
        ]);

        $response->assertJsonFragment([
            'id' => 3,
            'title' => 'notification3',
            'content' => 'this is notification no.3',
            'type' => 'once',
        ]);
    }
}
