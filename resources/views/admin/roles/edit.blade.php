@extends('layouts.admin')
@section('title', 'Edit Role')
@section('heading', 'Edit Role')
@section('content')
    <div class="container mx-auto mt-8">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Edit Role</h2>

            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" id="roleform">
                @csrf
                @method('PUT')

                <!-- Role Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                    <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                           value="{{ old('name', $role->name) }}" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Super Admin Checkbox -->
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="is_super" id="is_super" class="mr-2"
                           {{ old('is_super', $role->is_super) ? 'checked' : '' }}>
                    <label for="is_super" class="text-sm font-medium text-gray-700">Super Admin</label>
                </div>

                <!-- Permissions Section (Will Hide if Super Admin is Selected) -->
                <div class="mb-4" id="permissions-section">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>

                    <div class="space-y-2">
                        @foreach($permissions as $permission)
                            <div class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                       class="permission-checkbox mr-2"
                                       id="permission-{{ $permission->id }}"
                                       {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }}
                                       {{ old('is_super', $role->is_super) ? 'disabled' : '' }}>
                                <label for="permission-{{ $permission->id }}" class="text-sm">{{ $permission->name }}</label>
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
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        // jQuery Validate
        $("#roleform").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                "permissions[]": {
                    required: function () {
                        return !$('#is_super').is(":checked");
                    }
                }
            },
            messages: {
                name: {
                    required: "Role name is required.",
                    minlength: "Role name must be at least 3 characters."
                },
                "permissions[]": {
                    required: "Please select at least one permission or mark as Super Admin."
                }
            },
            errorClass: "text-red-500 text-sm mt-1",
            errorElement: "div",
            errorPlacement: function(error, element) {
                if (element.attr("name") === "permissions[]") {
                    error.insertAfter($("#is_super").closest('div.mb-4'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element) {
                $(element).addClass("border-red-500");
            },
            unhighlight: function (element) {
                $(element).removeClass("border-red-500");
            }
        });

        // Toggle permission section on Super Admin checkbox change
       $('#is_super').change(function () {
            if (this.checked) {
                $("input[name='permissions[]']").prop('checked', false);
                $("input[name='permissions[]']").prop('disabled', true);
            } else {
                $("input[name='permissions[]']").prop('disabled', false);
            }
        });
    });
</script>
 
@endsection
