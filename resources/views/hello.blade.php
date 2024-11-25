@extends('layouts.app')

@section('content')
    <!-- Welcome section -->
    <div class="welcome-box">
        <h1>Welcome to Sportify</h1>
        <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
    </div>

    <!-- Latest Exercise Box -->
    @if($latestExercise)
        <div class="latest-exercise-box">
            <h2>Latest Exercise</h2>

            <div class="exercise-content">
                <!-- Exercise Image -->
                @if($latestExercise->image_path)
                    <img src="{{ asset($latestExercise->image_path) }}"
                         alt="{{ $latestExercise->title }}"
                         class="exercise-image">
                @endif

                <div class="exercise-info">
                    <!-- Exercise Details -->
                    <h3>{{ $latestExercise->title }}</h3>
                    <p>{{ $latestExercise->description }}</p>

                    <div class="exercise-footer">
                        <!-- User Info -->
                        <div class="user-info">
                            @if($latestExercise->user->avatar)
                                <img src="{{ asset($latestExercise->user->avatar) }}"
                                     alt="User avatar"
                                     class="user-avatar">
                            @endif
                            <span>{{ $latestExercise->user->name }}</span>
                        </div>

                        <!-- Details Button -->
                        <a href="{{ route('exercises.show', $latestExercise->id) }}"
                           class="details-button">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .welcome-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .latest-exercise-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .latest-exercise-box h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .exercise-image {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .exercise-info h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .exercise-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .details-button {
            background: #3490dc;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
        }

        .details-button:hover {
            background: #2779bd;
        }
    </style>
@endsection
