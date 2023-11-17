<?php

namespace App\Services;

use App\DTOs\PostCategory\CreatePostCategoryDTO;
use App\Repositories\PostCategoryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostCategoryService{
    public function __construct(
        protected PostCategoryRepository $repository
    ){}

    public function getPopular(int $limit){
        return $this->repository->getPopular($limit);
    }

    public function paginate(
        int $page = 1,
        int $perPage = 15,
        bool $isTrash = false,
        string|null $search = null,
    )
    {
        return $this->repository->paginate($page, $perPage, $isTrash, $search);
    }

    public function store(CreatePostCategoryDTO $postCategoryDTO)
    {
        $slug = str()->slug($postCategoryDTO->name);

        $alreadyExistSlug = $this->repository->get($slug);

        while($alreadyExistSlug){
            $alreadyExistSlug = $this->repository->get($slug);
            $slug = $slug . rand(1,20);
        }

        $category = $this->repository->create([
            'name' => $postCategoryDTO->name,
            'slug' => $slug,
            'description' => $postCategoryDTO->description,
        ]);

        if(!$category){
            throw new \ErrorException('Unexpected error ocurred');
        }

        return $category;
    }

    public function show($slugOrId)
    {
        $category = $this->repository->get($slugOrId);

        if(!$category){
            throw new NotFoundHttpException("Category not found");
        }

        return $category;
    }


}


?>
