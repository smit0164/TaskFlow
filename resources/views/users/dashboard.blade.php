@extends('layouts.intern')

@section('title', 'Intern Dashboard')
@section('heading', 'My Assigned Tasks')

@section('content')
    @if($tasks->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tasks as $task)
                <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500 hover:shadow-lg transition-all flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-blue-600">{{ $task->title }}</h2>
                        <p class="text-sm text-gray-600 mt-2">{{ $task->description }}</p>

                        <div class="mt-4 text-sm text-gray-500">
                            <span class="font-medium">Created By:</span>
                            {{ $task->createdBy ? $task->createdBy->name : 'No Admin Found' }}
                        </div>

                        <div class="mt-2">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">Task ID: {{ $task->id }}</span>
                        </div>
                    </div>

                    <!-- Comment Form -->
                    <!-- Comment Form (For Interns) -->
<div class="mt-6 border-t pt-4">
    <form action="{{ route('intern.comment.store') }}" method="POST">
        @csrf
        <input type="hidden" name="task_id" value="{{ $task->id }}">

        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Your Comment:</label>
        <textarea name="content" rows="2" placeholder="Write your comment..."
            class="w-full p-3 border rounded-lg text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
            required></textarea>

        <div class="mt-3 text-right">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-all">
                Post Comment
            </button>
        </div>
    </form>
</div>

                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">You have no assigned tasks at the moment.</p>
    @endif
@endsection
