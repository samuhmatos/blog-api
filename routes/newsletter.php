<?php

use App\Http\Controllers\NewsLetterController;
use Illuminate\Support\Facades\Route;


Route::post('', [NewsLetterController::class, 'subscribe']);
Route::delete('/{newsletter:email}', [NewsLetterController::class, 'unsubscribe']);


?>
