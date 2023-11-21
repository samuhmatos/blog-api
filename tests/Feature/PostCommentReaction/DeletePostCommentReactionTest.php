<?php

namespace Tests\Feature\PostCommentReaction;

use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletePostCommentReactionTest extends TestBase
{
    use RefreshDatabase;

    protected function path(int $commentId):string
    {
        return "/api/comment/{$commentId}/reaction";
    }

    public function test_it_should_delete_a_comment_reaction(): void
    {
        $data = $this->init();
        $user = $data['userComum'];
        $comment = $data['comment'];

        $response = $this->actingAs($user)
            ->deleteJson($this->path($comment->id));

        $response->assertNoContent();
    }

    public function test_it_should_return_404_when_comment_not_found(): void
    {
        $data = $this->init();
        $user = $data['userComum'];

        $response = $this->actingAs($user)
            ->deleteJson("/api/comment/3000/reaction");

        $response->assertNotFound();
    }

    public function test_it_should_return_404_when_comment_reaction_not_found(): void
    {
        $data = $this->init(false);
        $user = $data['userComum'];
        $comment = $data['comment'];

        $response = $this->actingAs($user)
            ->deleteJson($this->path($comment->id));

        $response->assertNotFound();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated(): void
    {
        $data = $this->init();
        $comment = $data['comment'];

        $response = $this->deleteJson($this->path($comment->id));

        $response->assertUnauthorized();
    }
}
