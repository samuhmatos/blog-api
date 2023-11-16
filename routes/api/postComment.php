<?php

use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostCommentReportController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->prefix('/comment')->group(function (){
    Route::post('', [PostCommentController::class, 'store']);
    Route::patch('/{postComment}', [PostCommentController::class, 'update']);
    Route::delete('/{postComment}', [PostCommentController::class, 'destroy']);

    Route::post('/{postComment}/report', [PostCommentReportController::class, 'store']);
});
