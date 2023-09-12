<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['string', 'max:20'],
            'subject' => ['required', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:255'],
        ]);

        $payload = $request->only('email', 'name', 'phone', 'subject', 'message');

        Contact::create($payload);

        return response()->noContent();
    }
}
