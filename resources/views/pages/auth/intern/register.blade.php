@extends('layouts.intern')
@section('title', 'TaskFlow – Intern Register')
@section('content')
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 text-center text-indigo-600">TaskFlow – Intern Register</h1>

            @if (session('error'))
                <div class="mb-4 text-red-600 text-sm text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('intern.register.submit') }}" id="internRegisterForm">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-6 relative">
                    <label for="password" class="block text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 pr-10">
                    <i class="fas fa-eye absolute right-3 top-10 text-gray-600 cursor-pointer toggle-password" data-target="password"></i>
                    @error('password')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-6 relative">
                    <label for="password_confirmation" class="block text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 pr-10">
                    <i class="fas fa-eye absolute right-3 top-10 text-gray-600 cursor-pointer toggle-password" data-target="password_confirmation"></i>
                    @error('password_confirmation')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">Register</button>
            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('intern.login') }}" class="text-indigo-600 hover:underline">Login here</a>
            </p>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // jQuery Validation for the form
            $('#internRegisterForm').validate({
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
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: '#password'
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name",
                        minlength: "Name must be at least 2 characters"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Enter a valid email address"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Password must be at least 6 characters long"
                    },
                    password_confirmation: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match"
                    }
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass('text-red-500 text-sm mt-1');
                    error.insertAfter(element);
                },
                highlight: function (element) {
                    $(element)
                        .addClass('border-red-500')
                        .removeClass('border-gray-300');
                },
                unhighlight: function (element) {
                    $(element)
                        .removeClass('border-red-500')
                        .addClass('border-gray-300');
                }
            });

            // Password visibility toggle for both fields
            $('.toggle-password').click(function () {
                var targetId = $(this).data('target');
                var passwordInput = $('#' + targetId);
                var icon = $(this);
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
@endsection