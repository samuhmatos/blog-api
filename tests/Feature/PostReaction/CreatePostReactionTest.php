<?php

namespace Tests\Feature\PostReaction;

use App\Enums\ReactionType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePostReactionTest extends TestBase
{
    use RefreshDatabase;

    public function test_it_should_create_a_post_reaction(): void
    {
        $data = $this->init();
        $user = $data['user'];
        $post = $data['post'];

        $payload = [
            'type'=> rand(0,1) == 1 ? ReactionType::LIKE : ReactionType::UNLIKE
        ];

        $response = $this->actingAs($user)
            ->postJson($this->path($post->id), $payload);

        $response->assertCreated();
    }

    public function test_it_should_return_422_when_not_providing_data()
    {
        $data = $this->init();
        $user = $data['user'];
        $post = $data['post'];

        $response = $this->actingAs($user)
            ->postJson($this->path($post->id));

        $response->assertUnprocessable();
    }

    public function test_it_should_return_422_when_providing_wrong_type()
    {
        $data = $this->init();
        $user = $data['user'];
        $post = $data['post'];

        $payload = [
            'type'=> rand(0,1) == 1 ? "favorite" : "shared"
        ];

        $response = $this->actingAs($user)
            ->postJson($this->path($post->id), $payload);

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated():void
    {
        $data = $this->init();
        $post = $data['post'];

        $response = $this->postJson($this->path($post->id));

        $response->assertUnauthorized();
    }

    public function test_it_should_return_404_when_not_finding_post()
    {
        $data = $this->init();
        $user = $data['user'];

        $payload = [
            'type'=> ReactionType::LIKE
        ];

        $response = $this->actingAs($user)
            ->postJson($this->path(3000), $payload);

        $response->assertNotFound();
    }


}
