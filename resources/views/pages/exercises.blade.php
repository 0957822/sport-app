@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Exercises ({{ $count }})</h1>

    <!-- Tags filter -->
    <div class="mb-6">
        <h2 class="text-xl mb-3">Filter by tags:</h2>
        <div class="flex flex-wrap gap-2">
            @foreach($tags as $tag)
                <button onclick="toggleTag('{{ $tag }}')"
                        class="tag-button px-3 py-1 rounded-full border"
                        data-tag="{{ $tag }}">
                    {{ $tag }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Search bar -->
    <div class="flex gap-4 mb-8">
        <input type="text"
               id="searchInput"
               class="flex-1 border rounded-lg px-4 py-2"
               placeholder="Search exercises...">
        <button onclick="search()"
                class="bg-blue-500 text-white px-6 py-2 rounded-lg">
            Find
        </button>
    </div>

    <!-- Exercise grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($exercises as $exercise)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($exercise->image_path)
                    <img src="{{ asset($exercise->image_path) }}"
                         alt="{{ $exercise->title }}"
                         class="w-full h-48 object-cover">
                @endif
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $exercise->title }}</h3>
                    <div class="flex items-center gap-2 mb-4">
                        <img src="{{ $exercise->user->avatar ?? asset('avatars/default-avatar.jpg') }}"
                             class="w-8 h-8 rounded-full">
                        <span>{{ $exercise->user->name }}</span>
                    </div>
                    <a href="{{ route('exercises.show', $exercise->id) }}"
                       class="block text-center bg-blue-500 text-white px-4 py-2 rounded">
                        Details
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        let selectedTags = [];

        function toggleTag(tag) {
            const index = selectedTags.indexOf(tag);
            const button = document.querySelector(`[data-tag="${tag}"]`);

            if (index > -1) {
                selectedTags.splice(index, 1);
                button.classList.remove('bg-blue-500', 'text-white');
            } else {
                selectedTags.push(tag);
                button.classList.add('bg-blue-500', 'text-white');
            }
        }

        function search() {
            const searchTerm = document.getElementById('searchInput').value;
            const tags = selectedTags.join(',');
            window.location.href = `{{ route('exercises') }}?search=${searchTerm}&tags=${tags}`;
        }
    </script>
@endsection
