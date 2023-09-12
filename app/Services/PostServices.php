<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Collection;
class PostServices{
    public function __construct(
        protected PostRepository $postRepository
    ){}

    public function paginateFeed(int $page = 1, int $perPage = 15, string|null $search = null)
    {
        return $this->postRepository->paginateFeed(page:$page, perPage: $perPage, filter: $search);
    }

    public function getPopular(int $limit = 3):Collection
    {
        return $this->postRepository->getMostViewed($limit);
    }

    public function getLatestBest(): Collection
    {
        return $this->postRepository->getLatestBest();
    }

    public function getPostBySlug(string $slug): Post
    {
        return $this->postRepository->getPostBySlug($slug);
    }

    public function getByCategory(string $categorySlug, int $limit = 3): Collection | Post
    {
        return $this->postRepository->getByCategory($categorySlug, $limit);
    }
}

?>
