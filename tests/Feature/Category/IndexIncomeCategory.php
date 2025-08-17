<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexIncomeCategory extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_indexIncomeCategory_成功(): void
    {
        // ユーザデータ取得
        $user = User::first();

        // ログイン処理 / indexリクエスト
        $response = $this->actingAs($user)->getJson('/api/v1/category/index_income');

        $incomeCategories = Category::where('type', 'income')->get();

        $response->assertStatus(200);

        foreach ($incomeCategories as $incomeCategory) {
            $response->assertJsonFragment(
                [
                    'id' => $incomeCategory->id,
                    'name' => $incomeCategory->name,
                ]
            );
        }
    }
}
