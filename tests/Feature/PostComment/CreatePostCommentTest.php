<?php

namespace Tests\Feature\PostComment;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePostCommentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    public function test_it_should_create_a_post_comment_without_parent_id(): void
    {
        $this->seed();
        $user = User::first();
        $post = Post::first();

        $payload = [
            'comment' => $this->faker()->realText(500)
        ];

        $response = $this->actingAs($user)->postJson("/api/post/{$post->id}/comment", $payload);

        $response->assertCreated();
    }

    public function test_it_should_create_a_post_comment_with_parent_id(): void
    {
        $this->seed();
        $user = User::first();
        $post = Post::first();
        $postComment = PostComment::factory()->set('post_id', $post->id)->create();

        $payload = [
            'parent_id' => $postComment->id,
            'comment' => $this->faker()->realText(500)
        ];

        $response = $this->actingAs($user)->postJson("/api/post/{$post->id}/comment", $payload);

        $response->assertCreated();
    }

    public function test_it_should_return_404_when_post_is_not_found()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson("/api/post/50000/comment", [
            'comment' => $this->faker->realText(500)
        ]);

        $response->assertNotFound();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated(): void
    {
        $this->seed();
        $post = Post::first();
        $postComment = PostComment::factory()->set('post_id', $post->id)->create();

        $payload = [
            'parent_id' => $postComment->id,
            'comment' => $this->faker()->realText(500)
        ];

        $response = $this->postJson("/api/post/{$post->id}/comment", $payload);

        $response->assertUnauthorized();
    }
}
