<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\PaginationInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository {

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

    public function create(
        string $name,
        string $username,
        string $email,
        string $password,
        bool $isAdmin
    ): User
    {
        $user = User::create([
            'name' => $name,
            'username'=> $username,
            'email' => $email,
            'image_url'=> null,
            'password' => Hash::make($password),
            'is_admin' => $isAdmin
        ]);

        return $user;
    }

    public function findOneByUsername($username): User|null
    {
        return User::where('username', $username)->first();
    }
}

?>
