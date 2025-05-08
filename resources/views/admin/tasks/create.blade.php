@extends('layouts.admin')

@section('title', 'Add Task')
@section('heading', 'Add New Task')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow w-full max-w-2xl mx-auto mt-6">
        <!-- Task Creation Form -->
        <form id="taskForm" action="{{ route('admin.tasks.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Task Title Input Field -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700">Task Title</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent input-field" 
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
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent input-field" 
                    placeholder="Enter task description"
                >{{ old('description') }}</textarea>
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
                                {{ (is_array(old('assigned_to')) && in_array($intern->id, old('assigned_to'))) ? 'checked' : '' }}
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
                    Create Task
                </button>
            </div>
        </form>
    </div>

    <!-- JavaScript to handle Select All functionality -->
    <script>
    document.getElementById('selectAll').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.intern-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    $(document).ready(function () {
        $("#taskForm").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 5
                },
                description: {
                    required: true,
                    minlength: 10
                },
                'assigned_to[]': {
                    required: true,
                    minlength: 1
                }
            },
            messages: {
                title: {
                    required: "Please enter a task title",
                    minlength: "Title must be at least 5 characters long"
                },
                description: {
                    required: "Please enter a task description",
                    minlength: "Description must be at least 10 characters long"
                },
                'assigned_to[]': {
                    required: "Please assign at least one intern"
                }
            },
            errorClass: "text-sm text-red-600 mt-1",
            errorElement: "p",

            highlight: function (element) {
                $(element).addClass('border-red-500').removeClass('border-blue-500');
            },
            unhighlight: function (element) {
                $(element).removeClass('border-red-500').addClass('border-blue-500');
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "assigned_to[]") {
                    error.insertAfter(element.closest('.space-y-2'));
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        $('.input-field').on('focus', function () {
            $(this).addClass('border-blue-500');
        }).on('blur', function () {
            if (!$(this).valid()) {
                $(this).removeClass('border-blue-500');
            }
        });
    });
</script>


   
@endsection

