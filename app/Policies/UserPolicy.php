<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function matchUser(User $userLogged, User $userRequest)
    {
        return $userLogged->is_admin || $userLogged->id === $userRequest->id;
    }
}
