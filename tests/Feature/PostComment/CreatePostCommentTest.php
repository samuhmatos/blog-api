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
            'comment' => $this->faker()->realText(),
            'post_id' => $post->id,
        ];

        $response = $this->actingAs($user)->postJson("/api/comment", $payload);

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
            'post_id' => $post->id,
            'comment' => $this->faker()->realText(),
        ];

        $response = $this->actingAs($user)->postJson("/api/comment", $payload);

        $response->assertCreated();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated(): void
    {
        $this->seed();


        $response = $this->postJson("/api/comment");

        $response->assertUnauthorized();
    }

    public function test_it_should_return_422_when_provided_data_is_not_valid():void
    {
        $this->seed();
        $user = User::first();
        $post = Post::first();
        $postComment = PostComment::factory()->set('post_id', $post->id)->create();

        $payload = [
            'parent_id' => $postComment->id,
            'post_id' => $post->id,
        ];

        $response = $this->actingAs($user)->postJson("/api/comment", $payload);

        $response->assertUnprocessable();
    }
}
