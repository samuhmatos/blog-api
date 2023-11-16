<?php

namespace App\DTOs\PostComments;

class DestroyPostCommentDTO {
    public function __construct(
        public int $id,
    ) {}
}
