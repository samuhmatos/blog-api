<?php

use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostCommentReactionController;
use App\Http\Controllers\PostCommentReportController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostReactionController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->prefix('/comment')->group(function (){
    Route::post('/{postComment}/reaction', [PostCommentReactionController::class, 'store']);
    Route::delete('/{postComment}/reaction', [PostCommentReactionController::class, 'destroy']);
});

