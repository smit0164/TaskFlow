<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'User Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    @vite(['resources/css/app.css','resources/js/app.js', 'resources/js/bootstrap.js'])
</head>
<body class="bg-gray-100 min-h-screen text-gray-900 font-sans antialiased">
    @include('components.intern.navbar')
    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </div>

</body>
</html>