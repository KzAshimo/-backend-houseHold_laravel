<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_deleteCategory_成功(): void
    {
        // ユーザデータ取得 / ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $category = Category::find(1);

        $response = $this->deleteJson("/api/v1/category/$category->id");

        $response->assertStatus(200);
        $response->assertJson([
            'result' => true,
        ]);

        // DB確認
        $this->assertSoftDeleted('categories', ['id' => 1]);
    }

    public function test_deleteCategory_権限無し(): void
    {
        // ユーザデータ取得 / ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $category = Category::find(3);

        $response = $this->deleteJson("/api/v1/category/$category->id");

        $response->assertStatus(403);
    }

    public function test_deleteCategory_存在しないデータ(): void
    {
        // ユーザデータ取得 / ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->deleteJson("/api/v1/category/4");

        $response->assertStatus(422);
    }
}
