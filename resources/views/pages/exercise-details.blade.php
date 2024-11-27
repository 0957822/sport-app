@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">{{ $exercise->title }}</h1>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($exercise->image_path)
                <img src="{{ asset($exercise->image_path) }}"
                     alt="{{ $exercise->title }}"
                     class="w-full h-96 object-cover">
            @endif

            <div class="p-6">
                <p class="text-gray-700 mb-6">{{ $exercise->description }}</p>

                <div class="flex gap-2 mb-6">
                    @foreach($exercise->tags as $tag)
                        <a href="{{ route('exercises', ['tags' => $tag]) }}"
                           class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm hover:bg-blue-200">
                            {{ $tag }}
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center gap-3 mt-6 pt-6 border-t">
                    <img src="{{ $exercise->user->avatar ? asset($exercise->user->avatar) : asset('avatars/default-avatar.jpg') }}"
                         class="w-12 h-12 rounded-full">
                    <span class="font-medium">{{ $exercise->user->name }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
