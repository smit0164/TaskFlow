<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <nav class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl">TaskFlow User</h1>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('intern.logout') }}">
                @csrf
                <button type="submit" class="bg-green-800 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar for user -->
        <div class="w-1/4 bg-green-200 p-4">
            <ul>
                <li><a href="" class="text-green-800">Dashboard</a></li>
                <li><a href="#" class="text-green-800">My Tasks</a></li>
                <li><a href="#" class="text-green-800">Profile</a></li>
            </ul>
        </div>

        <main class="flex-grow">
            <div class="container mx-auto p-4">
                <h2 class="text-3xl font-bold text-gray-800">User Dashboard</h2>
                <p class="mt-4 text-gray-600">Welcome to your User Dashboard!</p>

                <div class="mt-8 bg-white p-6 shadow rounded-lg">
                    <h2 class="text-xl font-semibold">Your Tasks</h2>
                    <p class="text-gray-600">View the tasks you have been assigned.</p>
                    <a href="#" class="mt-4 inline-block bg-green-600 text-white py-2 px-4 rounded">View Tasks</a>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
