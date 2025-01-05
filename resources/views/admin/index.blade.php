@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <table class="w-full table-auto">
                <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($exercises as $exercise)
                    <tr>
                        <td class="border px-4 py-2">{{ $exercise->title }}</td>
                        <td class="border px-4 py-2">{{ Str::limit($exercise->description, 100) }}</td>
                        <td class="border px-4 py-2">
                            @if ($exercise->is_active)
                                <span class="text-green-500">Active</span>
                            @else
                                <span class="text-red-500">Inactive</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            <div class="flex gap-2">
                                <form action="{{ route('admin.toggle-exercise', $exercise->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                        Toggle
                                    </button>
                                </form>
                                <a href="{{ route('admin.edit-exercise', $exercise->id) }}"
                                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('admin.delete-exercise', $exercise->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
