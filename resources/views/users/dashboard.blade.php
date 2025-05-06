@extends('layouts.intern')

@section('title', 'Intern Dashboard')
@section('heading', 'My Assigned Tasks')

@section('content')
<div class="max-w-7xl mx-auto py-8">
   
<!-- Show Admins Button -->
<div class="mb-6 text-right">
    <button onclick="fetchAdmins()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
        Chat with Admin
    </button>
</div>

<!-- Admin List Display -->
<div id="adminListContainer" class="hidden mb-6 bg-white p-6 rounded-2xl shadow-md border border-gray-200">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center space-x-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 00-3-3.87M4 21v-2a4 4 0 013-3.87m13-4.13a4 4 0 11-8 0 4 4 0 018 0zM6 10a4 4 0 108 0 4 4 0 00-8 0z" />
            </svg>
            <span>Admin List</span>
        </h3>
        <!-- Cancel Button -->
        <button onclick="toggleAdminList()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
            Cancel
        </button>
    </div>
    <ul id="adminList" class="space-y-3">
        <!-- Admin items will be appended here -->
    </ul>
</div>

    @if($tasks->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tasks as $task)
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-300 flex flex-col">
                    <!-- Task Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $task->title }}</h2>
                        <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-medium">Task ID: {{ $task->id }}</span>
                    </div>

                    <!-- Task Description -->
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ Str::limit($task->description, 150) }}</p>

                    <!-- Created By -->
                    <div class="text-sm text-gray-500 mb-4">
                        <span class="font-medium">Created By:</span>
                        {{ $task->createdBy ? $task->createdBy->name : 'No Admin Found' }}
                    </div>

                    <!-- Comment Form (For Authenticated Interns) -->
                    @if (auth()->guard('intern')->check())
                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <form action="{{ route('intern.comment.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="task_id" value="{{ $task->id }}">
                                <input type="hidden" name="user_type" value="intern">

                                <label for="description_{{ $task->id }}" class="block text-sm font-medium text-gray-700 mb-2">Add a Comment</label>
                                <div class="relative">
                                    <textarea name="description" id="description_{{ $task->id }}" rows="3" placeholder="Write your comment..."
                                        class="w-full p-3 border border-gray-200 rounded-lg text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                        required></textarea>
                                    <svg class="absolute top-3 right-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>

                                @error('description')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror

                                <div class="mt-3 text-right">
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                                        <span>Post Comment</span>
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <!-- Comments Display -->
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center space-x-2">
                            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5v-4a2 2 0 012-2h10a2 2 0 012 2v4h-4m-6 0h6"></path>
                            </svg>
                            <span>Comments</span>
                        </h4>
                        @forelse($task->comments as $comment)
                            <div class="bg-gray-50 p-4 rounded-lg mb-3 border border-gray-100 shadow-sm">
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $comment->description }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-xs text-gray-500">
                                        <span class="font-medium">{{ $comment->commenter ? $comment->commenter->name : 'Deleted User' }}</span>
                                        @if ($comment->isAdminComment())
                                            <span class="inline-block bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full ml-2">Admin</span>
                                        @else
                                            <span class="inline-block bg-gray-600 text-white text-xs px-2 py-0.5 rounded-full ml-2">Intern</span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $comment->created_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic">No comments yet.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm text-center">
            <p class="text-gray-600 text-sm">You have no assigned tasks at the moment.</p>
        </div>
    @endif
</div>

<script>
function fetchAdmins() {
    fetch('{{ route("intern.admins") }}')
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const adminList = document.getElementById('adminList');
            const adminContainer = document.getElementById('adminListContainer');
            adminList.innerHTML = '';

            if (data.length === 0) {
                adminList.innerHTML = '<li>No admins found.</li>';
            } else {
                data.forEach(admin => {
                    const listItem = document.createElement('li');
                    listItem.className = "py-2 flex items-center justify-between text-sm text-gray-700";
                    
                    // Construct the route for the chat button dynamically
                    const chatLink = `/chat/admin/${admin.id}`;

                    listItem.innerHTML = `
                        <span class="font-medium text-gray-800">${admin.name}</span>
                        <span class="text-gray-500">${admin.email}</span>
                        <a href="${chatLink}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm font-medium transition-colors duration-200">
                            Chat
                        </a>
                    `;
                    adminList.appendChild(listItem);
                });
            }

            adminContainer.classList.remove('hidden');
        })
        .catch(error => {
            alert("Failed to load admins.");
            console.error(error);
        });
}

    function toggleAdminList() {
        const adminContainer = document.getElementById('adminListContainer');
        adminContainer.classList.add('hidden');
    }
</script>

@endsection
