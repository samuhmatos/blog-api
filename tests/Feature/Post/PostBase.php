<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Tests\TestCase;

class PostBase extends TestCase {
    protected function init():array
    {
        $user = User::factory()->set('is_admin', true)->create();
        $userComum = User::factory()->set('is_admin', false)->create();
        $category = PostCategory::factory()->create();
        $post = Post::factory()->create();

        return compact('category', 'user', 'post', 'userComum');
    }
}
