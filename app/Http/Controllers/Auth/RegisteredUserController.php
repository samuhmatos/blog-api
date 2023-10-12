<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
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
        $username = str()->slug($request->name);
        $alreadyExistUsername = User::where('username', $username)->first();

        if($alreadyExistUsername){
            do {
                $existUsername = User::where('username', $username)->first();
                $username = $username . rand(1,300);
            } while ($existUsername);
        }

        $user = User::create([
            'name' => $request->name,
            'username'=> $username,
            'email' => $request->email,
            'image_url'=> null,
            'password' => Hash::make($request->password),
        ]);

        // Contact::create([
        //     'name' => $request->name,
        //     "email" => $request->email,
        // ]);

        event(new Registered($user));

        Auth::login($user);
        $token = $request->user()->createToken('user:register');


        return response(
            [
                'user' => $request->user(),
                'token' => $token->plainTextToken,
            ]
        ,201);
    }
}
//TODO: VERIFICAR EVENTO REGISTERED
