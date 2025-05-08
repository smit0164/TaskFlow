@extends('layouts.admin')
@section('title', 'Add Intern')
@section('heading', 'Add New Intern')
@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Interns and Assigned Tasks</h2>
        <a href="{{ route('admin.interns.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition duration-200">
            + Add Intern
        </a>
    </div>

    <div class="grid grid-cols-3 sm:grid-cols-3 lg:grid-cols-3 gap-6">
        @foreach ($interns as $intern)
            <div class="bg-white rounded-xl shadow-md w-full p-8 hover:shadow-xl transition duration-300 max-w-md mx-auto">
                <div class="mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">{{ $intern->name }}</h3>
                    <p class="text-sm text-gray-600">Email: {{ $intern->email }}</p>
                </div>

                <!-- Edit and Delete Intern Buttons (on the intern card) -->
                <div class="mt-4 flex justify-end space-x-2">
                    <a href="{{ route('admin.interns.edit', $intern->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold text-sm px-4 py-2 rounded-lg transition duration-200">
                        Edit
                    </a>
                    <button data-id="{{ $intern->id }}" data-name="{{ $intern->name }}" data-email="{{$intern->email}}" class="delete-intern bg-red-500 hover:bg-red-600 text-white font-semibold text-sm px-4 py-2 rounded-lg transition duration-200">
                        Delete
                    </button>
                </div>

                <!-- Assigned Tasks Section -->
                <div class="mt-6">
                    <h4 class="text-base font-medium text-gray-800 mb-3">Assigned Tasks:</h4>

                    @if ($intern->tasks->isEmpty())
                        <p class="text-sm text-gray-500">No tasks assigned.</p>
                    @else
                        <div>
                            @foreach ($intern->tasks as $task)
                                <div class="bg-gray-100 rounded-lg shadow-sm p-4 mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-semibold text-gray-900 text-sm">{{ $task->title }}</span>
                                        <span class="text-sm text-gray-600">{{ $task->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700">{{ $task->description }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal for Delete Confirmation -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg p-6 relative">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">×</button>
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Delete Intern</h3>
        <p class="text-sm text-gray-700">Are you sure you want to delete <span id="internName" class="font-semibold text-gray-800"></span> (Email: <span id="internEmail" class="font-semibold text-gray-800"></span>)?</p>
        <div class="mt-4 flex justify-end space-x-4">
            <button id="cancelDelete" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded-lg">
                Cancel
            </button>
            <form id="deleteForm" method="POST" action="" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg transition duration-200">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Open delete modal and set correct intern ID, name, and email using jQuery
    $(document).on('click', '.delete-intern', function() {
        const internId = $(this).data('id');
        const internName = $(this).data('name');
        const internEmail = $(this).data('email');

        // Set intern name and email in the modal
        $('#internName').text(internName);
        $('#internEmail').text(internEmail);

        // Set the delete form action URL to include intern ID
        $('#deleteForm').attr('action', '/admin/interns/' + internId);

        // Show the modal
        $('#deleteModal').removeClass('hidden');
    });

    // Close modal
    $('#closeModal').on('click', function() {
        $('#deleteModal').addClass('hidden');
    });

    // Cancel delete
    $('#cancelDelete').on('click', function() {
        $('#deleteModal').addClass('hidden');
    });

    // Close modal if clicking outside of it
    $(window).on('click', function(e) {
        if ($(e.target).is('#deleteModal')) {
            $('#deleteModal').addClass('hidden');
        }
    });
</script>

@endsection