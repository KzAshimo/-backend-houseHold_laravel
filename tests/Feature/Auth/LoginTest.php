<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_user1_login成功(): void
    {
        $response = $this->postJson('/login', [
            'email' => 'amuro@sample.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'result' => true,
        ]);
    }
}
