<?php

namespace Tests\Feature\PostCommentReaction;

use Tests\TestCase;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostComment;
use App\Models\PostCommentReaction;
use App\Models\User;

class TestBase  extends TestCase
{
    public function init(bool $createReaction = true):array
    {
        $userAdmin = User::factory()->set('is_admin', true)->create();
        $userComum = User::factory()->create();
        PostCategory::factory()->create();
        $post = Post::factory()->create();
        $comment = PostComment::factory()->create();

        if($createReaction){
            PostCommentReaction::factory()
                ->set('comment_id', $comment->id)
                ->set('user_id', $userComum->id)
                ->create();
        }

        return compact('userAdmin', 'userComum', 'post', 'comment');
    }
}