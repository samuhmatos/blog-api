<?php

use App\Http\Controllers\PostCommentReactionController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->prefix('/comment')->group(function (){
    Route::post('/{postComment}/reaction', [PostCommentReactionController::class, 'store']);
    Route::get('/{postComment}/reaction', [PostCommentReactionController::class, 'show']);
    Route::delete('/{postComment}/reaction', [PostCommentReactionController::class, 'destroy']);
});

