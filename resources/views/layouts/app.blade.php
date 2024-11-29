<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportify</title>
    @vite('resources/css/app.css')

</head>
<body>
<!-- Header with navigation -->
<header class="bg-white shadow">
    <nav class="container mx-auto px-6 py-3">
        <div class="flex justify-between items-center">
            <!-- Left side navigation -->
            <div class="flex items-center space-x-4">
                <a href="{{ url('/') }}"
                   class="text-gray-800 hover:text-blue-500">
                    Sportify
                </a>
                <a href="{{ route('exercises') }}"
                   class="text-gray-800 hover:text-blue-500">
                    Exercises
                </a>
                <a href="{{ url('/about') }}"
                   class="text-gray-800 hover:text-blue-500">
                    About
                </a>
            </div>

            <!-- Middle buttons (only shown when logged in) -->
            @auth
                <div class="flex items-center space-x-4">
                    <a href="{{ route('profile') }}"
                       class="text-gray-800 hover:text-blue-500">
                        Profile
                    </a>
                    <a href="{{ route('exercises.create') }}"
                       class="text-gray-800 hover:text-blue-500">
                        Create
                    </a>
                </div>
            @endauth

            <!-- Right side navigation -->
            <div class="flex items-center space-x-4">
                @auth
                    <div class="flex items-center space-x-2">
                        <img src="{{ auth()->user()->avatar
                        ? Storage::url(auth()->user()->avatar)
                        : asset('avatars/default-avatar.jpg') }}"
                             alt="Profile picture"
                             class="w-8 h-8 rounded-full object-cover">
                        <span class="text-gray-800">Hi, {{ auth()->user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="text-gray-800 hover:text-blue-500">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-gray-800 hover:text-blue-500">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="text-gray-800 hover:text-blue-500">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>
</header>

<!-- Page content -->
<main class="container mx-auto px-6 py-8">
    @yield('content')
</main>
</body>
</html>
