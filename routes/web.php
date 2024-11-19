<?php

use App\Http\Controllers\HelloController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\PageController;

Route::get('/', [HelloController::class, 'index']);
Route::get('/oefeningen', [ExerciseController::class, 'index'])->name('exercises');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/exercise/{id}', [ExerciseController::class, 'show'])->name('exercise.show');
