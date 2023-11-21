<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function path(int $userId):string
    {
        return "api/user/{$userId}";
    }

    public function test_it_should_update_the_user(): void
    {
        $user = User::factory()->set('is_admin', false)->create();

        Storage::fake('user_avatar');
        $file = UploadedFile::fake()->image('user_avatar.jpg');

        $response = $this->actingAs($user)
            ->postJson($this->path($user->id),[
                'name' => $this->faker->name(),
                'username'=> str()->slug($this->faker->name()),
                'image' => $file,
                'email' => $this->faker->email(),
            ]);

        $response->assertStatus(200);
    }

    public function test_it_should_return_401_when_user_not_match():void
    {
        $user = User::factory()->set('is_admin', false)->create();

        Storage::fake('user_avatar');
        $file = UploadedFile::fake()->image('user_avatar.jpg');

        $response = $this->postJson($this->path($user->id),[
            'name' => $this->faker->name(),
            'username'=> str()->slug($this->faker->name()),
            'image' => $file,
            'email' => $this->faker->email(),
        ]);

        $response->assertUnauthorized();
    }

    public function test_it_should_return_422_when_providing_wrong_confirm_password():void
    {
        $user = User::factory()->set('is_admin', false)->create();

        $response = $this->actingAs($user)->postJson($this->path($user->id),[
            'password' => "newPassword"
        ]);

        $response->assertUnprocessable();
    }
}
