<?php

namespace App\Policies;

use App\Models\PostCommentReaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostCommentReactionPolicy
{
    public function __construct()
    {

    }

    public function matchUser(User $user, PostCommentReaction $postCommentReaction):bool
    {
        return $user->id === $postCommentReaction->user->id;
    }
}
