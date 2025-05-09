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
                       class="task-title w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter task title">
                @error('task_title.0')
                    <span class="text-red-500 text-sm">task title is required</span>
                @enderror

                <label for="task_description[]" class="block text-sm font-medium text-gray-700 mt-2">Task Description</label>
                <textarea name="task_description[]" class="task-desc w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter task description">{{ old('task_description.0') }}</textarea>
                @error('task_description.0')
                    <span class="text-red-500 text-sm">task description is required</span>
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
    $(document).ready(function () {
        // Add task dynamically
        $('#add-task').on('click', function () {
            const taskGroup = $(`
                <div class="task-input-group mt-4">
                    <label class="block text-sm font-medium text-gray-700">Task Title</label>
                    <input type="text" name="task_title[]" class="task-title w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter task title">

                    <label class="block text-sm font-medium text-gray-700 mt-2">Task Description</label>
                    <textarea name="task_description[]" class="task-desc w-full mt-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:outline-none" placeholder="Enter task description"></textarea>

                    <button type="button" class="delete-task text-red-600 hover:text-red-800 mt-2">Delete</button>
                </div>
            `);
            $('#tasks-container').append(taskGroup);
        });

        // Delete task dynamically
        $('#tasks-container').on('click', '.delete-task', function () {
            $(this).closest('.task-input-group').remove();
        });

        // jQuery Validation Setup
        $('#intern-form').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
            },
            errorPlacement: function (error, element) {
                    error.addClass("text-red-500 text-sm");
                    error.insertAfter(element);
            },
            highlight: function (element) {
                $(element).addClass("border-red-500");
            },
            unhighlight: function (element) {
                $(element).removeClass("border-red-500");
            }
        });
        $('#intern-form').on('submit', function (e) {
           let isValid = true;

            $('.task-input-group').each(function () {
                const title = $(this).find('input[name="task_title[]"]');
                const desc = $(this).find('textarea[name="task_description[]"]');

                title.removeClass('border-red-500');
                desc.removeClass('border-red-500');
                $(this).find('.task-error').remove();

                if (title.val().trim() && !desc.val().trim()) {
                    desc.addClass('border-red-500');
                    desc.after('<span class="text-red-500 text-sm task-error">Description is required if title is entered</span>');
                    isValid = false;
                }

                if (!title.val().trim() && desc.val().trim()) {
                    title.addClass('border-red-500');
                    title.after('<span class="text-red-500 text-sm task-error">Title is required if description is entered</span>');
                    isValid = false;
                }
                
            });
            if (!isValid) {
                e.preventDefault(); // Prevent form submission
            }
            
        });
       

    });
</script>
@endsection
