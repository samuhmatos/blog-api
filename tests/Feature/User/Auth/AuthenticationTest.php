<?php

namespace Tests\Feature\User\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected $path = '/api/auth/login';

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson($this->path, [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertOk();
        $response->decodeResponseJson();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson($this->path, [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertUnprocessable();
        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_with_invalid_email(): void
    {
        $response = $this->postJson($this->path, [
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);

        $response->assertUnprocessable();
        $this->assertGuest();
    }


    public function test_it_should_return_422_when_not_providing_data(): void
    {
        $response = $this->postJson($this->path);

        $response->assertUnprocessable();
        $this->assertGuest();
    }
}
