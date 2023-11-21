<?php

use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostCommentReactionController;
use App\Http\Controllers\PostCommentReportController;
use Illuminate\Support\Facades\Route;

// ->prefix('/comment')
Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('', [PostCommentController::class, 'store']);
    Route::patch('/{postComment}', [PostCommentController::class, 'update']);
    Route::delete('/{postComment}', [PostCommentController::class, 'destroy']);

    Route::post('/{postComment}/report', [PostCommentReportController::class, 'store']);


    // comment reaction
    Route::post('/{postComment}/reaction', [PostCommentReactionController::class, 'store']);
    Route::get('/{postComment}/reaction', [PostCommentReactionController::class, 'show']);
    Route::delete('/{postComment}/reaction', [PostCommentReactionController::class, 'destroy']);
});
