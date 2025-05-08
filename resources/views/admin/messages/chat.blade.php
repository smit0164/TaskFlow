@extends('layouts.admin')

@section('title', 'Chat')
@section('heading', 'Chat with intern')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl sm:text-3xl font-semibold text-gray-900">Chat with <span class="text-blue-600">{{ $intern->name }}</span></h1>
        <a href="{{ route('admin.messages.index') }}"
           class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition duration-150 ease-in-out">
            ← Back to Messages
        </a>
    </div>

    <!-- Intern Details -->
    <div class="bg-white border border-gray-200 shadow-sm rounded-lg p-5 mb-6">
        <div class="text-gray-800 font-medium mb-1">Intern Details</div>
        <p class="text-gray-700 text-sm"><strong>Name:</strong> {{ $intern->name }}</p>
        <p class="text-gray-700 text-sm"><strong>Email:</strong> {{ $intern->email }}</p>
    </div>

    <!-- Chat Box -->
    <div id="chat-box"
         class="bg-gray-50 border border-gray-200 rounded-lg p-4 h-[500px] overflow-y-auto space-y-2 mb-6 shadow-sm">
        <!-- Messages will be rendered here -->
    </div>

    <!-- Message Form -->
    <form id="messageForm"
          action="{{ route('admin.messages.store') }}"
          method="POST"
          class="flex items-end gap-2"
          data-admin-id="{{ auth()->guard('admin')->id() }}"
          data-intern-id="{{ $intern->id }}">

        @csrf
        <input type="hidden" name="admin_id" value="{{ auth()->guard('admin')->id() }}">
        <input type="hidden" name="intern_id" value="{{ $intern->id }}">
        <input type="hidden" name="sender_type" value="admin">

       
        <input type="text" 
            name="message"
            id="messageInput"
            rows="1"
            placeholder="Type your message..."
            class=" w-full resize-none px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm bg-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all"
        />
        

        <button type="submit"
                id="sendButton"
                class="bg-blue-600 text-white px-4 py-2 text-sm font-medium rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition">
            Send
        </button>
    </form>
</div>

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
                            <div class="flex ${isAdmin ? 'justify-end' : 'justify-start'} animate-fade-in">
                                <div class="${isAdmin ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'} px-4 py-2 rounded-lg max-w-xs sm:max-w-md shadow-sm">
                                    <p class="text-sm">${message.message}</p>
                                    <p class="text-[11px] ${isAdmin ? 'text-blue-200' : 'text-gray-500'} text-right mt-1">${message.time}</p>
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
                $messageInput.css('height', 'auto');
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
