<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_indexCategory_成功(): void
    {
        // ユーザデータ取得
        $user = User::first();

        //ログイン処理 / indexリクエスト
        $response = $this->actingAs($user)->getJson('/api/v1/category/index');

        $categories = Category::with(['user', 'expenses', 'incomes'])->get();

        $response->assertStatus(200);

        foreach($categories as $category) {
            $response->assertJsonFragment([
                'id' => $category->id,
                'user' => $category->user->name,
                'name' => $category->name,
                'type' => $category->type,
            ]);
        }
    }
}
