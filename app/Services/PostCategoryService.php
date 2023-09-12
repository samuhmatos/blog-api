<?php

namespace App\Services;

use App\Repositories\PostCategoryRepository;

class PostCategoryService{
    public function __construct(protected PostCategoryRepository $postCategoryRepository)
    {}

    public function getPopular(){
        return $this->postCategoryRepository->getPopular();
    }

    public function paginatePostsByCategory(string $categorySlug, int $page = 1, int $perPage = 15)
    {
        return $this->postCategoryRepository->paginatePostsByCategory(categorySlug: $categorySlug, page:$page, perPage: $perPage);
    }
}


?>
