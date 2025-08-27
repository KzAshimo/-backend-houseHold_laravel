<?php

namespace Tests\Feature\Notification;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_updateNotification_成功(): void
    {
        // ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $notification = Notification::find(1);

        $start = now()->startOfSecond();
        $end = now()->addMonth()->startOfSecond();

        $response = $this->putJson("api/v1/notification/$notification->id", [
            'title' => 'the test',
            'content' => 'this is test',
            'type' => 'once',
            'start_date' => $start->toISOString(),
            'end_date' => $end->toISOString(),
        ]);

        $response->assertStatus(200);

        // DB確認
        $this->assertDatabaseHas('notifications', [
            'title' => 'the test',
            'content' => 'this is test',
            'type' => 'once',
            'start_date' => $notification->start_date,
            'end_date' => $notification->end_date,
        ]);
    }

    public function test_updateNotification_バリデーションエラー(): void
    {
        // ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $start = now()->startOfSecond();
        $end = now()->addMonth()->startOfSecond();

        $notification = Notification::find(1);

        $response = $this->putJson("api/v1/notification/$notification->id", [
            'title' => 99999,
            'content' => 'this is test',
            'type' => 'once',
            'start_date' => $start->toISOString(),
            'end_date' => $end->toISOString(),
        ]);

        $response->assertStatus(422);
    }

    public function test_updateNotification_存在しないデータ(): void
    {
        // ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $start = now()->startOfSecond();
        $end = now()->addMonth()->startOfSecond();

        $response = $this->putJson("api/v1/notification/4", [
            'title' => 'the test',
            'content' => 'this is test',
            'type' => 'once',
            'start_date' => $start->toISOString(),
            'end_date' => $end->toISOString(),
        ]);

        $response->assertStatus(404);
    }
}
