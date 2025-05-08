@extends('layouts.admin')
@section('title', 'Edit Intern')
@section('heading', 'Edit Intern Details')
@section('content')
<div class="max-w-xl mx-auto bg-white shadow-md rounded-2xl p-8 mt-6">
    <form id="edit-intern-form" action="{{ route('admin.interns.update', $intern->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2" for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $intern->name) }}" 
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('name')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2" for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $intern->email) }}" 
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('email')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2" for="password">Password</label>
            <input type="password" name="password" id="password"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Leave blank to keep current password">
            @error('password')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.interns.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg mr-2">
                Cancel
            </a>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg">
                Update Intern
            </button>
        </div>
    </form>
</div>


<script>
    $(document).ready(function() {
        $('#edit-intern-form').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    minlength: 6
                }
            },
            messages: {
                name: {
                    required: "Please enter the intern's name",
                    minlength: "Name must be at least 2 characters"
                },
                email: {
                    required: "Please enter an email",
                    email: "Please enter a valid email address"
                },
                password: {
                    minlength: "Password must be at least 6 characters"
                }
            },
            errorElement: 'span',
            errorClass: 'text-sm text-red-500',
            highlight: function(element) {
                $(element).addClass('border-red-500');
            },
            unhighlight: function(element) {
                $(element).removeClass('border-red-500');
            }
        });
    });
</script>
@endsection
