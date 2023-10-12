<?php

namespace Tests\Feature\PostComment;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeletePostCommentTest extends TestCase
{
    use RefreshDatabase;

    protected function path(int $postId, int $commentId):string
    {
        return "/api/post/{$postId}/comment/{$commentId}/";
    }

    public function test_it_should_delete_a_post_comment(): void
    {
        $this->seed();
        $userCommentOwner = User::factory()->create();

        $post = Post::first();

        $postComment = PostComment::factory()
            ->set('post_id', $post->id)
            ->set('user_id', $userCommentOwner->id)
            ->create();

        $response = $this->actingAs($userCommentOwner)
            ->deleteJson($this->path($post->id, $postComment->id));

        $response->assertNoContent();
    }

    public function test_it_should_return_403_when_providing_not_match_path(): void
    {
        $this->seed();
        $user = User::first();
        $post = Post::first();

        while ($user->id == $post->user_id) {
            $post = Post::first();
        }

        $response = $this->actingAs($user)
            ->deleteJson($this->path($post->id, 20));

        $response->assertForbidden();
    }

    public function test_it_should_return_403_when_user_is_not_the_owner_comment():void
    {
        $userCommentOwner = User::factory()->create();
        $user = User::factory()->set('is_admin', true)->create();

        $this->seed();
        $post = Post::first();
        $postComment = PostComment::factory()
            ->set('post_id', $post->id)
            ->set('user_id', $userCommentOwner->id)
            ->create();

        $response = $this->actingAs($user)
            ->deleteJson($this->path($post->id, $postComment->id));

        $response->assertForbidden();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated():void
    {
        $this->seed();
        $post = Post::first();
        $postComment = PostComment::factory()->set('post_id', $post->id)->create();

        $response = $this->deleteJson($this->path($post->id, $postComment->id));

        $response->assertUnauthorized();
    }
}
