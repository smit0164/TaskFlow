@extends('layouts.admin')
@section('title', 'Create new Intern')
@section('heading', 'Create New Intern')
@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add New Intern and Assign Tasks</h2>
    <form id="intern-form" action="{{ route('admin.interns.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   class="w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:outline-none @error('name') border-red-500 @enderror">
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                   class="w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:outline-none @error('email') border-red-500 @enderror">
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Task Inputs -->
        <div id="tasks-container">
            <div class="task-input-group">
                <label for="task_title[]" class="block text-sm font-medium text-gray-700">Task Title</label>
                <input type="text" name="task_title[]" value="{{ old('task_title.0') }}"
                       class="w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:outline-none @error('task_title.0') border-red-500 @enderror" placeholder="Enter task title">
                @error('task_title.0')
                    <span class="text-red-500 text-sm">task title is required </span>
                @enderror

                <label for="task_description[]" class="block text-sm font-medium text-gray-700 mt-2">Task Description</label>
                <textarea name="task_description[]" class="w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:outline-none @error('task_description.0') border-red-500 @enderror" placeholder="Enter task description">{{ old('task_description.0') }}</textarea>
                @error('task_description.0')
                    <span class="text-red-500 text-sm">task descriptions is required </span>
                @enderror
                <button type="button" class="delete-task text-red-600 hover:text-red-800 mt-2">Delete</button>
            </div>
        </div>

        <div class="flex justify-between items-center mt-4">
            <button type="button" id="add-task" class="text-blue-600 hover:text-blue-800">+ Add Task</button>
            <div class="flex gap-2">
        <a href="{{ route('admin.interns.index') }}"
           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded-lg shadow">
            Cancel
        </a>
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow">
            Add Intern
        </button>
    </div>
        </div>
    </form>
</div>

<script>
    // Add new task input dynamically
    document.getElementById('add-task').addEventListener('click', function() {
        const taskGroup = document.createElement('div');
        taskGroup.classList.add('task-input-group', 'mt-4');

        taskGroup.innerHTML = `
            <label for="task_title[]" class="block text-sm font-medium text-gray-700">Task Title</label>
            <input type="text" name="task_title[]" class="w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter task title">

            <label for="task_description[]" class="block text-sm font-medium text-gray-700 mt-2">Task Description</label>
            <textarea name="task_description[]" class="w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter task description"></textarea>
            <button type="button" class="delete-task text-red-600 hover:text-red-800 mt-2">Delete</button>
        `;
        
        document.getElementById('tasks-container').appendChild(taskGroup);
    });

    // Delete task input dynamically
    document.getElementById('tasks-container').addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('delete-task')) {
            event.target.closest('.task-input-group').remove();
        }
    });
</script>
@endsection
