<?php

namespace Tests\Feature\PostReaction;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostReaction;
use App\Models\User;
use Tests\TestCase;

class TestBase extends TestCase
{
    protected function path(int $postId): string 
    {
        return "/api/post/{$postId}/reaction";
    }

    protected function init(bool $createReaction = false):array
    {
        $userComum = User::factory()->set('is_admin', false)->create();
        $user = User::factory()->set('is_admin', true)->create();
        PostCategory::factory()->create();
        $post = Post::factory()->create();

        if($createReaction){
            PostReaction::factory()
                ->set('post_id', $post->id)
                ->set('user_id', $user->id)
                ->create(); 
        }

        return compact('user', 'post', 'userComum');
    }
}