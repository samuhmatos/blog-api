<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsLetterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:newsletters'],
        ]);

        $payload = $request->only('email');

        $newsLetter = Newsletter::updateOrCreate([
            'email' => $payload['email'],
        ], [
            'token' => Hash::make(Str::random(60)),
        ]);

        return response($newsLetter, 201);
    }

    public function unsubscribe(Request $request, Newsletter $newsletter)
    {
        $token = $request->query('token', null);

        if(!$token || $newsletter->token != $token) {
            throw new NotFoundHttpException("Token not found");
            return;
        }

        $newsletter->delete();

        return response()->noContent();

    }
}
