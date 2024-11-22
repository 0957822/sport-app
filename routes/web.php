<?php

use App\Http\Controllers\HelloController;
use App\Http\Controllers\ExercisesController;
use App\Http\Controllers\AboutController;

Route::get('/', [HelloController::class, 'index']);
Route::get('/exercises', [ExercisesController::class, 'index'])->name('exercises');
Route::get('/about', [AboutController::class, 'about'])->name('about');
Route::get('/exercises/{id}', [ExercisesController::class, 'show'])->name('exercises.show');
