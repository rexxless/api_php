<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

# -- Auth --
Route::post('signup', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);

    # -- Cart --
    Route::post('/cart/{id}', [CartController::class, 'store'])->where('id', '[0-9]+');
    Route::get('/cart', [CartController::class, 'show']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->where('id', '[0-9]+');

    # -- Orders --
    Route::post('/order', [OrderController::class, 'create_order']);
    Route::get('/order', [OrderController::class, 'index']);

    # -- Admin only --
    Route::post('/product', [ProductController::class,'store']);
    Route::delete('/product/{id}', [ProductController::class,'destroy'])->where('id', '[0-9]+');
    Route::patch('/product/{id}', [ProductController::class,'update'])->where('id', '[0-9]+');

});

# -- Products --
Route::get('/products', [ProductController::class,'index']);




Route::fallback(function () {
    return response()->json([
        'message' => 'Not found',
    ], 404);
});
