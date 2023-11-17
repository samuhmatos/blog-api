<?php

namespace App\DTOs\PostCommentReaction;

use App\Enums\ReactionType;

class CreatePostCommentReactionDTO{
    public function __construct(
        public int $commentId,
        public ReactionType $reactionType,
    ){}
}
