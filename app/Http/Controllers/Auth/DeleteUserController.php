<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DeleteUserController extends Controller
{
    public function destroy(Request $request, User $user)
    {
        $this->authorize("matchUser", $user);

        $user->delete();
        $user->tokens()->delete();
        return response()->noContent();
    }
}
