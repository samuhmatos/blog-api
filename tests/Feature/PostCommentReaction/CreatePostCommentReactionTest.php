<?php

namespace Tests\Feature\PostCommentReaction;

use App\Enums\ReactionType;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePostCommentReactionTest extends TestCase
{
    use RefreshDatabase;

    public function init():array
    {
        User::factory()->set('is_admin', true)->create();
        $user = User::factory()->create();
        PostCategory::factory()->create();
        $post = Post::factory()->create();
        $comment = PostComment::factory()->create();

        return [
            'user' => $user,
            'post' => $post,
            'comment' => $comment
        ];
    }

    public function test_it_should_create_a_comment_reaction(): void
    {
        $data = $this->init();

        $payload = [
            'type'=> ReactionType::rand()
        ];

        $response = $this->actingAs($data['user'])->postJson("/api/comment/{$data['comment']->id}/reaction", $payload);

        $response->assertCreated();
    }

    public function test_it_should_return_422_when_not_providing_data()
    {
        $data = $this->init();

        $response = $this->actingAs($data['user'])->postJson("/api/comment/{$data['comment']->id}/reaction");

        $response->assertUnprocessable();
    }

    public function test_it_should_return_422_when_providing_wrong_data()
    {
        $data = $this->init();

        $payload = [
            'type'=> rand(0,1) == 1 ? "favorite" : "shared"
        ];

        $response = $this->actingAs($data['user'])->postJson("/api/comment/{$data['comment']->id}/reaction", $payload);

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated():void
    {
        $data = $this->init();

        $response = $this->postJson("/api/comment/{$data['comment']->id}/reaction");
        $response->assertUnauthorized();
    }

    public function test_it_should_return_404_when_not_finding_comment()
    {
        $data = $this->init();

        $payload = [
            'type'=> ReactionType::rand()
        ];

        $response = $this->actingAs($data['user'])->postJson("/api/comment/2000/reaction", $payload);

        $response->assertNotFound();
    }
}
