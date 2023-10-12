<?php

use App\Http\Controllers\PostCategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('/postCategory')->group(function (){
    Route::get('', [PostCategoryController::class, 'index']);
    Route::get('/{postCategory:slug}', [PostCategoryController::class, 'show']);
    // Route::get('/paginate/{slug}', [PostCategoryController::class, 'paginatePosts']);
    Route::get('/filter/popular', [PostCategoryController::class, 'getPopular']);

    Route::middleware('auth:sanctum')->group(function (){
        Route::post('', [PostCategoryController::class, 'store']);
        Route::put('/{postCategory}', [PostCategoryController::class, 'update']);
        Route::delete('/{postCategory}', [PostCategoryController::class, 'destroy']);
    });

});

?>
