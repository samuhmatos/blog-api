<?php

namespace Tests\Feature\PostReaction;

use App\Enums\ReactionType;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Template;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePostReactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_create_a_post_reaction(): void
    {
        User::factory()->create();
        $user = User::factory()->set('is_admin', true)->create();
        Template::factory()->create();
        PostCategory::factory()->create();
        $post = Post::factory()->create();

        $payload = [
            'type'=> rand(0,1) == 1 ? ReactionType::LIKE : ReactionType::UNLIKE
        ];

        $response = $this->actingAs($user)->postJson("/api/post/{$post->id}/reaction", $payload);

        $response->assertCreated();
    }

    public function test_it_should_return_422_when_not_providing_data()
    {
        User::factory()->create();
        $user = User::factory()->set('is_admin', true)->create();
        Template::factory()->create();
        PostCategory::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->postJson("/api/post/{$post->id}/reaction");

        $response->assertUnprocessable();
    }

    public function test_it_should_return_422_when_providing_wrong_type()
    {
        User::factory()->create();
        $user = User::factory()->set('is_admin', true)->create();
        Template::factory()->create();
        PostCategory::factory()->create();
        $post = Post::factory()->create();


        $payload = [
            'type'=> rand(0,1) == 1 ? "favorite" : "shared"
        ];

        $response = $this->actingAs($user)->postJson("/api/post/{$post->id}/reaction", $payload);

        $response->assertUnprocessable();
    }

    public function test_it_should_return_401_when_user_is_not_authenticated():void
    {
        $user = User::factory()->set('is_admin', true)->create();
        Template::factory()->create();
        PostCategory::factory()->create();
        $post = Post::factory()->create();


        $response = $this->postJson("/api/post/{$post->id}/reaction");
        $response->assertUnauthorized();
    }

    public function test_it_should_return_404_when_not_finding_post()
    {
        User::factory()->create();
        $user = User::factory()->set('is_admin', true)->create();
        Template::factory()->create();
        PostCategory::factory()->create();
        $post = Post::factory()->create();

        $payload = [
            'type'=> ReactionType::LIKE
        ];

        $response = $this->actingAs($user)->postJson("/api/post/2000/reaction", $payload);

        $response->assertNotFound();
    }


}
