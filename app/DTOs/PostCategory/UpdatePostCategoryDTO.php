<?php

namespace App\DTOs\PostCategory;

class UpdatePostCategoryDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public string $slug,
    ){}
}
