<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UpdateUserController extends Controller
{
    public function store(Request $request, User $user)
    {
        $this->authorize('matchUser', $user);

        $request->validate([
            'name' => ['string', "max:100"],
            'username' => ['string', "max:255", "unique:users,username"],
            "image" => ['image', "max:5"],
            "email"=> ["email", "unique:users,id"]
        ]);
        $payload = $request->only(['name', 'username', 'email']);
        $image = $request->file('image');

        if($image){
            Storage::delete($user->image_url);
            $payload['image_url'] = $image->store('/uploads/users/');
        }

        $contact = Contact::query()->where("email", $user->email)->first();

        $user->update($payload);
        $user->fresh();

        $contact->update([
            'name' => $user->name,
            "email" => $user->email,
        ]);

        if($request->email)
            $token = $user->createToken('user_auth')->plainTextToken;

        return response([
            'user' => $user,
            'token' => isset($token) && $token
        ]);
    }
}
