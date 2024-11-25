<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentMethodController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('products')->group(function () {
    Route::post('/add-product-to-cart', [CartController::class, 'addProductToCart']);
    Route::post('/delete-product-from-cart', [CartController::class, 'deleteProductFromCart']);
    Route::get('/{id}', [CartController::class, 'getProduct']);
    Route::get('/', [CartController::class, 'getProducts']);
});

Route::prefix('orders')->group(function () {
    Route::post('/pay', [PaymentMethodController::class, 'pay']);
});
