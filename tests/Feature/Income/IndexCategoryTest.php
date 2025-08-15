<?php

namespace Tests\Feature\Income;

use App\Models\Income;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexCategoryTest extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_indexIncomeCategory成功(): void
    {
        // ユーザデータ取得
        $user = User::first();

        // ログイン処理 / indexリクエスト
        $response = $this->actingAs($user)->getJson('/api/v1/income/index_category');

        $categories = Income::with('category')->get();

        $response->assertStatus(200);

        foreach ($categories as $category) {
            $response->assertJsonFragment(
                [
                    'id' => $category->id,
                    'name' => $category->category->name,
                ]
            );
        }
    }
}
