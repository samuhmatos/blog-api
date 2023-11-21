<?php

namespace Tests\Feature\PostCommentReaction;

use App\Enums\ReactionType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePostCommentReactionTest extends TestBase
{
    use RefreshDatabase;
    public function test_it_should_update_reaction_when_already_exist(): void
    {
        $data = $this->init();
        $user = $data['userComum'];
        $postComment = $data['comment'];

        $payload = [
            'type'=> ReactionType::rand()
        ];

        $response = $this->actingAs($user)->postJson("/api/comment/{$postComment->id}/reaction", $payload);

        $response->assertCreated();
    }
}
