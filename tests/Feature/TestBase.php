<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostComment;
use App\Models\PostCommentReaction;
use App\Models\PostCommentReport;
use App\Models\PostReaction;
use App\Models\User;
use Tests\TestCase;

class TestBase extends TestCase {
    public User $adminUser;
    public User $normalUser;
    public PostCategory $postCategory;
    public Post $post;

    public PostReaction $postReaction;
    public PostComment $postComment;
    public PostCommentReport $postCommentReport;

    public PostCommentReaction $postCommentReaction;

    public function setUp(): void {
        parent::setUp();

        $this->init();
    }

    private function init():void
    {
        $this->adminUser = User::factory()
            ->set('is_admin', true)
            ->create();
        $this->normalUser = User::factory()
            ->set('is_admin', false)
            ->create();
        $this->postCategory = PostCategory::factory()->create();
        $this->post = Post::factory()->create();
        $this->postReaction = PostReaction::factory()
            ->set('user_id', $this->adminUser->id)
            ->set('post_id', $this->post->id)
            ->create();
        $this->postComment = PostComment::factory()->create();
        $this->postCommentReport = PostCommentReport::factory()
            ->create();
        // $this->postCommentReaction = PostCommentReaction::factory()
        //     ->set('user_id', $this->adminUser->id)
        //     ->set('comment_id', $this->postComment->id)
        //     ->create();
    }
}
