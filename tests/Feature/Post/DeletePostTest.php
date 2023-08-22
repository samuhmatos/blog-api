<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Template;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeletePostTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_should_delete_a_post(): void
    {
        $this->seed();
        $user = User::query()->where('is_admin', true)->first();
        $post = Post::query()->where('author_id', $user->id)->first();

        $response = $this->actingAs($user)->deleteJson("/api/post/{$post->id}");

        $response->assertNoContent();
    }

    public function test_it_should_return_404_when_not_finding_post():void
    {
        $this->seed();
        $user = User::query()->where('is_admin', true)->first();

        $response = $this->actingAs($user)->deleteJson("/api/post/10000");

        $response->assertNotFound();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated():void
    {
        $this->seed();

        $response = $this->deleteJson("/api/post/10000");

        $response->assertUnauthorized();
    }

    public function test_it_should_return_403_when_user_is_not_authorized():void
    {
        $this->seed();
        $user = User::query()->where('is_admin', false)->first();
        $post = Post::first();

        $response = $this->actingAs($user)->deleteJson("/api/post/{$post->id}");

        $response->assertForbidden();
    }
}
