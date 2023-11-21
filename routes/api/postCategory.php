<?php

use App\Http\Controllers\PostCategoryController;
use Illuminate\Support\Facades\Route;

// Route::prefix('/category')->group(function (){
    Route::get('', [PostCategoryController::class, 'paginate']);
    Route::get('/all', [PostCategoryController::class, 'index']);
    Route::get('/get/{slugOrId}', [PostCategoryController::class, 'show']);
    Route::get('/filter/popular', [PostCategoryController::class, 'getPopular']);

    Route::middleware('auth:sanctum')->group(function (){
        Route::post('', [PostCategoryController::class, 'store']);
        Route::put('/{postCategory}', [PostCategoryController::class, 'update']);
        Route::delete('/{postCategory}', [PostCategoryController::class, 'destroy']);
    });

// });

?>
