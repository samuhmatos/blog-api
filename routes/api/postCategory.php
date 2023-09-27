<?php

use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/template', TemplateController::class)->middleware('auth:sanctum');

Route::prefix('/category')->group(function (){
    Route::get('', [PostCategoryController::class, 'index']);
    Route::get('/{postCategory:slug}', [PostCategoryController::class, 'show']);
    Route::get('/paginate/{slug}', [PostCategoryController::class, 'paginatePosts']);
    Route::get('/filter/popular', [PostCategoryController::class, 'getPopular']);
});

?>
