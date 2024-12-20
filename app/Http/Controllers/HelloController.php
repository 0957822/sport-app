<?php

// app/Http/Controllers/HelloController.php

namespace App\Http\Controllers;

use App\Models\Exercise;

class HelloController extends Controller
{
    public function index()
    {
        $latestExercise = Exercise::with('user')->latest()->first();
        return view('pages.hello', compact('latestExercise'));
    }
}



