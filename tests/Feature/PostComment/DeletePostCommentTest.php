<?php

namespace Tests\Feature\PostComment;

use App\Models\PostComment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletePostCommentTest extends TestBase
{
    use RefreshDatabase;

    protected function path(int $commentId):string
    {
        return "/api/comment/{$commentId}/";
    }

    public function test_it_should_delete_a_post_comment(): void
    {
        $data = $this->init();

        $user = $data['user'];
        $post = $data['post'];

        $postComment = PostComment::factory()
            ->set('post_id', $post->id)
            ->set('user_id', $user->id)
            ->create();

        $response = $this->actingAs($user)
            ->deleteJson($this->path($postComment->id));

        $response->assertNoContent();
    }

    public function test_it_should_return_404_when_providing_comment_id_that_do_not_exist(): void
    {
        $data = $this->init();

        $response = $this->actingAs($data['user'])
            ->deleteJson($this->path(207087));

        $response->assertNotFound();
    }

    public function test_it_should_return_403_when_user_is_not_the_owner_comment():void
    {
        $data = $this->init();

        $userCommentOwner = $data['userAdmin'];
        $randomUser =   $data['user'];
        $post = $data['post'];

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
        $data = $this->init();

        $post = $data['post'];
        $postComment = PostComment::factory()->set('post_id', $post->id)->create();

        $response = $this->deleteJson($this->path($postComment->id));

        $response->assertUnauthorized();
    }
}
