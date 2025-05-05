<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TaskFlow – Admin Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-indigo-600">TaskFlow – Admin Login</h1>

        <!-- Display session error message -->
        @if (session('error'))
            <div class="mb-4 text-red-600 text-sm text-center">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form for admin login -->
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <!-- Email input field with validation errors -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email"
                       value="{{ old('email') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password input field with validation errors -->
            <div class="mb-6">
                <label for="password" class="block text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Login button -->
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">Login</button>
        </form>

    </div>
</body>
</html>
