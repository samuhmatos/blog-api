<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function test_it_should_update_the_user(): void
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/user/{$user->id}",[
            'name' => $this->faker->name(),
            'username'=> str()->slug($this->faker->name()),
            'image_url' => $this->faker->image(),
            'email' => $this->faker->email(),
        ]);

        $response->assertStatus(200);
    }
}
