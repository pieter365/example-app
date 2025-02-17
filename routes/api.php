<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\OrderController;
use App\Models\User;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Version 1
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // Product routes
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']); // List all products
        Route::get('/{id}', [ProductController::class, 'show']); // Show a specific product
        Route::post('/', [ProductController::class, 'store']); // Create a new product
        Route::put('/{id}', [ProductController::class, 'update']); // Update a product
        Route::delete('/{id}', [ProductController::class, 'destroy']); // Delete a product
    });

    // Cart routes
    Route::prefix('cart')->group(function () {
        Route::post('/add', [CartController::class, 'addToCart']); // Add product to cart
        Route::put('/update', [CartController::class, 'updateCartItem']); // Update cart item quantity
        Route::delete('/remove', [CartController::class, 'removeFromCart']); // Remove product from cart
        Route::get('/', [CartController::class, 'getCart']); // Get current user's cart
    });

    // Checkout route
    Route::post('/checkout', [CheckoutController::class, 'checkout']); // Checkout cart

    // Order routes
    Route::get('/orders', [OrderController::class, 'index']); // List user's orders
});

Route::post('/login', [AuthController::class, 'login']);
