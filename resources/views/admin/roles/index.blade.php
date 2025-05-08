@extends('layouts.admin')
@section('title', 'Roles')
@section('heading', 'Roles Management')

@section('content')
    <div class="container mx-auto mt-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">All Roles</h2>
            <a href="{{ route('admin.roles.create') }}"
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Create Role
            </a>
        </div>

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Role Name</th>
                        <th class="px-4 py-2 border">Permissions</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $index => $role)
                        <tr class="border-t">
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border font-medium">
                                {{ $role->name }}
                                @if($role->is_super)
                                    <span class="ml-2 px-2 py-1 text-xs text-white bg-green-600 rounded-full">Super Admin</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border">
                                @if($role->is_super)
                                    <span class="text-sm text-gray-600 italic">All permissions granted</span>
                                @elseif($role->permissions->count())
                                    <ul class="list-disc list-inside text-sm text-gray-700">
                                        @foreach($role->permissions as $permission)
                                            <li>{{ $permission->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-500">No permissions assigned</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                       class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    
                                    <!-- Delete Button -->
                                    <button type="button"
                                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                                            onclick="openDeleteModal({{ $role->id }}, '{{ $role->name }}')">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-5 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center top-0 left-0 bottom-0 right-0 z-50 ">
    <div class="bg-white rounded-lg p-6 max-w-lg mx-auto">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Are you sure you want to delete this roleawdwad?</h3>
        <p id="role-name" class="text-lg text-gray-800 mb-4"></p>

        <div class="flex justify-end space-x-4">
            <button type="button" onclick="closeDeleteModal()"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                Cancel
            </button>
            <form id="delete-form" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript for Modal --}}
<script>
    function openDeleteModal(roleId, roleName) {
        $('#role-name').text('Role: ' + roleName);
        $('#delete-form').attr('action', '/admin/roles/' + roleId);
        $('#delete-modal').fadeIn();
    }

    function closeDeleteModal() {
        $('#delete-modal').fadeOut();
    }

    // Optional: Close modal on background click
    $(document).on('click', function(e) {
        if ($(e.target).is('#delete-modal')) {
            closeDeleteModal();
        }
    });
</script>



@endsection
