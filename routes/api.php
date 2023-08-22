<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', function (){
    return response(["success"=>true]);
});

require __DIR__.'/api/index.php';


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    $user = $request->user();
    return $user;
});

