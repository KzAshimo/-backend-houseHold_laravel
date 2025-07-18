<?php

namespace Tests\Feature\Income;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    /**
     * A basic feature test example.
     */
    public function test_deleteIncome_成功(): void
    {
        // ログイン処理
        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->deleteJson('/api/v1/income/1');

        $response->assertStatus(200);
        $response->assertJson([
            'result' => true,
        ]);

        // DB確認
        $this->assertSoftDeleted('incomes', ['id' => 1]);
    }
}
