<?php

namespace Tests\Feature\Expense;

use App\Models\Expense;
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

    public function test_indexExpense_成功(): void
    {
        // ユーザデータ取得
        $user = User::first();

        // ログイン処理 / indexリクエスト
        $response = $this->actingAs($user)->getJson('/api/v1/expense/index');

        $expenses = Expense::with(['user', 'category'])->get();

        dump($response->json());

        $response->assertStatus(200);

        foreach ($expenses as $expense) {
            $response->assertJsonFragment([
                'id' => $expense->id,
                'user' => $expense->user->name,
                'category' => $expense->category->name,
                'amount' => $expense->amount,
                'memo' => $expense->memo,
            ]);
        }
    }
}
