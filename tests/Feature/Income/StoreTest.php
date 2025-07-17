<?php

namespace Tests\Feature\Income;

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

    public function test_storeIncome_成功(): void
    {
        // ログイン用にユーザデータ取得
        $user = User::first();

        // ログイン処理
        $this->actingAs($user);

        // リクエストデータ
        $data = [
            'category_id' => 1,
            'amount' => 100000,
            'content' => 'アプリ収益',
            'memo' => '広告収入',
        ];

        $response = $this->postJson(('/api/v1/income/store'), $data);

        dump($response->json());

        $response->assertStatus(200);

        // DBに保存されているか検証
        $this->assertDatabaseHas('incomes', [
            'category_id' => 1,
            'amount' => 100000,
            'content' => 'アプリ収益',
            'memo' => '広告収入',
        ]);
    }
}
