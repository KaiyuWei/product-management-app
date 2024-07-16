<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\EnsureUserIsCustomer;
use App\Http\Middleware\EnsureUserIsSupplier;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware(EnsureUserIsSupplier::class)->group(function () {
        Route::get('/products', [ProductController::class, 'indexProductsOfCurrentSupplierUser']);
        Route::post('/product', [ProductController::class, 'create']);
    });

    Route::middleware(EnsureUserIsCustomer::class)->group(function(){
        Route::get('/product/index', [ProductController::class, 'index']);
    });
});

