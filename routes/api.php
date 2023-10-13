<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function (){
    return response(["success"=>true]);
});

require __DIR__.'/api/index.php';

Route::get('/test', function() {
    dd(csrf_token());
    return "oi ".csrf_token();
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    return response($user);
});


//todo: adicionar evento para quando tiver post novo para newsletter
