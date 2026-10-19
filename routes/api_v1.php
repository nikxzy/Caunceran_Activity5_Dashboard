<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Api/V1/PostController*/
 
Route::get('/user', function (\Illuminate\Http\Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/query', [ProductController::class, 'query'])->name('products.query');
Route::get('/products/queries', [ProductController::class, 'query'])->name('products.queries');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);

Route::apiResource('/product-orders', OrderProductController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy']);

Route::get('/addresses', [AddressController::class, 'index']);
Route::get('/addresses/{id}', [AddressController::class, 'show']);

Route::get('/reviews', [ReviewController::class, 'index']);
Route::get('/reviews/{id}', [ReviewController::class, 'show']);