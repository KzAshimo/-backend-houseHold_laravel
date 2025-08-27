<?php

namespace Tests\Feature\Income;

use App\Models\Income;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_showIncome_成功(): void
    {
        // ユーザー認証
        $user = User::first();
        // ログイン処理
        $this->actingAs($user);

        $income = Income::find(1);

        $response = $this->getJson("/api/v1/income/{$income->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $income->id,
                    'user' => $income->user->name,
                    'category' => $income->category->name,
                    'amount' => $income->amount,
                    'content' => $income->content,
                    'memo' => $income->memo,
                ]
            ]);
    }

        public function test_showIncome_存在しないデータ(): void
    {
        // ユーザー認証
        $user = User::first();
        // ログイン処理
        $this->actingAs($user);

        $response = $this->getJson("/api/v1/income/4");

        $response->assertStatus(422);
    }

        public function test_showIncome_バリデーションエラー(): void
    {
        // ユーザー認証
        $user = User::first();
        // ログイン処理
        $this->actingAs($user);

        $response = $this->getJson("/api/v1/income/aaa");

        $response->assertStatus(422);
    }

}
