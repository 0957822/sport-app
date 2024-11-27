<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ExerciseSeeder extends Seeder
{
    public function run()
    {
        // Create directories
        if (!File::exists(public_path('images'))) {
            File::makeDirectory(public_path('images'));
        }
        if (!File::exists(public_path('avatars'))) {
            File::makeDirectory(public_path('avatars'));
        }

        // Copy avatar image
        $avatarPath = public_path('avatars/default-avatar.jpg');
        if (!File::exists($avatarPath)) {
            File::copy(public_path('images/default-profile.jpg'), $avatarPath);
        }

        // Create user with avatar
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'avatar' => 'avatars/default-avatar.jpg'
        ]);

        // Create exercise
        Exercise::create([
            'title' => 'Push-ups',
            'description' => 'A classic exercise for chest and arms strength.',
            'image_path' => 'images/pushup.jpg',
            'user_id' => $user->id
        ]);

        // Define available tags
        $tags = ['Strength', 'Cardio', 'Flexibility', 'Balance', 'HIIT'];

        // Create multiple exercises with tags
        $exercises = [
            [
                'title' => 'Push-ups',
                'description' => 'A classic exercise for chest and arms strength.',
                'image_path' => 'images/pushup.jpg',
                'tags' => ['Strength', 'HIIT']
            ],
            [
                'title' => 'Running',
                'description' => 'Basic cardio exercise for endurance.',
                'image_path' => 'images/running.jpg',
                'tags' => ['Cardio']
            ],
            // Add more exercises as needed
        ];

        foreach ($exercises as $exercise) {
            Exercise::create([
                'title' => $exercise['title'],
                'description' => $exercise['description'],
                'image_path' => $exercise['image_path'],
                'user_id' => $user->id,
                'tags' => $exercise['tags']
            ]);
        }
    }
}

