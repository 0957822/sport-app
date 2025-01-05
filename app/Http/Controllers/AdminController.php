<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $exercises = Exercise::withTrashed()->get();
        return view('admin.index', compact('exercises'));
    }

    public function toggleExercise(Exercise $exercise)
    {
        $exercise->is_active = !$exercise->is_active;
        $exercise->save();
        return back()->with('status', 'Exercise status updated successfully.');
    }

    public function editExercise(Exercise $exercise)
    {
        $tags = ['Cardio', 'Strength', 'Flexibility', 'Balance', 'Weight Training'];
        $exerciseTags = $exercise->tags ? json_decode($exercise->tags, true) : [];
        return view('admin.edit', compact('exercise', 'tags', 'exerciseTags'));
    }

    public function updateExercise(Request $request, Exercise $exercise)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'tags' => 'array',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($exercise->image_path) {
                Storage::delete('public/' . $exercise->image_path);
            }
            $imagePath = $request->file('image')->store('exercises', 'public');
            $validatedData['image_path'] = $imagePath;
        }

        if (isset($validatedData['tags'])) {
            $validatedData['tags'] = json_encode($validatedData['tags']);
        }

        $exercise->update($validatedData);
        return redirect()->route('admin.index')->with('status', 'Exercise updated successfully.');
    }

    public function deleteExercise(Exercise $exercise)
    {
        $exercise->delete();
        return redirect()->route('admin.index')->with('status', 'Exercise deleted successfully.');
    }
}
