@extends('layouts.admin')
@section('title', 'Manage Users')
@section('heading', 'Manage Users')

@section('content')
<div class="container mx-auto mt-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">All Users</h2>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">+ Add User</a>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Role</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-t">
                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                        <td class="px-4 py-2 border">{{ $user->role->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border">
                            <div class="flex space-x-2">
                                @if ($user->role->is_super != 1) <!-- Check if user is not a Super Admin -->
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md text-sm transition">Edit</a>
                                    <button onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')" 
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                                @else
                                    <a href="#" 
                                       class="bg-blue-500 text-white py-1 px-3 rounded-md text-sm transition cursor-not-allowed opacity-50" 
                                       disabled>Edit</a> <!-- Disabled Edit button -->
                                    <button type="button" 
                                            class="bg-red-500 text-white px-3 py-1 rounded cursor-not-allowed opacity-50" 
                                            disabled>Delete</button> <!-- Disabled Delete button -->
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 px-4 py-6">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded p-6 shadow-lg w-96">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Are you sure you want to delete this user?</h3>
        <p id="userName" class="text-gray-600 mb-2"></p>
        <p id="userEmail" class="text-gray-600 mb-4"></p>
        <form id="deleteForm" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-4">
                <button type="button" id="closeModalBtn" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(userId, userName, userEmail) {
        // Set the action URL for the delete form dynamically
        let deleteUrl = '/admin/users/' + userId;
        $('#deleteForm').attr('action', deleteUrl);

        // Set the user's name and email in the modal
        $('#userName').text("Name: " + userName);
        $('#userEmail').text("Email: " + userEmail);

        // Show the modal
        $('#deleteModal').removeClass('hidden');
    }

    function closeDeleteModal() {
        // Hide the modal
        $('#deleteModal').addClass('hidden');
    }

    // jQuery click event for closing the modal
    $('#closeModalBtn').on('click', function() {
        closeDeleteModal();
    });
</script>
@endsection
