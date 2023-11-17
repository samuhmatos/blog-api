<?php

namespace App\Repositories;

use App\Enums\ReactionType;
use App\Models\PostCommentReaction;

class PostCommentReactionRepository extends Repository
{
    protected $model = PostCommentReaction::class;

    public function count(int $commentId, ReactionType $reactionType): int
    {
        return $this->model()
            ->query()
            ->withReactionCount($commentId, $reactionType);
    }

    public function show(int $commentId, int $userId)
    {
        return $this->model()
            ->query()
            ->where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->firstOrFail();
    }
}
