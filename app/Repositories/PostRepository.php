<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Contracts\PaginationInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PostRepository{
    public function __construct(
        protected Post $post
    ){}

    public function paginate(
        int $page,
        int $perPage,
        string|null $filter,
        bool $isDraft,
        bool $isTrash,
        string|null $categorySlug,
    ): PaginationInterface
    {
        $result = Post::withTrashed($isTrash)->with(['category', 'author'])
            ->where(function (Builder $query) use ($filter, $isDraft, $isTrash, $categorySlug) {
                if ($filter) {
                    $query->where(function (Builder $subquery) use ($filter) {
                        $subquery->where('title', 'like', "%{$filter}%")
                                 ->orWhere('sub_title', 'like', "%{$filter}%");
                    });
                }

                if($isTrash){
                   $query->whereNotNull("deleted_at");

                }else {
                    $query->where('is_draft', $isDraft);
                }

                if($categorySlug){
                    $query->whereHas('category', function (Builder $query) use ($categorySlug){
                        $query->where('slug', $categorySlug);
                    });
                }
            })
            ->withPostReactionCounts()
            ->orderByDesc('created_at')
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

    public function getOne(string|int $param): Post
    {
        return Post::with(['author', 'category'])
            ->where('is_draft', false)
            ->where('slug', $param)
            ->orWhere('id', $param)
            ->withPostReactionCounts()
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
