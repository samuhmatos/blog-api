<?php

namespace Tests\Feature\User\Auth;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $user = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/register', $user);

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

        $response = $this->postJson('/api/register', $user);

        $this->assertAuthenticated();
        $response->assertCreated()->assertJsonFragment([
            'name'=> $user['name'],
            'email'=> $user['email'],
        ]);
    }
}
