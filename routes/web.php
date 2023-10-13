<?php

use App\Models\Post;
use Illuminate\Support\Facades\Hash;
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

// Route::get('/storage/uploads/posts/banners/{filename}', function ($filename) {
//     $path = storage_path("app/public/uploads/posts/banners/{$filename}");

//     if (!Storage::exists("public/uploads/posts/banners/{$filename}")) {
//         abort(404);
//     }

//     $file = Storage::get("public/uploads/posts/banners/{$filename}");
//     $type = Storage::mimeType("public/uploads/posts/banners/{$filename}");

//     return response()->make($file, 200, ['Content-Type' => $type]);
// });
