@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('heading', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto mt-6 space-y-10">

    <!-- Admin's Tasks -->
    <div>
        <h2 class="text-xl font-bold text-gray-800 mb-4">Your Created Tasks</h2>

        @if($tasks->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tasks as $task)
                    <div class="bg-white rounded-xl shadow p-4 hover:shadow-md transition">
                        <h3 class="text-lg font-semibold text-blue-700">{{ $task->title }}</h3>
                        <p class="text-sm text-gray-600 mt-2">{{ Str::limit($task->description, 100) }}</p>

                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700 mb-1">Assigned Interns:</p>
                            <ul class="list-disc list-inside text-sm text-gray-600">
                                @forelse($task->interns as $intern)
                                    <li>{{ $intern->name }}</li>
                                @empty
                                    <li>No interns assigned</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">You haven’t created any tasks yet.</p>
        @endif
    </div>

    <!-- Intern List -->
    <div>
        <h2 class="text-xl font-bold text-gray-800 mb-4">All Interns</h2>

        @if($interns->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($interns as $intern)
                    <div class="bg-white p-4 rounded-xl shadow hover:shadow-md transition">
                        <p class="text-sm font-medium text-gray-700">{{ $intern->name }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">No interns available.</p>
        @endif
    </div>

</div>
@endsection
