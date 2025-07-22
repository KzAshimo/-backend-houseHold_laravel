<?php

namespace Tests\Feature\Category;

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

    public function test_storeCategory_成功(): void
    {
        // ログイン用にユーザデータ取得
        $user = User::first();

        // ログイン処理
        $this->actingAs($user);

        $data = [
            'user_id' => $user->id,
            'name' => '交際費',
            'type' => 'expense',
        ];

        $response = $this->postJson(('api/v1/category/store'), $data);

        $response->assertStatus(200);

        // DB確認
        $this->assertDatabaseHas('categories', [
            'user_id' => $user->id,
            'name' => '交際費',
            'type' => 'expense',
        ]);
    }

    public function test_storeCategory_バリデーションエラー(): void
    {
        // ログイン用にユーザデータ取得
        $user = User::first();

        // ログイン処理
        $this->actingAs($user);

        $data = [
            'user_id' => $user->id,
            'name' => 5555,
            'type' => 'expense',
        ];

        $response = $this->postJson(('api/v1/category/store'), $data);

        $response->assertStatus(422);
    }
}
