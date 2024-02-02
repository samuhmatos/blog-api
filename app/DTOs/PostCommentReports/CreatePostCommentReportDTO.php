<?php

namespace App\DTOs\PostCommentReports;

class CreatePostCommentReportDTO {
    public function __construct(
        public int $commentId,
        public string $message
    ) {}
}
