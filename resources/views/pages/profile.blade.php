@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="space-y-8">
            <!-- Profile Header -->
            <div class="bg-white shadow rounded-lg p-6">
                <h1 class="text-3xl font-bold mb-6">Profile</h1>

                @if (session('status'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Profile Form -->
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Avatar Section -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                            <div class="flex items-center space-x-6">
                                <div class="flex-shrink-0">
                                    <img src="{{ auth()->user()->avatar
                                    ? Storage::url(auth()->user()->avatar)
                                    : asset('avatars/default-avatar.jpg') }}"
                                         alt="Profile picture"
                                         class="h-24 w-24 object-cover rounded-full">
                                </div>
                                <div>
                                    <input type="file"
                                           name="avatar"
                                           id="avatar"
                                           accept="image/*"
                                           class="block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-full file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100">
                                    @error('avatar')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name', auth()->user()->name) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   value="{{ old('email', auth()->user()->email) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Your Exercises Section -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Your Exercises</h2>
                @if($exercises->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($exercises as $exercise)
                            <div class="border rounded-lg overflow-hidden">
                                @if($exercise->image_path)
                                    <img src="{{ Storage::url($exercise->image_path) }}"
                                         alt="{{ $exercise->title }}"
                                         class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4">
                                    <h3 class="font-bold text-lg mb-2">{{ $exercise->title }}</h3>
                                    <p class="text-gray-600 mb-4">{{ Str::limit($exercise->description, 100) }}</p>
                                    <div class="flex gap-2">
                                        <a href="{{ route('exercises.show', $exercise->id) }}"
                                           class="flex-1 text-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                            Details
                                        </a>
                                        <a href="{{ route('exercises.edit', $exercise->id) }}"
                                           class="flex-1 text-center bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">You haven't created any exercises yet.</p>
                @endif
            </div>

            <!-- Saved Exercises Section -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Saved Exercises</h2>
                @if($savedExercises->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($savedExercises as $exercise)
                            <div class="border rounded-lg overflow-hidden">
                                @if($exercise->image_path)
                                    <img src="{{ Storage::url($exercise->image_path) }}"
                                         alt="{{ $exercise->title }}"
                                         class="w-full h-48 object-cover">
                                @endif
                                <div class="p-4">
                                    <h3 class="font-bold text-lg mb-2">{{ $exercise->title }}</h3>
                                    <p class="text-gray-600 mb-4">{{ Str::limit($exercise->description, 100) }}</p>
                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('exercises.show', $exercise->id) }}"
                                           class="text-blue-600 hover:text-blue-800">
                                            View Details
                                        </a>
                                        <form action="{{ route('profile.unsave-exercise', $exercise->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-800">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $savedExercises->links() }}
                    </div>
                @else
                    <p class="text-gray-500">You haven't saved any exercises yet.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
