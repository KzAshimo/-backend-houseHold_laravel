<?php

namespace Tests\Feature\Expense;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

    /**
     * A basic feature test example.
     */
    public function test_showExpense_成功(): void
    {
        // ユーザー認証
        $user = User::first();
        // ログイン処理
        $this->actingAs($user);

        $expense = Expense::find(1);

        $response = $this->getJson("/api/v1/expense/{$expense->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $expense->id,
                    'user' => $expense->user->name,
                    'category' => $expense->category->name,
                    'amount' => $expense->amount,
                    'content' => $expense->content,
                    'memo' => $expense->memo,
                ]
            ]);
    }

    public function test_showExpense_存在しないデータ(): void
    {
        // ユーザー認証
        $user = User::first();
        // ログイン処理
        $this->actingAs($user);

        $response = $this->getJson("/api/v1/expense/4");

        $response->assertStatus(422);
    }

    public function test_showExpense_バリデーションエラー(): void
    {
        // ユーザー認証
        $user = User::first();
        // ログイン処理
        $this->actingAs($user);

        $response = $this->getJson("/api/v1/expense/aaaa");

        $response->assertStatus(422);
    }
}
