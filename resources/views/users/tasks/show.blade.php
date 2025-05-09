@extends('layouts.intern')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <!-- Left Column: Task Details -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('intern.dashboard') }}" 
                   class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>

            <!-- Task Header -->
            <div class="flex items-center space-x-3 mb-4">
                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h2 class="text-xl font-semibold text-gray-900">{{ $task->title }}</h2>
            </div>

            <!-- Task ID -->
            <div class="mb-4">
                <span class="inline-flex items-center bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-medium">
                    Task ID: {{ $task->id }}
                </span>
            </div>

            <!-- Task Description -->
            <p class="text-sm text-gray-600 leading-relaxed mb-6">{{ $task->description }}</p>

            <!-- Created By -->
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>
                    Created By: {{ $task->createdBy ? $task->createdBy->name : 'No Admin Found' }}
                </span>
            </div>
        </div>

        <!-- Right Column: Comment Section -->
        <div class="lg:col-span-3 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <!-- Comment Form (For Authenticated Interns) -->
            @if (auth()->guard('intern')->check())
                <div class="mb-6">
                    <form action="{{ route('intern.comment.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <input type="hidden" name="user_type" value="intern">

                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Add a Comment</label>
                        <div class="relative">
                            <textarea name="description" id="description" rows="4" placeholder="Write your comment..."
                                class="w-full p-3 border border-gray-200 rounded-lg text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                required></textarea>
                        </div>

                        @error('description')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror

                        <div class="mt-3 text-right">
                            <button type="submit"
                                class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Post Comment
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Comments Display -->
            <div>
                <h4 class="text-sm font-medium text-gray-700 mb-4 flex items-center space-x-2">
                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5v-4a2 2 0 012-2h10a2 2 0 012 2v4h-4m-6 0h6"></path>
                    </svg>
                    <span>Comments</span>
                </h4>
                <div class="h-[300px] overflow-y-auto pr-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    @forelse($task->comments as $comment)
                        <div class="bg-gray-50 p-4 rounded-lg mb-3 border border-gray-100">
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $comment->description }}</p>
                            <div class="flex items-center justify-between mt-3">
                                <div class="flex items-center space-x-2">
                                    <p class="text-xs text-gray-600 font-medium">
                                        {{ $comment->commenter ? $comment->commenter->name : 'Deleted User' }}
                                    </p>
                                    @if ($comment->isAdminComment())
                                        <span class="inline-flex items-center bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full">Admin</span>
                                    @else
                                        <span class="inline-flex items-center bg-gray-500 text-white text-xs px-2 py-0.5 rounded-full">Intern</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-400">{{ $comment->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 italic">No comments yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom scrollbar styles */
    .scrollbar-thin {
        scrollbar-width: thin;
    }
    .scrollbar-thin::-webkit-scrollbar {
        width: 8px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 4px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #b0b3b8;
    }
</style>
@endsection