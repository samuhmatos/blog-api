<?php

namespace App\DTOs\PostComments;

class UpdatePostCommentDTO {
    public function __construct(
        public int $id,
        public string $comment
    ) {}
}
