<?php

namespace Tests\Feature\Expense;

use App\Models\Expense;
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

    public function test_storeExpense_成功(): void
    {
        // ログイン用にユーザデータ取得
        $user = User::first();

        // ログイン処理
        $this->actingAs($user);

        $expense = Expense::find(2);

        // リクエストデータ
        $data = [
            'category_id' => $expense->id,
            'amount' => 5000,
            'content' => 'テスト費用',
            'memo' => '受講料',
        ];

        $response = $this->postJson(('/api/v1/expense/store'), $data);

        $response->assertStatus(200);

        // DB確認
        $this->assertDatabaseHas('expenses', [
            'category_id' => $expense->id,
            'amount' => 5000,
            'content' => 'テスト費用',
            'memo' => '受講料',
        ]);
    }

    public function test_storeIncome_バリデーションエラー(): void
    {
        // ログイン用にユーザデータ取得
        $user = User::first();

        // ログイン処理
        $this->actingAs($user);

        $expense = Expense::find(2);

        // リクエストデータ
        $data = [
            'category_id' => $expense->id,
            'amount' => 5000,
            'content' => 5000,
            'memo' => '受講料',
        ];

        $response = $this->postJson(('/api/v1/income/store'), $data);

        $response->assertStatus(422);
    }
}
