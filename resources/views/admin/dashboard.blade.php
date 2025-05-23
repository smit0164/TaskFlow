@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('heading', 'Tasks You Created')

@section('content')
<div class="max-w-7xl mx-auto py-8">

    @if($tasks->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tasks as $task)
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-300 flex flex-col">
                    <!-- Task Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $task->title }}</h2>
                        <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-medium">Task ID: {{ $task->id }}</span>
                    </div>

                    <!-- Task Description -->
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ Str::limit($task->description, 150) }}</p>

                    <!-- Assigned Intern -->
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

                    <!-- Comment Form (For Authenticated Admins) -->
                    @if (auth()->guard('admin')->check())
                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <form action="{{ route('admin.comment.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="task_id" value="{{ $task->id }}">
                                <input type="hidden" name="user_type" value="admin">

                                <label for="description_{{ $task->id }}" class="block text-sm font-medium text-gray-700 mb-2">Add a Comment</label>
                                <div class="relative">
                                    <textarea name="description" id="description_{{ $task->id }}" rows="3" placeholder="Write your comment..."
                                        class="w-full p-3 border border-gray-200 rounded-lg text-sm resize-none focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                        required></textarea>
                                    <svg class="absolute top-3 right-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>

                                @error('description')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror

                                <div class="mt-3 text-right">
                                    <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                        <span>Post Comment</span>
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <!-- Comments Display -->
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center space-x-2">
                            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5v-4a2 2 0 012-2h10a2 2 0 012 2v4h-4m-6 0h6"></path>
                            </svg>
                            <span>Comments</span>
                        </h4>
                        @forelse($task->comments as $comment)
                            <div class="bg-gray-50 p-4 rounded-lg mb-3 border border-gray-100 shadow-sm">
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $comment->description }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-xs text-gray-500">
                                        <span class="font-medium">{{ $comment->commenter ? $comment->commenter->name : 'Deleted User' }}</span>
                                        @if ($comment->isAdminComment())
                                            <span class="inline-block bg-green-600 text-white text-xs px-2 py-0.5 rounded-full ml-2">Admin</span>
                                        @else
                                            <span class="inline-block bg-gray-600 text-white text-xs px-2 py-0.5 rounded-full ml-2">Intern</span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $comment->created_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic">No comments yet.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-center">
            <p class="text-gray-600 text-sm">No tasks created yet.</p>
        </div>
    @endif
</div>
@endsection
