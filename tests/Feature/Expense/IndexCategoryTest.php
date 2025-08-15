<?php

namespace Tests\Feature\Expense;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_indexExpenseCategory成功(): void
    {
        // ユーザデータ取得
        $user = User::first();

        // ログイン処理 / indexリクエスト
        $response = $this->actingAs($user)->getJson('/api/v1/expense/index_category');

        $categories = Expense::with('category')->get();

        $response->assertStatus(200);

        foreach ($categories as $category) {
            $response->assertJsonFragment(
                [
                    'category' => $category->category->name,
                ]
            );
        }
    }
}
