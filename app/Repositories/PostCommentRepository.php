<?php

namespace App\Repositories;

use App\Enums\ReportsType;
use App\Models\PostComment;
use App\Repositories\Contracts\PaginationInterface;
use Illuminate\Database\Eloquent\Builder;

class PostCommentRepository extends Repository {
    protected $model = PostComment::class;

    public function paginateWithReports(
        int $page,
        int $perPage,
        ?ReportsType $reportsType
    ): PaginationInterface
    {
        $result = $this->model()
            ->query()
            ->whereHas('reports',function (Builder $query) use ($reportsType){
                if($reportsType){
                   $query->where('status', $reportsType);
                }
            })
            ->with(['reports', 'user'])
            ->paginate($perPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
    }
}
