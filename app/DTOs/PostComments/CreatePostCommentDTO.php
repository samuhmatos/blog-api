<?php

namespace App\DTOs\PostComments;

class CreatePostCommentDTO {
    public function __construct(
        public int $user_id,
        public int $post_id,
        public int|null $parent_id,
        public string $comment
    )
    {}
}
