@extends('layouts.admin')

@section('title', 'TaskFlow – Chat with Intern')
@section('heading', 'Chat with Intern')

@section('content')
<div class="w-full max-w-xl mx-auto  min-h-screen flex flex-col">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-indigo-700 flex items-center">
            <i class="fas fa-comments mr-2 text-indigo-600"></i>
            Chat with {{ $intern->name }}
        </h1>
        <a href="{{ route('admin.messages.index') }}"
           class="text-sm bg-gray-200 text-gray-700 px-3 py-1 rounded-full hover:bg-gray-300 hover:shadow-sm transition duration-200 flex items-center">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <!-- Intern Details -->
    <div class="bg-white border border-gray-200 shadow-md rounded-xl p-4 mb-6">
        <div class="flex items-center border-b border-indigo-100 pb-2 mb-2">
            <i class="fas fa-user-circle text-3xl text-indigo-600 mr-3"></i>
            <h2 class="text-lg font-semibold text-gray-800">Intern Details</h2>
        </div>
        <p class="text-sm text-gray-700">Name: <span class="font-medium">{{ $intern->name }}</span></p>
        <p class="text-sm text-gray-700">Email: <span class="font-medium">{{ $intern->email }}</span></p>
    </div>

    <!-- Chat Messages Box -->
    <div id="chat-box"
         class="bg-gradient-to-b from-gray-50 to-gray-100 shadow-inner border border-gray-200 rounded-xl p-6 overflow-y-auto flex-1 mb-4 space-y-4 max-h-[500px]">
        <!-- Messages will be rendered here -->
    </div>

    <!-- Message Form -->
    <form id="messageForm"
          action="{{ route('admin.messages.store') }}"
          method="POST"
          class="bg-white shadow-md rounded-full border border-gray-200 px-4 py-3 flex items-center gap-3 sticky bottom-0"
          data-admin-id="{{ auth()->guard('admin')->id() }}"
          data-intern-id="{{ $intern->id }}">

        @csrf
        <input type="hidden" name="admin_id" value="{{ auth()->guard('admin')->id() }}">
        <input type="hidden" name="intern_id" value="{{ $intern->id }}">
        <input type="hidden" name="sender_type" value="admin">

        <input type="text" name="message" id="messageInput"
               placeholder="Type your message..."
               class="flex-1 bg-white text-gray-800 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"/>

        <button type="submit" id="sendButton"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full transition focus:ring-2 focus:ring-indigo-500 disabled:opacity-50 hover:scale-105 transform">
            <i class="fas fa-paper-plane"></i>
        </button>
    </form>
</div>

<style>
    /* Fade animation for messages */
    .animate-fade {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
$(document).ready(function () {
    const $chatBox = $('#chat-box');
    const $form = $('#messageForm');
    const $sendButton = $('#sendButton');
    const $messageInput = $('#messageInput');

    if (!$chatBox.length || !$form.length || !$sendButton.length || !$messageInput.length) return;

    const adminId = $form.data('admin-id');
    const internId = $form.data('intern-id');

    function fetchMessages() {
        $.ajax({
            url: `/admin/messages/fetch?admin_id=${adminId}&intern_id=${internId}`,
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (data) {
                if (data.success && data.messages) {
                    $chatBox.empty();
                    data.messages.forEach(function (message) {
                        const isAdmin = message.sender_type === 'admin';
                        const bubble = `
                            <div class="flex ${isAdmin ? 'justify-end' : 'justify-start'} mb-4 animate-fade">
                                <div class="${isAdmin ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-800'} p-3 rounded-lg max-w-xs sm:max-w-sm">
                                    <p>${message.message}</p>
                                    <p class="text-[11px] ${isAdmin ? 'text-indigo-200' : 'text-gray-500'} text-right mt-1">${message.time}</p>
                                </div>
                            </div>`;
                        $chatBox.append(bubble);
                    });
                    $chatBox.scrollTop($chatBox[0].scrollHeight);
                }
            },
            error: function (xhr) {
                console.error('Fetch error:', xhr);
            }
        });
    }

    $form.on('submit', function (e) {
        e.preventDefault();
        if (!$messageInput.val().trim()) return;

        $sendButton.prop('disabled', true);

        const formData = new FormData(this);

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                $messageInput.val('');
                $sendButton.prop('disabled', false);
                fetchMessages();
            },
            error: function (err) {
                console.error('Message send failed:', err);
                $sendButton.prop('disabled', false);
            }
        });
    });

    const channel = `private-chat.admin-${adminId}.intern-${internId}`;
    if (window.Echo) {
        window.Echo.private(channel)
            .listen('.MessageSent', fetchMessages)
            .error(console.error);
    }

    fetchMessages();
});
</script>
@endsection