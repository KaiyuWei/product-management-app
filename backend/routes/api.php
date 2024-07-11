<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// todo: protect the following routes using middleware.
Route::middleware('auth:sanctum')->group(function () {

});

