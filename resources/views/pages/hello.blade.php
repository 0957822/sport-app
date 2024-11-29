@extends('layouts.app')

@section('content')
    <!-- Welcome Box -->
    <div class="box">
        <h1 class="text-3xl font-bold mb-6">Welcome to Sportify</h1>
        <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
        </p>
    </div>

    <!-- Latest Exercise Box -->
    @if($latestExercise)
        <div class="box">
            <h2 class="text-2xl font-bold mb-6">Latest Exercise</h2>
            @if($latestExercise->image_path)
                <img src="{{ asset($latestExercise->image_path) }}" alt="Exercise" class="exercise-img">
            @endif

            <div class="exercise-content">
                <h3 class="text-1xl font-bold mb-6">{{ $latestExercise->title }}</h3>
                <p>{{ $latestExercise->description }}</p>

                <div class="footer">
                    <div class="user">
                        <img src="{{ $latestExercise->user->avatar ?? asset('avatars/default-avatar.jpg') }}"
                             alt="User" class="avatar">
                        <span>{{ $latestExercise->user->name }}</span>
                    </div>
                    <a href="{{ route('exercises.show', $latestExercise->id) }}" class="button">View Details</a>
                </div>
            </div>
        </div>
    @endif

    <style>
        .box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .exercise-img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
            margin: 15px 0;
        }

        .exercise-content {
            padding: 10px 0;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .button {
            background: #3490dc;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
        }

        .button:hover {
            background: #2779bd;
        }
    </style>
@endsection
