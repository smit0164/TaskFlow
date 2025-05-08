@extends('layouts.intern')

@section('title', 'TaskFlow – Chat with Admin')
@section('heading', 'Chat with Admin')

@section('content')
<div class="w-full max-w-xl mx-auto px-4 py-8 min-h-screen flex flex-col">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-indigo-700 flex items-center">
            <i class="fas fa-comments mr-2 text-indigo-600"></i>
            Chat with {{ $admin->name }}
        </h1>
        <a href="{{ route('intern.getAdmins') }}"
           class="text-sm bg-gray-200 text-gray-700 px-3 py-1 rounded-full hover:bg-gray-300 hover:shadow-sm transition duration-200 flex items-center">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <!-- Admin Details -->
    <div class="bg-white border border-gray-200 shadow-md rounded-xl p-4 mb-6">
        <div class="flex items-center border-b border-indigo-100 pb-2 mb-2">
            <i class="fas fa-user-circle text-3xl text-indigo-600 mr-3"></i>
            <h2 class="text-lg font-semibold text-gray-800">Admin Details</h2>
        </div>
        <p class="text-sm text-gray-700">Name: <span class="font-medium">{{ $admin->name }}</span></p>
        <p class="text-sm text-gray-700">Email: <span class="font-medium">{{ $admin->email }}</span></p>
    </div>

    <!-- Chat Messages Box -->
    <div id="chat-box"
         class="bg-gradient-to-b from-gray-50 to-gray-100 shadow-inner border border-gray-200 rounded-xl p-6 overflow-y-auto flex-1 mb-4 space-y-4 max-h-[500px]">
        <!-- Messages will be dynamically loaded here -->
    </div>

    <!-- Message Input -->
    <form id="messageForm"
          action="{{ route('intern.messages.store') }}"
          method="POST"
          class="bg-white shadow-md rounded-full border border-gray-200 px-4 py-3 flex items-center gap-3 sticky bottom-0"
          data-admin-id="{{ $admin->id }}"
          data-intern-id="{{ auth()->guard('intern')->id() }}">
        @csrf
        <input type="hidden" name="admin_id" value="{{ $admin->id }}">
        <input type="hidden" name="intern_id" value="{{ auth()->guard('intern')->id() }}">
        <input type="hidden" name="sender_type" value="intern">

        <input type="text" name="message" id="messageInput"
               placeholder="Type your message..."
               class="flex-1 bg-white text-gray-800 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"/>

        <button type="submit" id="sendButton"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full transition focus:ring-2 focus:ring-indigo-500 disabled:opacity-50 hover:scale-105 transform">
            <i class="fas fa-paper-plane"></i>
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
                            <div class="flex ${isIntern ? 'justify-end' : 'justify-start'} mb-4 animate-fade">
                                <div class="${isIntern ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-800'} p-3 rounded-lg max-w-xs sm:max-w-sm">
                                    <p>${message.message}</p>
                                    <p class="text-[11px] ${isIntern ? 'text-indigo-200' : 'text-gray-500'} text-right mt-1">${message.time}</p>
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