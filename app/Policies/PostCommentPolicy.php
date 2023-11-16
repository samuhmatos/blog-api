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

    public function owner(User $user, PostComment $postComment)
    {
        if($user->id === $postComment->user_id){
            return true;
        }

        return false;
    }
}
