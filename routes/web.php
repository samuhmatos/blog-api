<?php

use App\Events\WeeklyNewsLetter;
use App\Jobs\NotifyNewsLetter;
use App\Mail\PostPostedMail;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\PostServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $token = Hash::make(Str::random(60));

    dd(auth());
    return [
        'Laravel' => app()->version(),
        'token' => $token,
        strlen($token)
    ];
});

Route::get('/send-mail', function(){
    // Mail::raw('Usuário criado com sucesso!', function ($message){
    //     $message->to('test@gmail.com')
    //         ->subject('noreplay');
    // });

    // foreach (["teste@gmail", "samuh@gmail.com"] as $value) {
    //     // Mail::send(new PostPublished($value));
    //      NotifyNewsLetter::dispatch($value);
    // }

    // event(new WeeklyNewsLetter());

    $postService = new PostServices(new PostRepository(new Post));

    return view('emails.post-posted',[
        'posts' => $postService->getLatestBest(6, true),
        'newsletter' => [
            'email' => "samuh@gmail.com",
            "token" => "ajknsfdiousandgojnafdçljoijdsafjnuadn"
        ]
    ]);
});
