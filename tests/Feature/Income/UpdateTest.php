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
            'amount' => '9999',
            'content' => 'test',
            'memo' => 'memo test',
        ]);

        $response->assertStatus(200);

        dump($response->json());

        // DB確認
        $this->assertDatabaseHas('incomes', [
            'amount' => '9999',
            'content' => 'test',
            'memo' => 'memo test',
        ]);
    }
}
