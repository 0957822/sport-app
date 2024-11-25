<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport App</title>
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
                <a href="{{ url('/exercises') }}"
                   class="text-gray-800 hover:text-blue-500">
                    Exercises
                </a>
                <a href="{{ url('/about') }}"
                   class="text-gray-800 hover:text-blue-500">
                    About
                </a>
            </div>

            <!-- Right side navigation -->
            <div class="flex items-center space-x-4">
                <a href="{{ url('/login') }}"
                   class="text-gray-800 hover:text-blue-500">
                    Login
                </a>
                <a href="{{ url('/register') }}"
                   class="text-gray-800 hover:text-blue-500">
                    Register
                </a>
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
