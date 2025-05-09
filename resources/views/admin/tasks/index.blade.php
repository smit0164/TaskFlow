@extends('layouts.admin')

@section('title', 'Tasks')
@section('heading', 'Task Management')

@section('content')

<div class="space-y-6">

    <!-- Task List -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">All Tasks</h2>
            <a href="{{ route('admin.tasks.create') }}" class="inline-flex items-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Task
            </a>
        </div>

        <!-- Check if there are any tasks for this admin -->
        @if($tasks->isEmpty())
            <p class="text-center text-gray-600 py-6">No tasks have been created.</p>
        @else
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2 text-gray-700">Task Name</th>
                        <th class="py-2 text-gray-700">Assigned To</th>
                        <th class="py-2 text-gray-700 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through the tasks and display each task -->
                    @foreach ($tasks as $task)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3">{{ $task->title }}</td>
                            <td class="py-3">
                                <!-- Loop through assigned interns -->
                                @foreach($task->interns as $intern)
                                    <span class="text-sm">{{ $intern->name }}</span><br>
                                @endforeach
                            </td>
                            <td class="py-3 text-center">
                                <a href="{{ route('admin.tasks.edit', $task->id) }}" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md text-sm transition">
                                    Edit
                                </a>

                                <button onclick="openDeleteModal({{ $task->id }}, '{{ addslashes($task->title) }}')" 
                                    class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-sm ml-2 transition">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>

<!-- Modal for Deleting Task -->
<div id="deleteModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden z-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg w-1/3 max-w-md">
        <h3 id="modalTitle" class="text-lg font-semibold mb-4"></h3>
        <form id="deleteForm" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-between">
                <button type="button" class="text-gray-600" onclick="closeDeleteModal()">Cancel</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Delete</button>
            </div>
        </form>
    </div>
</div>

@endsection

<script>
    // Open the modal and set the action for delete
    function openDeleteModal(taskId, taskTitle) {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        const form = document.getElementById('deleteForm');
        form.action = `/admin/tasks/${taskId}`; 
        document.getElementById('modalTitle').textContent = `Are you sure you want to delete the task "${taskTitle}"?`;
    }

    // Close the modal
    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }
</script>

