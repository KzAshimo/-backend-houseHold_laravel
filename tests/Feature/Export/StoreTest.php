<?php

namespace Tests\Feature\Export;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_storeExport_成功(): void
    {
        // ログイン用にユーザデータ取得
        $user = User::first();

        // ログイン処理
        $this->actingAs($user);

        $from = now()->startOfSecond();
        $to = now()->addMonth()->startOfSecond();

        $data = [
            'type' => 'income',
            'period_from' => $from->toDateString(),
            'period_to' => $to->toDateString(),
        ];

        $response = $this->postJson(('api/v1/export/store'), $data);

        $response->assertStatus(200);

        // DB確認
        $this->assertDatabaseHas('exports', [
            'user_id' => $user->id,
            'type' => 'income',
            'status' => 'pending',
            'period_from' => $from->toDateTimeString(),
            'period_to' => $to->toDateTimeString(),
        ]);
    }

    public function test_storeExport_バリデーションエラー(): void
    {
        // ログイン用にユーザデータ取得
        $user = User::first();

        // ログイン処理
        $this->actingAs($user);

        $from = now()->startOfSecond();
        $to = now()->addMonth()->startOfSecond();

        $data = [
            'type' => 'out',
            'period_from' => $from->toDateString(),
            'period_to' => $to->toDateString(),
        ];

        $response = $this->postJson(('api/v1/export/store'), $data);

        $response->assertStatus(422);
    }
}
