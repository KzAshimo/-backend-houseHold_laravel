<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $category = Category::find(1);

        $response = $this->getJson("/api/v1/category/{$category->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $category->id,
                    'user' => $category->user->name,
                    'name' => $category->name,
                    'type' => $category->type,
                ]
            ]);
    }

    public function test_showCategory_存在しないデータ(): void
    {
                // ユーザー認証
        $user = User::first();
        // ログイン処理
        $this->actingAs($user);

        $response = $this->getJson("/api/v1/category/4");

        $response->assertStatus(422);
    }

    public function test_showCategory_バリデーションエラー(): void
    {
                // ユーザー認証
        $user = User::first();
        // ログイン処理
        $this->actingAs($user);

        $response = $this->getJson("/api/v1/category/aaaa");

        $response->assertStatus(422);
    }
}
