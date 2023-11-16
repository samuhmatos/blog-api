<?php

namespace App\Services;

use App\Repositories\PostCategoryRepository;

class PostCategoryService{
    public function __construct(protected PostCategoryRepository $postCategoryRepository)
    {}

    public function getPopular(int $limit = 5){
        return $this->postCategoryRepository->getPopular($limit);
    }

    public function paginate(
        int $page = 1,
        int $perPage = 15,
        bool $isTrash = false,
        string|null $search = null,
    )
    {
        return $this->postCategoryRepository->paginate($page, $perPage, $isTrash, $search);
    }
}


?>
