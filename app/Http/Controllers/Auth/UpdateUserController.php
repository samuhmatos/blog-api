<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UpdateUserController extends Controller
{
    public function store(Request $request, User $user)
    {
        $this->authorize('matchUser', $user);

        $request->validate([
            'name' => ['string', "max:100"],
            'username' => ['string', "max:255", "unique:users,username"],
            "image" => ['image', "max:5000"],
            "email"=> ["email", "unique:users,email"],
            "description" => ["string", "max:255"],
            "password" => ['confirmed', Rules\Password::defaults()],
            "is_admin" => [
                "boolean",
                Rule::requiredIf($request->user()->is_admin),
                Rule::excludeIf(!$request->user()->is_admin)
            ]
        ]);

        $payload = $request->only(['name', 'username', 'email', 'description', 'is_admin']);
        $image = $request->file('image');


        if($image){
            if($user->image_url) {
                Storage::delete($user->image_url);
            }

            $payload['image_url'] = $image->store('/uploads/users');
        }

        $user->update($payload);
        $user->fresh();

        if(auth()->user()->id == $user->id){
            if($request->email && $request->email != $user->email){
                $user->tokens()->delete();
                $token = $user->createToken('user_auth')->plainTextToken;
            }
        }


        return response([
            'user' => $user,
            'token' => isset($token) ? $token : null
        ]);
    }
}
