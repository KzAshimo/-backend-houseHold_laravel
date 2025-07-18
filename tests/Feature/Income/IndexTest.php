<?php

namespace Tests\Feature\Income;

use App\Models\Income;
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

    public function test_indexIncomes成功(): void
    {
        // ユーザデータ取得
        $user = User::first();

        // ログイン処理 / indexリクエスト
        $response = $this->actingAs($user)->getJson('/api/v1/income/index');

        $incomes = Income::with(['user', 'category'])->get();

        dump($response->json());

        $response->assertStatus(200);

        foreach ($incomes as $income) {
            $response->assertJsonFragment([
                'id' => $income->id,
                'user' => $income->user->name,
                'category' => $income->category->name,
                'amount' => $income->amount,
                'memo' => $income->memo,
            ]);
        }
    }
}
