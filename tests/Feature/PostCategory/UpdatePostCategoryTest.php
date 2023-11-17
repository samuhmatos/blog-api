<?php

namespace Tests\Feature\PostCategory;

use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePostCategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function path(int $categoryId): string
    {
        return "/api/category/{$categoryId}";
    }

    public function test_it_should_update_a_post_category(): void
    {
        $user = User::factory()->set('is_admin', true)->create();
        $postCategory = PostCategory::factory()->create();

        $payload = [
            'name' => $postCategory->name,
            'slug' => $postCategory->slug,
            'description' => $this->faker->realText(255)
        ];

        $response = $this->actingAs($user)
            ->putJson($this->path($postCategory->id), $payload);

        $response->assertNoContent();
    }

    public function test_it_should_return_422_when_category_name_already_exists():void
    {
        $user = User::factory()->set('is_admin', true)->create();
        $postCategory = PostCategory::factory()->count(2)->create();

        $payload = [
            'name' => $postCategory[0]->name,
            'description' => $this->faker->realText(255)
        ];

        $response = $this->actingAs($user)
            ->putJson($this->path($postCategory[1]->id), $payload);

        $response->assertUnprocessable();
    }

    public function test_it_should_return_422_when_providing_wrong_data():void
    {
        $user = User::factory()->set('is_admin', true)->create();
        $postCategory = PostCategory::factory()->create();

        $payload = [
            'name' => $postCategory->name,
            'description' => $this->faker->realText(255).$this->faker->realText(255)
        ];

        $response = $this->actingAs($user)
            ->putJson($this->path($postCategory->id), $payload);

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_user_are_not_authenticated():void
    {
        $user = User::factory()->set('is_admin', true)->create();
        $postCategory = PostCategory::factory()->create();

        $response = $this->putJson($this->path($postCategory->id));

        $response->assertUnauthorized();
    }

    public function test_it_should_return_404_when_category_are_not_found():void
    {
        $user = User::factory()->set('is_admin', true)->create();

        $response = $this->actingAs($user)->putJson($this->path(1));

        $response->assertNotFound();
    }

    public function test_it_should_return_403_when_user_are_not_authorized():void
    {
        $user = User::factory()->set('is_admin', false)->create();
        $postCategory = PostCategory::factory()->create();

        $response = $this->actingAs($user)
            ->putJson($this->path($postCategory->id));

        $response->assertForbidden();
    }

}
