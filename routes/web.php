<?php

use App\Http\Controllers\HelloController;
use App\Http\Controllers\ExercisesController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', [HelloController::class, 'index']);
Route::get('/exercises', [ExercisesController::class, 'exercises'])->name('exercises');
Route::get('/about', [AboutController::class, 'about'])->name('about');

// Authentication routes
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

// Password reset routes
Route::get('/forgot-password', [PasswordResetController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
    ->name('password.email');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/exercises/{exercise}/save', [ProfileController::class, 'saveExercise'])->name('profile.save-exercise');
    Route::delete('/exercises/{exercise}/unsave', [ProfileController::class, 'unsaveExercise'])->name('profile.unsave-exercise');

    // Exercise routes
    Route::get('/exercises/create', [ExercisesController::class, 'create'])->name('exercises.create');
    Route::post('/exercises', [ExercisesController::class, 'store'])->name('exercises.store');
    Route::get('/exercises/{exercise}/edit', [ExercisesController::class, 'edit'])->name('exercises.edit');
    Route::put('/exercises/{exercise}', [ExercisesController::class, 'update'])->name('exercises.update');

// Admin routes (inside the auth middleware group)
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/exercises/{exercise}/toggle', [AdminController::class, 'toggleExercise'])->name('admin.toggle-exercise');
        Route::get('/exercises/{exercise}/edit', [AdminController::class, 'editExercise'])->name('admin.edit-exercise');
        Route::put('/exercises/{exercise}', [AdminController::class, 'updateExercise'])->name('admin.update-exercise');
        Route::delete('/exercises/{exercise}', [AdminController::class, 'deleteExercise'])->name('admin.delete-exercise');
    });

    // Logout route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });

    // This needs to be after the protected routes
    Route::get('/exercises/{id}', [ExercisesController::class, 'show'])->name('exercises.show');

