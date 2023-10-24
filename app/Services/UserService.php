<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\PaginationInterface;
use App\Repositories\UserRepository;

class UserService {
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function paginate(
        int $page = 1,
        int $perPage = 10,
        string|null $search = null,
        bool $isTrash = false
    ): PaginationInterface
    {
        return $this->userRepository->paginate($page, $perPage, $search, $isTrash);
    }

    public function createUsername(string $name): string
    {
        $username = str()->slug($name);
        $alreadyExistUsername = $this->userRepository
                                    ->findOneByUsername($username);

        if($alreadyExistUsername){
            do {
                $existUsername = $this->userRepository
                                    ->findOneByUsername($username);
                $username = $username . rand(1,300);
            } while ($existUsername);

            return $existUsername;
        }

        return $username;
    }

    public function create(
        string $name,
        string $username,
        string $email,
        string $password,
        bool $isAdmin = false
    ): User
    {
        return $this->userRepository->create(
            $name,
            $username,
            $email,
            $password,
            $isAdmin,
        );
    }
}

?>
