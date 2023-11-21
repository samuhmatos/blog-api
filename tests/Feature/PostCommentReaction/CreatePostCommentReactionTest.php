<?php

namespace Tests\Feature\PostCommentReaction;

use App\Enums\ReactionType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePostCommentReactionTest extends TestBase
{
    use RefreshDatabase;

    protected function path(int $commentId):string
    {
        return "/api/comment/{$commentId}/reaction";
    }

    public function test_it_should_create_a_comment_reaction(): void
    {
        $data = $this->init();
        $comment = $data['comment'];

        $payload = [
            'type'=> ReactionType::rand()
        ];

        $response = $this->actingAs($data['userComum'])
            ->postJson($this->path($comment->id), $payload);

        $response->assertCreated();
    }

    public function test_it_should_return_422_when_not_providing_data()
    {
        $data = $this->init();
        $comment = $data['comment'];

        $response = $this->actingAs($data['userComum'])
            ->postJson($this->path($comment->id));

        $response->assertUnprocessable();
    }

    public function test_it_should_return_422_when_providing_wrong_data()
    {
        $data = $this->init();
        $comment = $data['comment'];

        $payload = [
            'type'=> rand(0,1) == 1 ? "favorite" : "shared"
        ];

        $response = $this->actingAs($data['userComum'])
            ->postJson($this->path($comment->id), $payload);

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated():void
    {
        $data = $this->init();
        $comment = $data['comment'];

        $response = $this->postJson($this->path($comment->id));
        $response->assertUnauthorized();
    }

    public function test_it_should_return_404_when_not_finding_comment()
    {
        $data = $this->init();
        $comment = $data['comment'];

        $payload = [
            'type'=> ReactionType::rand()
        ];

        $response = $this->actingAs($data['userComum'])
            ->postJson("/api/comment/2000/reaction", $payload);

        $response->assertNotFound();
    }
}
