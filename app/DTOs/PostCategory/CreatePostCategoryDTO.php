<?php

namespace App\DTOs\PostCategory;

class CreatePostCategoryDTO
{
    public function __construct(
        public string $name,
        public string $description,
    ){}
}
