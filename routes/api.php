<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', function (){
    return response(["success"=>true]);
});

Route::prefix('/auth')->group(base_path('routes/api/auth.php'));
Route::prefix('/contact')->group(base_path('routes/api/contact.php'));
Route::prefix('/newsletter')->group(base_path('routes/api/newsletter.php'));
Route::prefix('/post')->group(base_path('routes/api/post.php'));
Route::prefix('/category')->group(base_path('routes/api/postCategory.php'));
Route::prefix('/comment')->group(base_path('routes/api/postComment.php'));
Route::prefix('/user')->group(base_path('routes/api/user.php'));


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    return response($user);
});


