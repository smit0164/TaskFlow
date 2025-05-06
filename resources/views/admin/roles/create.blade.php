<!-- resources/views/admin/role/create.blade.php -->

@extends('layouts.admin')
@section('title', 'Add Roles')
@section('heading', 'Add New Roles')

@section('content')
    <div class="container mx-auto mt-8">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Create New Role</h2>

            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf

                <!-- Role Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                    <input type="text" name="name" id="name"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                           value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Super Admin Checkbox -->
                <div class="mb-4">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="is_super" name="is_super" value="1"
                               class="form-checkbox text-blue-600">
                        <span class="text-sm text-gray-700 font-medium">Super Admin (has all permissions)</span>
                    </label>
                </div>

                <!-- Permissions -->
                <div class="mb-4" id="permissions-section">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>

                    <!-- Select All Checkbox -->
                    <div class="flex items-center mb-2">
                        <input type="checkbox" id="select-all" class="mr-2">
                        <label for="select-all" class="text-sm font-semibold text-gray-700">Select All</label>
                    </div>

                    <div class="space-y-2">
                        @foreach($permissions as $permission)
                            <div class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                       class="permission-checkbox mr-2" id="permission-{{ $permission->id }}">
                                <label for="permission-{{ $permission->id }}" class="text-sm">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('permissions')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.roles.index') }}"
                       class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring focus:ring-gray-200">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200">
                        Create Role
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JavaScript for Select All and Super Admin Toggle --}}
    <script>
        document.getElementById('select-all').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });

        document.getElementById('is_super').addEventListener('change', function () {
            const permissionSection = document.getElementById('permissions-section');
            permissionSection.style.display = this.checked ? 'none' : 'block';
        });

        // On page load, check if super admin was previously checked (e.g., after validation error)
        window.addEventListener('DOMContentLoaded', () => {
            if (document.getElementById('is_super').checked) {
                document.getElementById('permissions-section').style.display = 'none';
            }
        });
    </script>
@endsection
