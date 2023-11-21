<?php

namespace Tests\Feature\PostComment;


use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Tests\TestCase;

class TestBase extends TestCase
{
    public function init():array
    {
        $userAdmin  = User::factory()->set('is_admin', true)->create();
        $user = User::factory()->create();
        PostCategory::factory()->create();
        $post = Post::factory()->create();

        return compact('user', 'post', 'userAdmin');
    }
}
