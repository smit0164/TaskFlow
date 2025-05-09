@extends('layouts.intern')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    @if($tasks->count())
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach($tasks as $task)
                <a href="{{ route('intern.task.show', $task->id) }}" 
                   class="block bg-white rounded-lg p-5 border border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex flex-col space-y-3">
                        <!-- Task Title with Icon -->
                        <div class="flex items-center space-x-2">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h2 class="text-base font-semibold text-gray-800 truncate">{{ $task->title }}</h2>
                        </div>
                        <!-- Admin Name with Icon -->
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm text-gray-500">
                                {{ $task->createdBy ? $task->createdBy->name : 'No Admin Found' }}
                            </span>
                        </div>
                        <!-- Show Details Button -->
                        <div class="text-center">
                            <button type="button" 
                                    onclick="window.location='{{ route('intern.task.show', $task->id) }}'"
                                    class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-md text-sm font-medium transition-colors duration-200">
                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Show Details
                            </button>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg p-5 border border-gray-100 text-center">
            <p class="text-gray-500 text-sm">You have no assigned tasks at the moment.</p>
        </div>
    @endif
</div>
@endsection