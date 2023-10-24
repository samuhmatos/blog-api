<?php

namespace App\Http\Controllers;

use App\Adapters\PaginationAdapter;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        Protected UserService $userService
    ){}

    public function index(Request $request)
    {
        $this->authorize('is_admin');

        $page =  $request->query('page', 1);
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search', null);
        $isTrash = $request->query('is_trash', false);

        return response(
            PaginationAdapter::toJson(
                $this->userService->paginate(
                    page:$page,
                    perPage: $perPage,
                    search: $search,
                    isTrash: $isTrash === 'true' ? true : false,
                )
            )
        );
    }

    public function restore(string $userId)
    {
        $user = User::withTrashed()->findOrFail($userId);
        $this->authorize('matchUser', $user);

        $user->restore();

        return response($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
       $username = $this->userService->createUsername($request->name);

        $user = $this->userService->create(
            name: $request->name,
            username: $username,
            email: $request->email,
            password: $request->password,
            isAdmin: $request->is_admin
                ? $request->is_admin
                : false,
        );

        return response($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('matchUser', $user);

        return response($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
