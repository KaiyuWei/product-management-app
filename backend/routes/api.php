<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/', function(\Illuminate\Foundation\Http\FormRequest $request){
    Log::info("In API request!! " . json_encode($request->all()));
    return "Hello world";
});

// todo: protect the following routes using middleware.
Route::middleware('auth:sanctum')->group(function () {

});

