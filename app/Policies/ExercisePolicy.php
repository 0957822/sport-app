<?php

namespace App\Policies;

use App\Models\User;

class ExercisePolicy
{
    public function create(User $user)
    {
        return $user->canCreateExercise();
    }

    public function update(User $user, Exercise $exercise)
    {
        return $user->id === $exercise->user_id;
    }
}
