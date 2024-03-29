<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Contracts\PaginationInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PostRepository extends Repository{
    protected $model = Post::class;
    public function __construct(
        protected Post $post
    ){}

    public function paginate(
        int $page,
        int $perPage,
        string|null $search,
        bool $isDraft,
        bool $isTrash,
        string|null $categorySlug,
    ): PaginationInterface
    {
        $result = $this->model()
            ->query()
            ->withTrashed($isTrash)->with(['category', 'author'])
            ->where(function (Builder $query) use ($search, $isDraft, $isTrash, $categorySlug) {
                if ($search) {
                    $query->where(function (Builder $subquery) use ($search) {
                        $subquery->where('title', 'like', "%{$search}%")
                                 ->orWhere('sub_title', 'like', "%{$search}%");
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
        return $this->model()
            ->query()
            ->with(['category', 'author'])
            ->withPostReactionCounts()
            ->orderBy('views','desc')
            ->take($limit)
            ->get();
    }

    public function getLatestBest(int $limit, bool $filterWeek = false): Collection
    {
        return $this->model()
            ->query()
            ->with(['category', 'author'])
            ->withPostReactionCounts()
            ->where(function (Builder $query) use ($filterWeek){
                if($filterWeek){
                    $startDate = Carbon::now()->startOfWeek();
                    $endDate = Carbon::now()->endOfWeek();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            })
            ->orderByDesc('like_count')
            ->orderBy('views', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getByCategory(string $categorySlug, int $limit): Collection | Post
    {
        return $this->model()
            ->query()
            ->with(['category', 'author'])
            ->withPostReactionCounts()
            ->where(function (Builder $query) use ($categorySlug){
                $query->whereHas('category', function (Builder $subQuery) use ($categorySlug){
                    $subQuery->where('slug', $categorySlug);
                });
            })
            ->orderByDesc('views')
            ->take($limit)
            ->get();
    }

    public function getOne(string|int $param): Post
    {
        return $this->model()
            ->query()
            ->with(['author', 'category'])
            ->where('is_draft', false)
            ->where('slug', $param)
            ->orWhere('id', $param)
            ->withPostReactionCounts()
            ->withUserReaction()
            ->firstOrFail()
            ->load(['comments' => function ($query) {
                $query
                    ->whereNull('parent_id')
                    ->orderByDesc('updated_at')
                    ->orderByDesc('id')
                    ->withCommentToPublic();
            }, 'comments.answers' => function ($query) {
                $query->withCommentToPublic();
            }]);
    }


}
