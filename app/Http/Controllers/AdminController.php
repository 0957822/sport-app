<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $exercises = Exercise::withTrashed()->get();
        return view('admin.index', compact('exercises'));
    }

    public function toggleExercise(Exercise $exercise)
    {
        // Ensure only admins can access this
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Toggle the exercise's status
        $exercise->is_active = !$exercise->is_active;
        $exercise->save();

        return back()->with('status', 'Exercise status updated successfully.');
    }

    public function editExercise(Exercise $exercise)
    {
        // Ensure only admins can access this
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // list of tags
        $tags = ['Cardio', 'Strength', 'Flexibility', 'Balance', 'Weight Training'];
        $exerciseTags = $exercise->tags ? json_decode($exercise->tags, true) : [];

        return view('admin.edit', compact('exercise', 'tags', 'exerciseTags'));
    }

    public function updateExercise(Request $request, Exercise $exercise)
    {
        // Ensure only admins can access this
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the request
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'tags' => 'array',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($exercise->image_path) {
                Storage::delete('public/' . $exercise->image_path);
            }

            // Store new image
            $imagePath = $request->file('image')->store('exercises', 'public');
            $validatedData['image_path'] = $imagePath;
        }

        // Convert tags to JSON
        if (isset($validatedData['tags'])) {
            $validatedData['tags'] = json_encode($validatedData['tags']);
        }

        // Update the exercise
        $exercise->update($validatedData);

        return redirect()->route('admin.index')->with('status', 'Exercise updated successfully.');
    }

    public function deleteExercise(Exercise $exercise)
    {
        // Ensure only admins can access this
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $exercise->delete();

        return redirect()->route('admin.index')->with('status', 'Exercise deleted successfully.');
    }
}
