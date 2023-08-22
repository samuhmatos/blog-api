<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Response;

class PostCommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function matchPost(User $user, PostComment $postComment, Post $post)
    {
        return $post->id === $postComment->post_id
        ? Response::allow()
        : Response::deny("The post and comment informed does not match", 400);
    }

    public function matchUser(User $user, PostComment $postComment)
    {
        return $user->id === $postComment->user_id;
    }
}
