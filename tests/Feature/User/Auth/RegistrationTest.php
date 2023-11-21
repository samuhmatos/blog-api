<?php

namespace Tests\Feature\User\Auth;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected $PATH = "/api/auth/register";

    public function test_new_users_can_register(): void
    {
        $user = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson($this->PATH, $user);

        $response->assertCreated()->assertJsonFragment([
            'name'=> $user['name'],
            'username'=> str()->slug($user['name']),
            'email'=> $user['email'],
        ]);
        $this->assertAuthenticated();
    }

    public function test_it_should_create_slug_additional_if_when_already_exist(): void
    {
        $user = User::factory()->create();

        $user = [
            'name' => $user->name,
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson($this->PATH, $user);

        $this->assertAuthenticated();
        $response->assertCreated()->assertJsonFragment([
            'name'=> $user['name'],
            'email'=> $user['email'],
        ]);
    }

    public function test_it_should_return_422_when_not_providing_data():void
    {
        $response = $this->postJson($this->PATH, []);
        $this->assertFalse($this->isAuthenticated());
        $response->assertUnprocessable();
    }
}
