<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function (){
    return response(["success"=>true]);
});

require __DIR__.'/api/index.php';

Route::get('/test', function(Request $request) {
    return [Auth::user(), Auth::check(), Auth::id(), Auth::user()->id];
})->middleware('guard');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    return response($user);
});


