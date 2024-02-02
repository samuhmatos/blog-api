<?php

namespace App\Policies;

use App\Models\PostComment;
use App\Models\User;

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
