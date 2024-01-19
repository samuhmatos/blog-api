<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Contact;
use App\Models\Newsletter;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    public function __construct(
        Protected UserService $userService
    ){}

    public function index(RegisterRequest $request){
        return response($request->isJson());
    }
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): Response
    {
        $username = $this->userService->createUsername($request->name);

        $user = $this->userService->create(
            name: $request->name,
            username: $username,
            email: $request->email,
            password: $request->password,
            isAdmin: false
        );

        Newsletter::updateOrCreate([
            'email' => $request->email,
        ], [
            'token' => Hash::make(Str::random(60)),
        ]);

        event(new Registered($user));


        return response(
            [
                'user' => $user,
            ]
        ,201);
    }
}
//TODO: VERIFICAR EVENTO REGISTERED
//todo: esqueceu a senha, verificar senha, nova senha
