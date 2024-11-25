<?php

use App\Http\Controllers\HelloController;
use App\Http\Controllers\ExercisesController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/', [HelloController::class, 'index']);
Route::get('/exercises', [ExercisesController::class, 'exercises'])->name('exercises');
Route::get('/about', [AboutController::class, 'about'])->name('about');
Route::get('/exercises/{id}', [ExercisesController::class, 'show'])->name('exercises.show');
Route::get('/login/{id}', [LoginController::class, 'show'])->name('login');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/register', [RegisterController::class, 'register'])->name('register');
