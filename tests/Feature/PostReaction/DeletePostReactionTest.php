<?php

namespace Tests\Feature\PostReaction;

use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletePostReactionTest extends TestBase
{
    use RefreshDatabase;
    public function test_it_should_delete_a_post_reaction(): void
    {
        $data = $this->init(true);
        $user = $data['user'];
        $post = $data['post'];

        $response = $this->actingAs($user)
            ->deleteJson($this->path($post->id));

        $response->assertNoContent();
    }

    public function test_it_should_return_404_when_post_not_found(): void
    {
        $data = $this->init(true);
        $user = $data['user'];

        $response = $this->actingAs($user)
            ->deleteJson($this->path(3000));

        $response->assertNotFound();
    }

    public function test_it_should_return_404_when_post_reaction_not_found(): void
    {
        
        $data = $this->init();
        $user = $data['user'];
        $post = $data['post'];

        $response = $this->actingAs($user)
            ->deleteJson($this->path($post->id));

        $response->assertNotFound();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated(): void
    {
        
        $data = $this->init(true);
        $post = $data['post'];

        $response = $this->deleteJson($this->path($post->id));

        $response->assertUnauthorized();
    }
}
