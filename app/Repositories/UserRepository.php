<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends Repository {

    protected $model = User::class;

    public function paginate(
        int $page,
        int $perPage,
        string|null $search,
        bool $isTrash
    )
    {
        $result = User::withTrashed($isTrash)
            ->with('newsletter')
            ->where(function (Builder $query) use ($search, $isTrash){
                if($search){
                    $query->where('name', $search);
                    $query->where('username', $search);
                    $query->where('email', $search);
                }

                if($isTrash){
                    $query->whereNotNull('deleted_at');
                }
            })
            ->orderByDesc('created_at')
            ->paginate($perPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
    }

    public function findOneByUsername($username): User|null
    {
        return User::where('username', $username)->first();
    }
}

?>
