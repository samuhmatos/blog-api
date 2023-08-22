<?php
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/template', TemplateController::class)->middleware('auth:sanctum');

?>
