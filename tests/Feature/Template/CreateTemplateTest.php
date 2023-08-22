<?php

namespace Tests\Feature\Template;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateTemplateTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function test_it_should_create_a_template(): void
    {
        $user = User::factory()->set('is_admin', true)->create();

        Storage::fake('template_image');
        $file = UploadedFile::fake()->image('template_image.jpg');

        $response = $this->actingAs($user)->postJson('/api/template',[
            'name' => $this->faker()->realText(100),
            'description' => $this->faker()->realText(),
            rand(0,1) == 1 && 'image' => $file,
        ]);

        $response->assertCreated();
    }

    public function test_it_should_return_422_when_providing_wrong_data()
    {
        $user = User::factory()->set('is_admin', true)->create();
        $response = $this->actingAs($user)->postJson('/api/template');

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated():void
    {
        Storage::fake('template_image');
        $file = UploadedFile::fake()->image('template_image.jpg');

        $response = $this->postJson('/api/template',[
            'name' => $this->faker()->realText(100),
            'description' => $this->faker()->realText(),
            rand(0,1) == 1 && 'image' => $file,
        ]);

        $response->assertUnauthorized();
    }

    public function test_it_should_return_403_when_user_is_not_authorized():void
    {
        $user = User::factory()->set('is_admin', false)->create();

        Storage::fake('template_image');
        $file = UploadedFile::fake()->image('template_image.jpg');

        $response = $this->actingAs($user)->postJson('/api/template',[
            'name' => $this->faker()->realText(100),
            'description' => $this->faker()->realText(),
            rand(0,1) == 1 && 'image' => $file,
        ]);

        $response->assertForbidden();
    }
}
