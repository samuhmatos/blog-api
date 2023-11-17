<?php
namespace App\Repositories;

use App\Models\PostCategory;
use App\Repositories\Contracts\PaginationInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PostCategoryRepository extends Repository
{
    protected $model = PostCategory::class;
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

    public function getPopular(int $limit): Collection
    {
        return PostCategory::postsCount()
            ->orderByDesc('posts_count')
            ->limit($limit)
            ->get();
    }

    public function get(string|int $slugOrId): PostCategory|null
    {
        return $this->model()
            ->query()
            ->where('slug', $slugOrId)
            ->orWhere('id', $slugOrId)
            ->first();
    }
}

?>
