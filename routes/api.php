<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HumanResourceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PayrollController;
use Illuminate\Http\Request;

Route::post('/payroll', [PayrollController::class, 'pay']);
Route::post('/payroll/calculate', [PayrollController::class, 'calculate']);

Route::prefix('v1')->name('api.v1.')->group(base_path('routes/api_v1.php'));



