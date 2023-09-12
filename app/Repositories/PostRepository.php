<?php

namespace App\Repositories;

use App\Enums\CategorySlug;
use App\Models\Post;
use App\Repositories\Contracts\PaginationInterface;
use Illuminate\Database\Eloquent\Collection;

class PostRepository{
    public function __construct(
        protected Post $post
    ){}

    public function paginateFeed(int $page = 1, int $perPage = 15, string $filter = null): PaginationInterface
    {
        $result = Post::with(['category', 'author'])
            ->withPostReactionCounts()
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('title', 'like', "%{$filter}%");
                    $query->orWhere('sub_title', 'like', "%{$filter}%");
                }
            })
            ->paginate($perPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
    }

    public function getMostViewed(int $limit = 3): Collection
    {
        return Post::with(['category', 'author'])
            ->withPostReactionCounts()
            ->orderBy('views','desc')
            ->take($limit)
            ->get();
    }

    public function getLatestBest(): Collection
    {
        return Post::with(['category', 'author'])
            ->withPostReactionCounts()
            ->orderByDesc('like_count')
            ->orderBy('views', 'desc')
            ->limit(3)
            ->get();
    }

    public function getByCategory(string $categorySlug, int $limit): Collection | Post
    {
        return Post::with(['category', 'author'])
            ->withPostReactionCounts()
            ->join('post_categories', 'post_categories.id', '=', 'posts.category_id')
            ->where('post_categories.slug', $categorySlug)
            ->orderByDesc('views')
            ->take($limit)
            ->get();
    }

    public function getPostBySlug(string $slug): Post
    {
        return Post::with(['author', 'category'])
            ->withPostReactionCounts()
            ->where('slug', $slug)
            ->firstOrFail()
            ->load(['comments' => function ($query) {
                $query
                    ->whereNull('parent_id')
                    ->with('user')
                    ->orderByDesc('updated_at')
                    ->orderByDesc('id')
                    ->withReactionCounts();
            }, 'comments.answers' => function ($query) {
                $query
                    ->with('user')
                    ->withReactionCounts();
            }]);
    }

}
