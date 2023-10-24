<?php

use App\Http\Controllers\NewsLetterController;
use Illuminate\Support\Facades\Route;


Route::post('/newsletter', [NewsLetterController::class, 'subscribe']);
Route::delete('/newsletter/{newsletter:email}', [NewsLetterController::class, 'unsubscribe']);


?>
