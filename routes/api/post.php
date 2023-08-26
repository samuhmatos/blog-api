<?php

use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostCommentReactionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostReactionController;
use Illuminate\Support\Facades\Route;



Route::prefix('/post')->group(function(){
    Route::get('', [PostController::class, 'index']);
    Route::get('/feed', [PostController::class, 'feed']);

    Route::get('/{category:slug}/{post}',[PostController::class, 'show']);

    Route::post('/{post}/view',[PostController::class, 'storeView']);
});

Route::middleware(['auth:sanctum'])->group(function (){
    Route::put('/post/{post}',[PostController::class, 'update']);
    Route::post('/post',[PostController::class, 'store']);
    Route::delete('/post/{post}', [PostController::class, 'destroy']);



    Route::post('/post/{post}/reaction',[PostReactionController::class, 'store']);
    Route::delete('/post/{post}/reaction',[PostReactionController::class, 'destroy']);

    Route::post('/post/{post}/comment', [PostCommentController::class, 'store']);
    Route::patch('/post/{post}/comment/{postComment}', [PostCommentController::class, 'update']);
    Route::delete('/post/{post}/comment/{postComment}', [PostCommentController::class, 'destroy']);

    Route::post('/comment/{postComment}/reaction', [PostCommentReactionController::class, 'store']);
    Route::delete('/comment/{postComment}/reaction', [PostCommentReactionController::class, 'destroy']);
});


