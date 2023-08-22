<?php

namespace Tests\Feature\PostReaction;

use App\Models\Post;
use App\Models\PostReaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeletePostReactionTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_should_delete_a_post_reaction(): void
    {
        $this->seed();
        $user = User::factory()->set('is_admin', false)->create();
        $post = Post::factory()->create();
        PostReaction::factory()->set('post_id', $post->id)->set('user_id', $user->id)->create();

        $response = $this->actingAs($user)->deleteJson("/api/post/{$post->id}/reaction");

        $response->assertNoContent();
    }

    public function test_it_should_return_404_when_post_not_found(): void
    {
        $this->seed();
        $user = User::factory()->set('is_admin', false)->create();
        $post = Post::factory()->create();
        PostReaction::factory()->set('post_id', $post->id)->set('user_id', $user->id)->create();

        $response = $this->actingAs($user)->deleteJson("/api/post/3000/reaction");

        $response->assertNotFound();
    }

    public function test_it_should_return_404_when_post_reaction_not_found(): void
    {
        $this->seed();
        $user = User::factory()->set('is_admin', false)->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->deleteJson("/api/post/{$post->id}/reaction");

        $response->assertNotFound();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated(): void
    {
        $this->seed();
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/post/{$post->id}/reaction");

        $response->assertUnauthorized();
    }
}
