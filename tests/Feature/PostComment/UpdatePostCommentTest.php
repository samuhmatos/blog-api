<?php

namespace Tests\Feature\PostComment;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostComment;
use App\Models\Template;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePostCommentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    public function test_it_should_update_the_post_comment(): void
    {
        $this->seed();
        $userCommentOwner = User::factory()->create();
        $user = User::factory()->set('is_admin', true)->create();

        $post = Post::first();

        $postComment = PostComment::factory()
            ->set('post_id', $post->id)
            ->set('user_id', $userCommentOwner->id)
            ->create();

        $payload = [
            'comment' => "New message content"
        ];

        $response = $this->actingAs($userCommentOwner)->patchJson("/api/post/{$post->id}/comment/{$postComment->id}", $payload);

        $response->assertCreated();
        $response->dump();
    }

    public function test_it_should_return_403_when_providing_not_match_path(): void
    {
        $this->seed();
        $user = User::first();
        $post = Post::first();

        $payload = [
            'comment' => "New message content"
        ];

        $response = $this->actingAs($user)->patchJson("/api/post/{$post->id}/comment/20", $payload);

        $response->assertForbidden();
    }

    public function test_it_should_return_403_when_user_is_not_the_owner_comment():void
    {
        $userCommentOwner = User::factory()->create();
        $user = User::factory()->set('is_admin', true)->create();

        Template::factory()->create();
        PostCategory::factory()->create();
        $post = Post::factory()->create();
        $postComment = PostComment::factory()
            ->set('post_id', $post->id)
            ->set('user_id', $userCommentOwner->id)
            ->create();

        $payload = [
            'comment' => "New message content"
        ];

        $response = $this->actingAs($user)->patchJson("/api/post/{$post->id}/comment/{$postComment->id}", $payload);

        $response->assertForbidden();
    }

    public function test_it_should_return_422_when_not_providing_data():void
    {
        $this->seed();
        $user = User::first();
        $post = Post::first();
        $postComment = PostComment::factory()->set('post_id', $post->id)->create();

        $response = $this->actingAs($user)->patchJson("/api/post/{$post->id}/comment/{$postComment->id}");

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated():void
    {
        $this->seed();
        $post = Post::first();
        $postComment = PostComment::factory()->set('post_id', $post->id)->create();

        $response = $this->patchJson("/api/post/{$post->id}/comment/{$postComment->id}");

        $response->assertUnauthorized();
    }
}
