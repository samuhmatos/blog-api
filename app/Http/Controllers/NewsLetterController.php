<?php

namespace App\Http\Controllers;

use App\DTOs\Newsletter\CreateNewsletterDTO;
use App\DTOs\Newsletter\DestroyNewsletterDTO;
use App\Models\Newsletter;
use App\Services\NewsletterService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsLetterController extends Controller
{
    public function __construct(
        protected NewsletterService $service
    ){}
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:newsletters'],
        ]);

        $this->service->subscribe(new CreateNewsletterDTO($request->email));
        return response()->noContent();
    }

    public function unsubscribe(Request $request, Newsletter $newsletter)
    {
        $token = $request->query('token', null);

        $this->service->unsubscribe(new DestroyNewsletterDTO($newsletter, $token));

        return response()->noContent();
    }
}
