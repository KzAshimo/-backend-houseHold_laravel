<?php

namespace Tests\Feature\Income;

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

    public function test_storeIncome_成功(): void
    {
        // ログイン用にユーザデータ取得
        $user = User::first();

        // ログイン処理
        $this->actingAs($user);

        $response->assertStatus(200);
    }
}
