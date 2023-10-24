<?php

use App\Events\WeeklyNewsLetter;
use App\Jobs\NotifyNewsLetter;
use App\Mail\PostPostedMail;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\PostServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function (Request $request) {
    return [
        'Laravel' => app()->version(),
        'sessions' => Auth::user()
    ];
});

