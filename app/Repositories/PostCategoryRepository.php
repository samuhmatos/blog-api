<?php
namespace App\Repositories;

use App\Models\Post;
use App\Models\PostCategory;
use App\Repositories\Contracts\PaginationInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostCategoryRepository
{
    public function paginatePostsByCategory(string $categorySlug, int $page = 1, int $perPage = 15): PaginationInterface
    {
        $result = Post::with(['category', 'author'])
            ->withPostReactionCounts()
            ->whereHas('category', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            })
            ->paginate($perPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
    }

    public function getPopular(){
        return PostCategory::postsCount()->orderByDesc('posts_count')->get();
    }
}

?>
