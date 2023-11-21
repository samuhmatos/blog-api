<?php

namespace Tests\Feature\PostCategory;

use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeletePostCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function path(int $categoryId): string
    {
        return "/api/category/{$categoryId}";
    }

    public function test_it_should_delete_category(): void
    {
        $user = User::factory()->set('is_admin', true)->create();
        $postCategory = PostCategory::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson($this->path($postCategory->id));

        $response->assertNoContent();
    }

    public function test_it_should_return_401_when_user_are_not_authenticated():void
    {
        $postCategory = PostCategory::factory()->create();

        $response = $this->deleteJson($this->path($postCategory->id));

        $response->assertUnauthorized();
    }

    public function test_it_should_return_404_when_category_does_not_exist():void
    {
        $user = User::factory()->set('is_admin', true)->create();

        $response = $this->actingAs($user)
            ->deleteJson($this->path(1));

        $response->assertNotFound();
    }

    public function test_it_should_return_403_when_user_are_not_authorized():void
    {
        $user = User::factory()->set('is_admin', false)->create();
        $postCategory = PostCategory::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson($this->path($postCategory->id));

        $response->assertForbidden();
    }
}
