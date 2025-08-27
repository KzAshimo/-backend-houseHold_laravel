<?php

namespace Tests\Feature\Income;

use App\Models\Income;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_updateIncome_成功(): void
    {
        // ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->putJson("/api/v1/income/1", [
            'amount' => 9999,
            'content' => 'test',
            'memo' => 'memo test',
        ]);

        $response->assertStatus(200);

        dump($response->json());

        // DB確認
        $this->assertDatabaseHas('incomes', [
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

        $response = $this->putJson("/api/v1/income/3", [
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

        $response = $this->putJson("/api/v1/income/4", [
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

        $response = $this->putJson("/api/v1/income/1", [
            'amount' => 9999,
            'content' => 9999,
            'memo' => 'memo test',
        ]);

        $response->assertStatus(422);
    }
}
