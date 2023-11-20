<?php

namespace App\DTOs\Post;

use Illuminate\Http\UploadedFile;

class CreatePostDTO
{
    public function __construct(
        public string $title,
        public string $subTitle,
        public string $content,
        public int $categoryId,
        public bool $isDraft,
        public UploadedFile|array|null $banner,
        public array $imageContentList,
    ){}
}
