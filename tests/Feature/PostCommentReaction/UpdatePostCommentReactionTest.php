<?php

namespace Tests\Feature\PostCommentReaction;

use App\Enums\ReactionType;
use App\Models\PostComment;
use App\Models\PostCommentReaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePostCommentReactionTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_should_update_reaction_when_already_exist(): void
    {
        $this->seed();
        $user = User::first();
        $postComment = PostComment::first();
        PostCommentReaction::factory()->set('comment_id', $postComment->id)->set('user_id', $user->id)->create();

        $payload = [
            'type'=> ReactionType::rand()
        ];

        $response = $this->actingAs($user)->postJson("/api/comment/{$postComment->id}/reaction", $payload);

        $response->assertCreated();
        $response->dump();
    }
}
