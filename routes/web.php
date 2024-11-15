<?php

//use Illuminate\Support\Facades\Route;

// routes/web.php

use App\Http\Controllers\HomeController;

Route::get('/', [App\Http\Controllers\HelloController::class, 'index']);

