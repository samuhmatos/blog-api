<?php

namespace Tests\Feature\PostCategory;

use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePostCategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $path = "/api/postCategory/";

    public function test_it_should_create_a_post_category(): void
    {
        $user = User::factory()->set('is_admin', true)->create();

        $payload = [
            'name' => 'Category Test',
            'description' => $this->faker->realText(255)
        ];

        $response = $this->actingAs($user)
            ->postJson($this->path, $payload);

        $response->assertCreated();
    }

    public function test_it_should_return_422_when_category_name_already_exists():void
    {
        $user = User::factory()->set('is_admin', true)->create();
        $postCategory = PostCategory::factory()->create();

        $payload = [
            'name' => $postCategory->name,
            'description' => $this->faker->realText(255)
        ];

        $response = $this->actingAs($user)
            ->postJson($this->path, $payload);

        $response->assertUnprocessable();
    }

    public function test_it_should_return_422_when_not_providing_data():void
    {
        $user = User::factory()->set('is_admin', true)->create();


        $response = $this->actingAs($user)
            ->postJson($this->path);

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_user_are_not_authenticated():void
    {
        $user = User::factory()->set('is_admin', true)->create();

        $payload = [
            'name' => 'Category Test',
            'description' => $this->faker->realText(255)
        ];

        $response = $this->postJson($this->path, $payload);

        $response->assertUnauthorized();
    }

    public function test_it_should_return_403_when_user_are_not_authorized():void
    {
        $user = User::factory()->set('is_admin', false)->create();

        $response = $this->actingAs($user)
            ->postJson($this->path);

        $response->assertForbidden();
    }
}
