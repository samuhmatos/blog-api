<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddPostViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_add_user_view_to_post()
    {
        User::factory()->set('is_admin', true)->create();
        PostCategory::factory()->create();

        $post = Post::factory()->set('views', 0)->create();

        $this->postJson("/api/post/{$post->id}/view")
            ->assertCreated();
    }
}
