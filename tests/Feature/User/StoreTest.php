<?php

namespace Tests\Feature\User;

use App\Enums\User\RoleEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_storeUser_成功(): void
    {
        $response = $this->postJson('/api/v1/user/store', [
            'name' => 'testUser',
            'email' => 'test@sample.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'user',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => 'testUser',
            'email' => 'test@sample.com',
            'role' => RoleEnum::USER,
        ]);
    }
}
