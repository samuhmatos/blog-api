<?php

namespace Tests\Feature\Post;

use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletePostTest extends PostBase
{
    use RefreshDatabase;

    protected function path(int $postId): string
    {
        return "/api/post/{$postId}";
    }


    public function test_it_should_delete_a_post(): void
    {
        $data = $this->init();
        $user = $data['user'];
        $post = $data['post'];

        $response = $this->actingAs($user)
            ->deleteJson($this->path($post->id));

        $response->assertNoContent();
    }

    public function test_it_should_return_404_when_not_finding_post():void
    {
        $data = $this->init();
        $user = $data['user'];

        $response = $this->actingAs($user)->deleteJson($this->path(1000));

        $response->assertNotFound();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated():void
    {
        $this->init();

        $response = $this->deleteJson($this->path(1000));

        $response->assertUnauthorized();
    }

    public function test_it_should_return_403_when_user_is_not_authorized():void
    {
        $data = $this->init();
        $user = $data['userComum'];
        $post = $data['post'];

        $response = $this->actingAs($user)
            ->deleteJson($this->path($post->id));

        $response->assertForbidden();
    }
}
