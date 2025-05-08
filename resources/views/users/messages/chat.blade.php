@extends('layouts.intern')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl min-h-screen flex flex-col">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Chat with {{ $admin->name }}</h1>
        <a href="{{ route('intern.dashboard') }}" class="text-sm text-blue-600 hover:underline">← Back to Dashboard</a>
    </div>

    <!-- Admin Details -->
    <div class="bg-white border border-gray-200 shadow rounded-lg p-4 mb-6">
        <p class="text-lg font-semibold text-gray-800">Name: <span class="font-normal">{{ $admin->name }}</span></p>
        <p class="text-lg font-semibold text-gray-800">Email: <span class="font-normal">{{ $admin->email }}</span></p>
    </div>

    <!-- Chat Messages Box -->
    <div id="chat-box" class="bg-gray-50 shadow-inner border border-gray-200 rounded-lg p-4 overflow-y-auto flex-1 mb-4 space-y-3 max-h-[400px]">
        <!-- Messages will be dynamically loaded here -->
    </div>

    <!-- Message Input -->
    <form id="messageForm"
          action="{{ route('intern.messages.store') }}"
          method="POST"
          class="bg-white shadow-lg rounded-lg border border-gray-200 px-4 py-3 flex items-center gap-3 sticky bottom-0"
          data-admin-id="{{ $admin->id }}"
          data-intern-id="{{ auth()->guard('intern')->id() }}">
        @csrf
        <input type="hidden" name="admin_id" value="{{ $admin->id }}">
        <input type="hidden" name="intern_id" value="{{ auth()->guard('intern')->id() }}">
        <input type="hidden" name="sender_type" value="intern">

        <input type="text" name="message" id="messageInput"
               placeholder="Type your message..."
               class="flex-1 bg-gray-100 text-gray-800 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"/>

        <button type="submit" id="sendButton"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full transition focus:ring-2 focus:ring-blue-500 disabled:opacity-50">
            Send
        </button>
    </form>
</div>


<!-- JavaScript for AJAX and Broadcasting -->
<script>
$(document).ready(function () {
    console.log('intern-chat.js is running, window.Echo:', window.Echo);

    if (!window.Echo) {
        console.error('window.Echo is undefined. Ensure echo.js initializes Echo.');
        return;
    }

    const $chatBox = $('#chat-box');
    const $form = $('#messageForm');
    const $sendButton = $('#sendButton');
    const $messageInput = $('#messageInput');

    if (!$chatBox.length || !$form.length || !$sendButton.length || !$messageInput.length) {
        console.error('DOM elements missing:', {
            chatBox: $chatBox[0],
            form: $form[0],
            sendButton: $sendButton[0],
            messageInput: $messageInput[0]
        });
        return;
    }

    const adminId = $form.data('admin-id');
    const internId = $form.data('intern-id');

    // Fetch messages
    function fetchMessages() {
        console.log('Fetching messages for adminId:', adminId, 'internId:', internId);

        $.ajax({
            url: `/intern/messages/fetch?admin_id=${adminId}&intern_id=${internId}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (data) {
                console.log('Fetch response:', data);
                if (data.success && data.messages) {
                    $chatBox.empty();
                    data.messages.forEach(function (message) {
                        const isIntern = message.sender_type === 'intern';
                        const bubble = `
                            <div class="flex ${isIntern ? 'justify-end' : 'justify-start'} mb-4">
                                <div class="${isIntern ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'} p-3 rounded-lg max-w-xs sm:max-w-sm">
                                    <p>${message.message}</p>
                                    <p class="text-[11px] ${isIntern ? 'text-blue-200' : 'text-gray-500'} text-right mt-1">${message.time}</p>
                                </div>
                            </div>`;
                        $chatBox.append(bubble);
                    });
                    $chatBox.scrollTop($chatBox[0].scrollHeight);
                } else {
                    console.warn('No messages or unsuccessful response:', data);
                }
            },
            error: function (error) {
                console.error('Error fetching messages:', error);
            }
        });
    }

    // Submit message via AJAX
    $form.on('submit', function (e) {
        e.preventDefault();
        if (!$messageInput.val().trim()) return;

        $sendButton.prop('disabled', true);

        const formData = new FormData(this);

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                $messageInput.val('');
                $sendButton.prop('disabled', false);
                fetchMessages();
            },
            error: function (error) {
                console.error('Error sending message:', error);
                $sendButton.prop('disabled', false);
            }
        });
    });

    // Real-time message listener
    const channelName = `private-chat.admin-${adminId}.intern-${internId}`;
    console.log('Setting up listener for channel INTERN: ', channelName);

    window.Echo.private(channelName)
        .listen('.MessageSent', function (e) {
            console.log("Message received event triggered:", e);
            fetchMessages();
        })
        .error(function (error) {
            console.error("Echo error:", error);
        });

    // Auto-resize input
    $messageInput.on('input', function () {
        this.style.height = 'auto';
        this.style.height = `${this.scrollHeight}px`;
    });

    // Initial fetch
    fetchMessages();
});
</script>

@endsection