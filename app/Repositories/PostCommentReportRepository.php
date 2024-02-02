<?php

namespace App\Repositories;

use App\Models\PostCommentReport;
use App\Repositories\Contracts\PaginationInterface;
use Illuminate\Database\Eloquent\Builder;

class PostCommentReportRepository extends Repository {
    protected $model = PostCommentReport::class;

    public function paginate(
        int $page,
        int $perPage,
    ):PaginationInterface
    {
        $result = $this->model()
            ->query()
            ->where(function (Builder $builder){

            })
            ->paginate();

        return $result;
    }
}
