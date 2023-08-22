<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        // if(Auth::attempt($request->only('email', 'password'))){
        //     return response([
        //         "Authorized"=> true,
        //         'token' => $request->user()->createToken('invoice')->plainTextToken
        //     ], 200);
        // }
        // // 3|TgsMDX4jGhLamrYiXrciwXw2mutyP4mYVYz6At5T

        // return response("nao autorizado", 403);


        $request->authenticate();

        //$request->session()->regenerate();

        return response([
                "Authorized"=> true,
                'token' => $request->user()->createToken('invoice')->plainTextToken
            ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
