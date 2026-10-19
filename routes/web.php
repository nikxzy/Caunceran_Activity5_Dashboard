<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/students', [StudentController::class, 'index']);
Route::get('/global-variable', [StudentController::class, 'read']);
Route::get('/greet/{name}', [StudentController::class, 'greet']);