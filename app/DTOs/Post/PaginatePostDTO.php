<?php

namespace  App\DTOs\Post;

class PaginatePostDTO
{
    public function __construct(
        public int $page,
        public int $perPage,
        public string|null $search,
        public bool $isDraft,
        public bool $isTrash,
        public string|null $categorySlug
    ){}
}
