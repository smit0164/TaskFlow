<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/js/app.js', 'resources/js/bootstrap.js'])
    <script src=
"https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">TaskFlow Admin</h1>
            <div class="flex items-center gap-6">
                <span class="text-sm font-medium">{{ Auth::guard('admin')->user()->email }}</span>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.admin.sidebar')

        <!-- Main content -->
        <main class="flex-grow p-8">
            <h2 class="text-3xl font-bold mb-6">@yield('heading')</h2>
            @yield('content')
        </main>
    </div>
</body>
</html>