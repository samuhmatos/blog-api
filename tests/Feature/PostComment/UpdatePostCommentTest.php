<?php

namespace Tests\Feature\PostComment;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePostCommentTest extends TestBase
{
    use RefreshDatabase;
    use WithFaker;

    protected function path(int $commentId):string
    {
        return "/api/comment/{$commentId}";
    }

    public function test_it_should_update_the_post_comment(): void
    {
        $data = $this->init();
        $userCommentOwner = $data['user'];
        $post = $data['post'];

        $postComment = PostComment::factory()
            ->set('post_id', $post->id)
            ->set('user_id', $userCommentOwner->id)
            ->create();

        $payload = [
            'comment' => "New message content"
        ];

        $response = $this->actingAs($userCommentOwner)
            ->patchJson($this->path($postComment->id), $payload);

        $response->assertOk();
    }

    public function test_it_should_return_403_when_user_is_not_the_owner_comment():void
    {
        $data = $this->init();
        $userCommentOwner = $data['user'];
        $userRandom = $data['userAdmin'];
        $post = $data['post'];

        $postComment = PostComment::factory()
            ->set('post_id', $post->id)
            ->set('user_id', $userCommentOwner->id)
            ->create();

        $payload = [
            'comment' => "New message content"
        ];

        $response = $this->actingAs($userRandom)
            ->patchJson($this->path($postComment->id), $payload);

        $response->assertForbidden();
    }

    public function test_it_should_return_422_when_not_providing_data():void
    {
        $data = $this->init();
        $user = $data['user'];
        $post = $data['post'];

        $postComment = PostComment::factory()
            ->set('post_id', $post->id)
            ->set('user_id', $user->id)
            ->create();

        $response = $this->actingAs($user)
            ->patchJson($this->path($postComment->id));

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated():void
    {
        $data = $this->init();
        $post = $data['post'];

        $postComment = PostComment::factory()->set('post_id', $post->id)->create();

        $response = $this->patchJson($this->path($postComment->id));

        $response->assertUnauthorized();
    }
}
