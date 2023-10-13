<?php

use App\Http\Controllers\NewsLetterController;
use Illuminate\Support\Facades\Route;


Route::post('/newsletter/subscribe', [NewsLetterController::class, 'subscribe']);
Route::delete('/newsletter/unsubscribe/{newsletter:email}', [NewsLetterController::class, 'unsubscribe']);


?>
