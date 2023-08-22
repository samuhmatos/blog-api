<?php

namespace Tests\Feature\PostReaction;

use App\Models\PostComment;
use App\Models\PostCommentReaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeletePostCommentReactionTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_should_delete_a_comment_reaction(): void
    {
        $this->seed();
        $user = User::first();
        $postComment = PostComment::first();
        PostCommentReaction::factory()->set('comment_id', $postComment->id)->set('user_id', $user->id)->create();

        $response = $this->actingAs($user)->deleteJson("/api/comment/{$postComment->id}/reaction");

        $response->assertNoContent();
    }

    public function test_it_should_return_404_when_comment_not_found(): void
    {
        $this->seed();
        $user = User::first();
        $postComment = PostComment::first();
        PostCommentReaction::factory()->set('comment_id', $postComment->id)->set('user_id', $user->id)->create();

        $response = $this->actingAs($user)->deleteJson("/api/comment/3000/reaction");

        $response->assertNotFound();
    }

    public function test_it_should_return_404_when_comment_reaction_not_found(): void
    {
        $this->seed();
        $user = User::first();
        $postComment = PostComment::first();

        $response = $this->actingAs($user)->deleteJson("/api/comment/{$postComment->id}/reaction");

        $response->assertNotFound();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated(): void
    {
        $this->seed();
        $postComment = PostComment::first();
        $response = $this->deleteJson("/api/comment/{$postComment->id}/reaction");

        $response->assertUnauthorized();
    }
}
