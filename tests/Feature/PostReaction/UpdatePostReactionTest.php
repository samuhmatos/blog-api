<?php

namespace Tests\Feature\PostReaction;

use App\Enums\ReactionType;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostReaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePostReactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_update_reaction_when_already_exist(): void
    {
        User::factory()->set('is_admin', true)->create();
        $user = User::factory()->create();
        PostCategory::factory()->create();
        $post = Post::factory()->create();
        PostReaction::factory()->set('post_id', $post->id)->set('user_id', $user->id)->create();

        $payload = [
            'type'=> rand(0,1) == 1 ? ReactionType::LIKE : ReactionType::UNLIKE
        ];

        $response = $this->actingAs($user)->postJson("/api/post/{$post->id}/reaction", $payload);

        $response->assertCreated();
        $response->dump();
    }
}
