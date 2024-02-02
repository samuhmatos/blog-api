<?php

use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostCommentReactionController;
use App\Http\Controllers\PostCommentReportController;
use Illuminate\Support\Facades\Route;

// /api/comment

Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('', [PostCommentController::class, 'store']);

    Route::patch('/{postComment}', [PostCommentController::class, 'update']);
    Route::delete('/{postComment}', [PostCommentController::class, 'destroy']);

    // comment report
    Route::get('/report', [PostCommentController::class, 'index']);
    Route::post('/report', [PostCommentReportController::class, 'store']);
    Route::put('/report/{id}', [PostCommentReportController::class, 'update']);
    Route::get('/report/{id}', [PostCommentReportController::class, 'show']);


    // comment reaction
    Route::post('/{postComment}/reaction', [PostCommentReactionController::class, 'store']);
    Route::get('/{postComment}/reaction', [PostCommentReactionController::class, 'show']);
    Route::delete('/{postComment}/reaction', [PostCommentReactionController::class, 'destroy']);
});
