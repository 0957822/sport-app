<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    public function run()
    {
        // Create a test user first
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create a test exercise
        Exercise::create([
            'title' => 'Push-ups',
            'description' => 'A classic exercise for chest and arms strength.',
            'image_path' => 'images/pushup.jpg',
            'user_id' => $user->id
        ]);
    }
}
