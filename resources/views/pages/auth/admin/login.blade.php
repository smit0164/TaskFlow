<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TaskFlow – Admin Login</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
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
        <form method="POST" action="{{ route('admin.login') }}" id="adminLoginForm">
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
    <script>
    $(document).ready(function () {
        $('#adminLoginForm').validate({
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
                    email: "Enter a valid email address"
                },
                password: {
                    required: "Please enter your password",
                }
            },
            errorElement: 'div',
            errorPlacement: function (error, element) {
                error.addClass('text-red-500 text-sm');
                error.insertAfter(element);
            },
            highlight: function (element) {
                $(element)
                    .addClass('border-red-500 ')
                    .removeClass('border-gray-300 ');
            },
            unhighlight: function (element) {
                $(element)
                    .removeClass('border-red-500 ')
                    .addClass('border-gray-300');
            }
        });
    });
</script>

</body>
</html>
