<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Collection;
class PostServices{
    public function __construct(
        protected PostRepository $postRepository
    ){}

    public function paginate(
        int $page = 1,
        int $perPage = 15,
        string|null $search = null,
        bool $isDraft = false,
        bool $isTrash = false,
        string|null $categorySlug = null,
    )
    {
        return $this->postRepository->paginate(
            page:$page,
            perPage: $perPage,
            filter: $search,
            isDraft: $isDraft,
            isTrash: $isTrash,
            categorySlug: $categorySlug
        );
    }

    public function getPopular(int $limit = 3):Collection
    {
        return $this->postRepository->getMostViewed($limit);
    }

    public function getLatestBest(): Collection
    {
        return $this->postRepository->getLatestBest();
    }

    public function getOne(string|int $param): Post
    {
        return $this->postRepository->getOne($param);
    }

    public function getByCategory(string $categorySlug, int $limit = 3): Collection | Post
    {
        return $this->postRepository->getByCategory($categorySlug, $limit);
    }
}

?>
