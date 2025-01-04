<?php

use App\Http\Controllers\HelloController;
use App\Http\Controllers\ExercisesController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;

// Public routes
Route::get('/', [HelloController::class, 'index']);
Route::get('/exercises', [ExercisesController::class, 'exercises'])->name('exercises');
Route::get('/about', [AboutController::class, 'about'])->name('about');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/exercises/{exercise}/save', [ProfileController::class, 'saveExercise'])->name('profile.save-exercise');
    Route::delete('/exercises/{exercise}/unsave', [ProfileController::class, 'unsaveExercise'])->name('profile.unsave-exercise');

    // Exercise creation routes
    Route::get('/exercises/create', [ExercisesController::class, 'create'])->name('exercises.create');
    Route::post('/exercises', [ExercisesController::class, 'store'])->name('exercises.store');
});

// This needs to come after the create route
Route::get('/exercises/{id}', [ExercisesController::class, 'show'])->name('exercises.show');

// Authentication routes
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password reset routes
Route::get('/forgot-password', [PasswordResetController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->name('password.email');
