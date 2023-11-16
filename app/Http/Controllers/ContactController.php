<?php

namespace App\Http\Controllers;

use App\DTOs\ContactDTO;
use App\Http\Requests\ContactRequest;
use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(
        protected ContactService $service
    ){}
    public function store(ContactRequest $request)
    {
        try{
            $this->service->store(new ContactDTO(
                email: $request->validated('email'),
                name: $request->validated('name'),
                phone: $request->validated('phone'),
                subject: $request->validated('subject'),
                message: $request->validated('message'),
            ));

            return response()->noContent();
        }catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
