<?php

namespace Tests\Feature\PostComment;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeletePostCommentTest extends TestCase
{
    use RefreshDatabase;

    protected function path(int $commentId):string
    {
        return "/api/comment/{$commentId}/";
    }

    public function test_it_should_delete_a_post_comment(): void
    {
        $user = User::factory()->create();
        PostCategory::factory()->create();
        $post = Post::factory()->create();


        $postComment = PostComment::factory()
            ->set('post_id', $post->id)
            ->set('user_id', $user->id)
            ->create();

        $response = $this->actingAs($user)
            ->deleteJson($this->path($postComment->id));

        $response->assertNoContent();
    }

    public function test_it_should_return_404_when_providing_comment_id_not_exist(): void
    {
        $user = User::factory()->create();
        PostCategory::factory()->create();


        $response = $this->actingAs($user)
            ->deleteJson($this->path(207087));

        $response->assertNotFound();
    }

    public function test_it_should_return_403_when_user_is_not_the_owner_comment():void
    {
        $userCommentOwner = User::factory()->create();
        $randomUser = User::factory()->create();

        PostCategory::factory()->create();
        $post = Post::first();
        $postComment = PostComment::factory()
            ->set('post_id', $post->id)
            ->set('user_id', $userCommentOwner->id)
            ->create();

        $response = $this->actingAs($randomUser)
            ->deleteJson($this->path($postComment->id));

        $response->assertForbidden();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated():void
    {
        User::factory()->create();
        PostCategory::factory()->create();
        $post = Post::factory()->create();
        $postComment = PostComment::factory()->set('post_id', $post->id)->create();

        $response = $this->deleteJson($this->path($postComment->id));

        $response->assertUnauthorized();
    }
}
