<?php

namespace Tests\Feature\Expense;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

    public function test_deleteExpense_成功(): void
    {
        // ユーザデータ取得 / ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $expense = Expense::find(1);

        $response = $this->deleteJson("/api/v1/expense/$expense->id");

        $response->assertStatus(200);
        $response->assertJson([
            'result' => true,
        ]);

        // DB確認
        $this->assertSoftDeleted('expenses', ['id' => 1]);
    }

    public function test_deleteExpense_権限無し(): void
    {
        // ユーザデータ取得 / ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $expense = Expense::find(2);

        $response = $this->deleteJson("/api/v1/expense/$expense->id");

        $response->assertStatus(403);
    }

    public function test_deleteExpense_存在しないデータ(): void
    {
        // ユーザデータ取得 / ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->deleteJson('/api/v1/expense/3');

        $response->assertStatus(422);
    }
}
