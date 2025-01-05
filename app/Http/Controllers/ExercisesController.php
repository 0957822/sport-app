<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use Illuminate\Support\Facades\Storage;

class ExercisesController extends Controller
{
    public function exercises(Request $request)
    {
        $query = Exercise::query();
        $tags = ['Strength', 'Cardio', 'Yoga', 'Stretch', 'HIIT'];

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

    public function create()
    {
        if (!auth()->user()->canCreateExercise()) {
            return redirect()->route('exercises')
                ->with('error', 'You need to login at least 5 times before creating exercises.');
        }

        $tags = ['Compound', 'Isolation', 'Strength', 'HIIT', 'Yoga', 'Cardio', 'Stretch'];
        return view('pages.exercises.create', compact('tags'));
    }

    public function edit(Exercise $exercise)
    {
        // Security check
        abort_if(auth()->id() !== $exercise->user_id, 403);

        $tags = ['Compound', 'Isolation', 'Strength', 'HIIT', 'Yoga', 'Cardio', 'Stretch'];
        return view('pages.exercises.edit', compact('exercise', 'tags'));
    }

    public function update(Request $request, Exercise $exercise)
    {
        // Security check
        abort_if(auth()->id() !== $exercise->user_id, 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'tags' => ['required', 'array'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($exercise->image_path) {
                Storage::disk('public')->delete($exercise->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('exercises', 'public');
        }

        $exercise->update($validated);

        return redirect()->route('exercises.show', $exercise)
            ->with('success', 'Exercise updated successfully');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->canCreateExercise()) {
            return redirect()->route('exercises');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'tags' => ['required', 'array'],
            'image' => ['required', 'image', 'max:2048'], // 2MB max
        ]);

        $imagePath = $request->file('image')->store('exercises', 'public');

        $exercise = Exercise::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'tags' => $validated['tags'],
            'image_path' => $imagePath,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('exercises.show', $exercise)
            ->with('success', 'Exercise created successfully!');
    }
}
