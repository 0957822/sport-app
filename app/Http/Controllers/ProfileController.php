<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $exercises = $user->exercises()->paginate(10);
        $savedExercises = $user->savedExercises()->paginate(10);

        return view('pages.profile', compact('user', 'exercises', 'savedExercises'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'avatar' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($validated);

        return back()->with('status', 'Profile updated successfully');
    }

    public function saveExercise($exerciseId)
    {
        $user = auth()->user();
        $user->savedExercises()->attach($exerciseId);

        return back()->with('status', 'Exercise saved successfully');
    }

    public function unsaveExercise($exerciseId)
    {
        $user = auth()->user();
        $user->savedExercises()->detach($exerciseId);

        return back()->with('status', 'Exercise removed from saved');
    }
}
