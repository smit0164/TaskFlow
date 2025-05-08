<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'User Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src=
"https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous">
    </script>
     <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    @vite(['resources/css/app.css','resources/js/app.js', 'resources/js/bootstrap.js']) {{-- or link to Tailwind CSS --}}
</head>
<body class="bg-gray-100 min-h-screen text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
        <div class="text-xl font-semibold text-blue-600">
            Intern Dashboard
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-700">
                {{ Auth::guard('intern')->user()->email }}
            </span>

            <form method="POST" action="{{ route('intern.logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-600 hover:underline">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Page Heading -->
    <div class="max-w-7xl mx-auto py-6 px-4">
        <h1 class="text-2xl font-bold mb-4">@yield('heading')</h1>

        @yield('content')
    </div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        console.log('Intern layout loaded, Echo status:', window.Echo);
    });
</script>
</body>
</html>
