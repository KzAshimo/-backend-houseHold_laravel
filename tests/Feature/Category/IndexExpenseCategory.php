<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexExpenseCategory extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_indexExpenseCategory_成功(): void
    {
        // ユーザデータ取得
        $user = User::first();

        // ログイン処理 / indexリクエスト
        $response = $this->actingAs($user)->getJson('/api/v1/category/index_expense');

        $expenseCategories = Category::where('type', 'expense')->get();

        $response->assertStatus(200);

        foreach ($expenseCategories as $expenseCategory) {
            $response->assertJsonFragment(
                [
                    'id' => $expenseCategory->id,
                    'name' => $expenseCategory->name,
                ]
            );
        }
    }
}
