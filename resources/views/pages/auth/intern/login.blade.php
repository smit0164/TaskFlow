@extends('layouts.intern')

@section('title', 'TaskFlow – Intern Login')
@section('heading', 'Intern Login')

@section('content')
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 text-center text-indigo-600">TaskFlow – Intern Login</h1>
            @if (session('error'))
                <div class="mb-4 max-w-xl mx-auto px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-md">
                        <span class="text-sm font-medium">
                            {{ session('error') }}
                        </span>
                </div>
            @endif


            <form method="POST" action="{{ route('intern.login.submit') }}" id="internLoginForm">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('email')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-6 relative">
                    <label for="password" class="block text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 pr-10">
                    <i class="fas fa-eye absolute right-3 top-10 text-gray-600 cursor-pointer toggle-password"></i>
                    @error('password')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">Login</button>
            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('intern.register') }}" class="text-indigo-600 hover:underline">Register here</a>
            </p>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#internLoginForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please enter your password",
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

            // Password visibility toggle
            $('.toggle-password').click(function () {
                var passwordInput = $('#password');
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