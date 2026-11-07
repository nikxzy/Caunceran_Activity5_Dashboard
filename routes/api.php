<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HumanResourceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PostController;   // 👈 idinagdag


Route::post('/payroll', [PayrollController::class, 'pay']);
Route::post('/payroll/calculate', [PayrollController::class, 'calculate']);

Route::prefix('v1')->group(function () {
    Route::get('/products/queries', [ProductController::class, 'queries']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
});

Route::apiResource('/posts', PostController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');