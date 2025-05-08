@extends('layouts.admin')
@section('title', 'Edit User')
@section('heading', 'Edit User')

@section('content')
<div class="max-w-xl mx-auto mt-8 bg-white p-6 rounded shadow">
    <form id="edit-user-form" method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded px-3 py-2">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded px-3 py-2">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label>Password <small>(Leave blank if not changing)</small></label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label>Role</label>
            <select name="role_id" class="w-full border rounded px-3 py-2" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end items-center space-x-4 mt-6">
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-red-500 transition font-medium">
                Cancel
            </a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-md transition">
                Update User
            </button>
        </div>
    </form>
</div>



<script>
   $(document).ready(function() {
    $("#edit-user-form").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            password: {
                minlength: 6,
                checkPassword: function() {
                    return $('[name="password"]').val() !== "";
                }
            },
            password_confirmation: {
                minlength: 6,
                equalTo: "[name='password']", // Use the correct selector here
                required: function() {
                    return $('[name="password"]').val() !== "";
                }
            },
            role_id: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Name is required",
                minlength: "Name must be at least 3 characters long"
            },
            email: {
                required: "Email is required",
                email: "Please enter a valid email address"
            },
            password: {
                minlength: "Password must be at least 6 characters long"
            },
            password_confirmation: {
                minlength: "Password confirmation must be at least 6 characters long",
                equalTo: "Password confirmation does not match",
                required: "Password confirmation is required when updating the password"
            },
            role_id: {
                required: "Please select a role"
            }
        },
        errorClass: "text-red-500 text-sm mt-1",  // Error message styling
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass("border-red-500").removeClass("border-green-500"); // Highlight the input field with red border
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("border-red-500").addClass("border-green-500"); // Remove red border and add green border
        }
    });

    // Custom method to check password if it's being updated
    $.validator.addMethod("checkPassword", function(value, element) {
        // If password is not empty, it must be at least 6 characters
        if ($(element).val() !== "") {
            return value.length >= 6;
        }
        return true; // Don't require password if not changing
    });
});

</script>

@endsection
