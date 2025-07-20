<?php

namespace Tests\Feature\Expense;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

    public function test_updateExpense_成功(): void
    {
        // ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $expense = Expense::find(1);

        $response = $this->putJson("/api/v1/expense/$expense->id", [
            'amount' => 9999,
            'content' => 'test',
            'memo' => 'memo test',
        ]);

        $response->assertStatus(200);

        // DB確認
        $this->assertDatabaseHas('expenses', [
            'amount' => 9999,
            'content' => 'test',
            'memo' => 'memo test',
        ]);
    }

    public function test_updateIncome_権限無し(): void
    {
        // ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $expense = Expense::find(2);

        $response = $this->putJson("/api/v1/expense/$expense->id", [
            'amount' => 9999,
            'content' => 'test',
            'memo' => 'memo test',
        ]);

        $response->assertStatus(403);
    }

    public function test_updateIncome_存在しないデータ(): void
    {
        // ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->putJson("/api/v1/expense/4", [
            'amount' => 9999,
            'content' => 'test',
            'memo' => 'memo test',
        ]);

        $response->assertStatus(404);
    }

    public function test_updateIncome_バリデーションエラー(): void
    {
        // ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $expense = Expense::find(1);

        $response = $this->putJson("/api/v1/expense/$expense->id", [
            'amount' => 9999,
            'content' => 9999,
            'memo' => 'memo test',
        ]);

        $response->assertStatus(422);
    }
}
