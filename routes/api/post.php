<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PostReactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('/post')->group(function(){
    Route::get('', [PostController::class, 'index']);
    Route::get('/paginate', [PostController::class, 'paginateFeed']);
    Route::get('/suggestion', [PostController::class, 'suggestion']);

    Route::get('filter/{slug}',[PostController::class, 'show'])->middleware('guard');

    Route::post('/{post}/view',[PostController::class, 'storeView']);
});


Route::middleware(['auth:sanctum'])->prefix('/post')->group(function (){
    Route::put('/{post}',[PostController::class, 'update']);
    Route::post('/{post}/restore',[PostController::class, 'restore']);
    Route::post('',[PostController::class, 'store']);
    Route::delete('/{post}', [PostController::class, 'destroy']);
    Route::post('/upload-content', [PostController::class, 'uploadSourceContent']);
    Route::get('/draft', [PostController::class, 'paginateDrafts']);
    Route::get('/trash', [PostController::class, 'paginateTrash']);

    Route::get('/{post}/reaction', [PostReactionController::class, 'show']);
    Route::post('/{post}/reaction',[PostReactionController::class, 'store']);
    Route::delete('/{post}/reaction',[PostReactionController::class, 'destroy']);

});
