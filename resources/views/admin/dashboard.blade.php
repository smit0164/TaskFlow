<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl">TaskFlow Admin</h1>

            <!-- Logout Form -->
            <form action="{{ route('admin.logout') }}" method="POST" class="inline-block">
                @csrf
                <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded">Logout</button>
            </form>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar for admin -->
        <div class="w-1/4 bg-blue-200 p-4">
            <ul>
                <li><a href="" class="text-blue-800">Dashboard</a></li>
                <li><a href="#" class="text-blue-800">Manage Users</a></li>
                <li><a href="#" class="text-blue-800">Task Management</a></li>
            </ul>
        </div>

        <main class="flex-grow">
            <div class="container mx-auto p-4">
                <h2 class="text-3xl font-bold text-gray-800">Admin Dashboard</h2>
                <p class="mt-4 text-gray-600">Welcome to the Admin Dashboard!</p>

                <div class="mt-8 bg-white p-6 shadow rounded-lg">
                    <h2 class="text-xl font-semibold">Task Management</h2>
                    <p class="text-gray-600">Manage all tasks for the users.</p>
                    <a href="#" class="mt-4 inline-block bg-blue-600 text-white py-2 px-4 rounded">View Tasks</a>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
