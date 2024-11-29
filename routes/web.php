<?php

use App\Http\Controllers\HelloController;
use App\Http\Controllers\ExercisesController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PasswordResetController;

Route::get('/', [HelloController::class, 'index']);
Route::get('/exercises', [ExercisesController::class, 'exercises'])->name('exercises');
Route::get('/about', [AboutController::class, 'about'])->name('about');
Route::get('/exercises/{id}', [ExercisesController::class, 'show'])->name('exercises.show');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::get('/forgot-password', [PasswordResetController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');
Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->name('password.email');


