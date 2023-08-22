<?php

namespace Tests\Feature\PostCommentReaction;

use App\Enums\ReactionType;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePostCommentReactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_create_a_comment_reaction(): void
    {
        $this->seed();
        $user = User::factory()->create();
        $postComment = PostComment::first();

        $payload = [
            'type'=> ReactionType::rand()
        ];

        $response = $this->actingAs($user)->postJson("/api/comment/{$postComment->id}/reaction", $payload);

        $response->assertCreated();
    }

    public function test_it_should_return_422_when_not_providing_data()
    {
        $this->seed();
        $user = User::factory()->create();
        $postComment = PostComment::first();

        $response = $this->actingAs($user)->postJson("/api/comment/{$postComment->id}/reaction");

        $response->assertUnprocessable();
    }

    public function test_it_should_return_422_when_providing_wrong_data()
    {
        $this->seed();
        $user = User::factory()->create();
        $postComment = PostComment::first();

        $payload = [
            'type'=> rand(0,1) == 1 ? "favorite" : "shared"
        ];

        $response = $this->actingAs($user)->postJson("/api/comment/{$postComment->id}/reaction", $payload);

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated():void
    {
        $this->seed();
        $user = User::factory()->create();
        $postComment = PostComment::first();

        $response = $this->postJson("/api/comment/{$postComment->id}/reaction");
        $response->assertUnauthorized();
    }

    public function test_it_should_return_404_when_not_finding_comment()
    {
        $this->seed();
        $user = User::factory()->create();
        $postComment = PostComment::first();

        $payload = [
            'type'=> ReactionType::rand()
        ];

        $response = $this->actingAs($user)->postJson("/api/comment/2000/reaction", $payload);

        $response->assertNotFound();
    }
}
