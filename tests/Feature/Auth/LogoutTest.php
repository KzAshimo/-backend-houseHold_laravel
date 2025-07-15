<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    // setup
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_logout成功()
{
    $user = User::where('email', 'amuro@sample.com')->first();

    $response = $this
        ->actingAs($user)
        ->post('/logout');

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'Unauthenticated.'
    ]);

    $this->assertGuest();
}
}
