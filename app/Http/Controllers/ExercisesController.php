<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;

class ExercisesController extends Controller
{
    public function exercises(Request $request)
    {
        $query = Exercise::query();
        $tags = ['Strength', 'Cardio', 'Flexibility', 'Balance', 'HIIT'];

        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->tags) {
            $selectedTags = explode(',', $request->tags);
            foreach($selectedTags as $tag) {
                $query->whereJsonContains('tags', $tag);
            }
        }

        $exercises = $query->with('user')->get();
        $count = $exercises->count();

        return view('pages.exercises', compact('exercises', 'count', 'tags'));
    }

    public function show($id)
    {
        $exercise = Exercise::with('user')->findOrFail($id);
        return view('pages.exercise-details', compact('exercise'));
    }
}
