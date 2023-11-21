<?php

use App\Http\Controllers\Auth\DeleteUserController;
use App\Http\Controllers\Auth\UpdateUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    // ->prefix('/user')
    ->group(function () {
        Route::post('', [UserController::class, 'store']);
        Route::post('/{user}', [UpdateUserController::class, 'store']);
        Route::delete('/{user}', [DeleteUserController::class, 'destroy']);
        Route::get('/me', function () {
            return response(auth()->user());
        });
        Route::get('filter/{user}', [UserController::class, 'show']);
        Route::post('/{user_id}/restore', [UserController::class, 'restore']);
        Route::get('/paginate', [UserController::class, 'index']);
    });


?>
