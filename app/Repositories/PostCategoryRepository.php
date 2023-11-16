<?php
namespace App\Repositories;

use App\Models\Post;
use App\Models\PostCategory;
use App\Repositories\Contracts\PaginationInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostCategoryRepository
{
    // public function paginatePostsByCategory(string $categorySlug, int $page = 1, int $perPage = 15): PaginationInterface
    // {
    //     $result = Post::with(['category', 'author'])
    //         ->whereHas('category', function (Builder $query) use ($categorySlug) {
    //             $query->where('slug', $categorySlug);
    //         })
    //         ->where(function (Builder $query){
    //             $query->where('is_draft', false);
    //         })
    //         ->withPostReactionCounts()
    //         ->paginate($perPage, ['*'], 'page', $page);

    //     return new PaginationPresenter($result);
    // }

    public function paginate(
        int $page,
        int $perPage,
        bool $isTrash,
        string|null $search,
    ): PaginationInterface
    {
        $result = PostCategory::withTrashed($isTrash)
            ->postsCount()
            ->where(function (Builder $query) use ($search, $isTrash){
                if($search){
                    $query->where('slug', $search);
                    $query->where('name', $search);
                }

                if($isTrash){
                    $query->whereNotNull("deleted_at");
                }
            })
            ->orderByDesc('posts_count')
            ->orderByDesc('created_at')
            ->paginate($perPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
    }
    public function getPopular(int $limit){
        return PostCategory::postsCount()
            ->orderByDesc('posts_count')
            ->limit($limit)
            ->get();
    }
}

?>
