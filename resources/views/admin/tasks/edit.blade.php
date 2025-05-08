@extends('layouts.admin')

@section('title', 'Edit Task')
@section('heading', 'Edit Task')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow w-full max-w-2xl mx-auto mt-6">

        <!-- Task Edit Form -->
        <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST" class="space-y-6" id="editTaskForm">
            @csrf
            @method('PUT')

            <!-- Task Title Input Field -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700">Task Title</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $task->title) }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                    placeholder="Enter task title"
                >
                @error('title')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description Textarea -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700">Task Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                    placeholder="Enter task description"
                >{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Assigned To Checkboxes -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Assign to Interns</label>
                <div class="space-y-2">
                    <!-- Select All Checkbox -->
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="selectAll" 
                            class="mr-2 leading-tight"
                        >
                        <label for="selectAll" class="text-sm text-gray-700">Select All</label>
                    </div>

                    <!-- Loop through the interns and create a checkbox for each -->
                    @foreach ($interns as $intern)
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="intern_{{ $intern->id }}" 
                                name="assigned_to[]" 
                                value="{{ $intern->id }}" 
                                class="mr-2 leading-tight intern-checkbox"
                                {{ (is_array(old('assigned_to', $task->interns->pluck('id')->toArray())) && in_array($intern->id, old('assigned_to', $task->interns->pluck('id')->toArray()))) ? 'checked' : '' }}
                            >
                            <label for="intern_{{ $intern->id }}" class="text-sm text-gray-700">{{ $intern->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('assigned_to')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons for Cancel and Submit -->
            <div class="flex justify-end items-center space-x-4">
                <a href="{{ route('admin.tasks.index') }}" class="text-gray-600 hover:text-blue-600 underline">Cancel</a>
                <button 
                    type="submit" 
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition duration-200"
                >
                    Update Task
                </button>
            </div>
        </form>
    </div>

    <!-- JavaScript to handle Select All functionality -->
    <script>
    $(document).ready(function () {
        // Select All checkbox functionality
        $('#selectAll').on('change', function () {
            $('.intern-checkbox').prop('checked', this.checked);
        });

        $('#editTaskForm').validate({
        rules: {
            title: {
                required: true,
                minlength: 3
            },
            description: {
                required: true,
                minlength: 5
            },
            'assigned_to[]': {
                required: true
            }
        },
        messages: {
            title: {
                required: "Please enter a task title",
                minlength: "Title must be at least 3 characters"
            },
            description: {
                required: "Please enter a description",
                minlength: "Description must be at least 5 characters"
            },
            'assigned_to[]': {
                required: "Please select at least one intern"
            }
        },
        errorClass: "text-red-600 text-sm mt-1",
        errorPlacement: function (error, element) {
            if (element.attr("name") === "assigned_to[]") {
                error.insertAfter(element.closest('.space-y-2'));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element) {
            $(element).addClass('border-red-600');
        },
        unhighlight: function (element) {
            $(element).removeClass('border-red-600');
        }
});

    });
</script>

@endsection
