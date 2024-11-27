@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-center text-3xl font-extrabold text-gray-900">Register</h2>

            <form class="mt-8 space-y-6" action="{{ route('register.store') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 text-red-500 p-4 rounded-md">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input id="name" name="name" type="text" placeholder="John Doe" required value="{{ old('name') }}"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" placeholder="john@example.com" required value="{{ old('email') }}"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" placeholder="••••••••••" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                    <div class="mt-2 space-y-2 text-sm">
                        <p id="lengthCheck" class="text-red-500">✗ At least 10 characters</p>
                        <p id="numberCheck" class="text-red-500">✗ At least 1 number</p>
                        <p id="symbolCheck" class="text-red-500">✗ At least 1 symbol</p>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="••••••••••" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Register
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;

            const safePassword = password.replace(/[<>&"']/g, function(c) {
                return {
                    '<': '&lt;',
                    '>': '&gt;',
                    '&': '&amp;',
                    '"': '&quot;',
                    "'": '&#39;'
                }[c];
            });

            const lengthValid = safePassword.length >= 10;
            const numberValid = /\d/.test(safePassword);
            const symbolValid = /[!@#$%^&*(),.?":{}|<>]/.test(safePassword);

            const lengthCheck = document.getElementById('lengthCheck');
            const numberCheck = document.getElementById('numberCheck');
            const symbolCheck = document.getElementById('symbolCheck');

            lengthCheck.className = lengthValid ? 'text-green-500' : 'text-red-500';
            numberCheck.className = numberValid ? 'text-green-500' : 'text-red-500';
            symbolCheck.className = symbolValid ? 'text-green-500' : 'text-red-500';

            lengthCheck.textContent = (lengthValid ? '✓' : '✗') + ' At least 10 characters';
            numberCheck.textContent = (numberValid ? '✓' : '✗') + ' At least 1 number';
            symbolCheck.textContent = (symbolValid ? '✓' : '✗') + ' At least 1 symbol';
        });
    </script>
@endsection
