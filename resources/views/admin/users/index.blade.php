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
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Role</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                    <tr class="border-t">
                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                        <td class="px-4 py-2 border">{{ $user->role->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>

                                <!-- Trigger for Delete Modal -->
                                <button onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
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

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded p-6 shadow-lg w-96">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Are you sure you want to delete this user?</h3>
        <p id="userName" class="text-gray-600 mb-2"></p>
        <p id="userEmail" class="text-gray-600 mb-4"></p>
        <form id="deleteForm" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeDeleteModal()" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(userId, userName, userEmail) {
        // Set the action URL for the delete form dynamically
        var deleteUrl = '/admin/users/' + userId;
        document.getElementById('deleteForm').action = deleteUrl;

        // Set the user's name and email in the modal
        document.getElementById('userName').innerText = "Name: " + userName;
        document.getElementById('userEmail').innerText = "Email: " + userEmail;

        // Show the modal
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        // Hide the modal
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
