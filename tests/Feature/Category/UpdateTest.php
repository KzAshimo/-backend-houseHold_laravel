<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_updateCategory_成功(): void
    {
        // ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $category = Category::find(1);

        $response = $this->putJson("api/v1/category/$category->id", [
            'name' => 'test category',
            'type' => 'expense',
        ]);

        $response->assertStatus(200);

        // DB確認
        $this->assertDatabaseHas('categories', [
            'name' => 'test category',
            'type' => 'expense',
        ]);
    }

    public function test_updateCategory_権限無し(): void
    {
        // ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $category = Category::find(3);

        $response = $this->putJson("api/v1/category/$category->id", [
            'name' => 'test category',
            'type' => 'expense',
        ]);

        $response->assertStatus(403);
    }

    public function test_updateCategory_存在しないデータ(): void
    {
        // ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->putJson("api/v1/category/4", [
            'name' => 'test category',
            'type' => 'expense',
        ]);

        $response->assertStatus(404);
    }

    public function test_updateCategory_バリデーションエラー(): void
    {
        // ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $category = Category::find(1);

        $response = $this->putJson("api/v1/category/$category->id", [
            'name' => 9999,
            'type' => 'expense',
        ]);

        $response->assertStatus(422);
    }
}
