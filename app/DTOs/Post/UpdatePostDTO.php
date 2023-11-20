<?php

namespace App\DTOs\Post;

use Illuminate\Http\UploadedFile;

class UpdatePostDTO
{
    public function __construct(
        public int $postId,
        public string $title,
        public string $subTitle,
        public string $content,
        public int $categoryId,
        public bool $isDraft,
        public UploadedFile|array|null $banner,
        public string $imageUrl,
        public array $imageContentList,
    ){}
}
