@extends('layouts.intern')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Chat with {{ $admin->name }}</h1>
        <a href="{{ route('intern.dashbaord')}}" class="text-blue-600 hover:underline">Back to Dashboard</a>
    </div>

    <!-- Admin Details -->
    <div class="bg-white shadow-sm rounded-lg p-4 mb-6">
        <p class="text-lg font-medium text-gray-700">Name: {{ $admin->name }}</p>
        <p class="text-lg text-gray-600">Email: {{ $admin->email }}</p>
    </div>

    <!-- Chat Box -->
    <div id="chat-box" class="bg-white shadow-md rounded-lg p-6 max-h-96 overflow-y-auto mb-4">
        <!-- Messages will be inserted here via AJAX -->
    </div>

    <!-- Message Form -->
    <form id="messageForm" class="flex gap-3">
        @csrf
        <input type="hidden" name="admin_id" value="{{ $admin->id }}">
        <input type="hidden" name="intern_id" value="{{ auth()->guard('intern')->id() }}">
        <input type="hidden" name="sender_type" value="intern">

        <label for="messageInput" class="sr-only">Type your message</label>
        <input type="text" name="message" id="messageInput" placeholder="Type your message..."
               class="flex-1 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">

        <button type="submit" id="sendButton" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition disabled:opacity-50">
            Send
        </button>
    </form>
</div>

<!-- JavaScript for AJAX -->
<script>
    const chatBox = document.getElementById('chat-box');
    const form = document.getElementById('messageForm');
    const sendButton = document.getElementById('sendButton');
    const messageInput = document.getElementById('messageInput');
    const adminId = "{{ $admin->id }}";
    const fetchUrl = "{{ route('intern.messages.fetch', ['admin_id' => $admin->id]) }}";
    const storeUrl = "{{ route('intern.messages.store') }}";

    // Format timestamp as relative time
    function timeAgo(dateString) {
        const now = new Date();
        const messageDate = new Date(dateString);
        const diffInSeconds = Math.floor((now - messageDate) / 1000);

        if (diffInSeconds < 60) {
            return diffInSeconds <= 10 ? 'just now' : `${diffInSeconds} seconds ago`;
        } else if (diffInSeconds < 3600) {
            const minutes = Math.floor(diffInSeconds / 60);
            return `${minutes} minute${minutes === 1 ? '' : 's'} ago`;
        } else if (diffInSeconds < 86400) {
            const hours = Math.floor(diffInSeconds / 3600);
            return `${hours} hour${hours === 1 ? '' : 's'} ago`;
        } else {
            return messageDate.toLocaleString([], { 
                hour: '2-digit', 
                minute: '2-digit', 
                day: '2-digit', 
                month: 'short', 
                year: 'numeric' 
            });
        }
    }

    // Fetch messages
    function fetchMessages() {
        fetch(fetchUrl)
            .then(response => response.json())
            .then(data => {
                chatBox.innerHTML = '';
                data.forEach(message => {
                    const isAdmin = message.sender_type === 'admin';
                    const bubble = `
                        <div class="flex ${isAdmin ?  'justify-start' :'justify-end'} mb-4">
                            <div class="${isAdmin ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'} p-3 rounded-lg max-w-xs sm:max-w-sm">
                                <p>${message.message}</p>
                                <p class="text-xs mt-1 opacity-70">${timeAgo(message.created_at)}</p>
                            </div>
                        </div>`;
                    chatBox.innerHTML += bubble;
                });
                chatBox.scrollTop = chatBox.scrollHeight;
            })
            .catch(error => console.error('Error fetching messages:', error));
    }

    // Initial fetch and periodic polling
    fetchMessages();
    setInterval(fetchMessages, 2000);

    // Submit message via AJAX
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!messageInput.value.trim()) return; // Prevent empty messages

        sendButton.disabled = true;
        const formData = new FormData(form);

        fetch(storeUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            messageInput.value = '';
            sendButton.disabled = false;
            fetchMessages();
        })
        .catch(error => {
            console.error('Error sending message:', error);
            sendButton.disabled = false;
        });
    });

    // Auto-resize input
    messageInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = `${this.scrollHeight}px`;
    });
</script>
@endsection