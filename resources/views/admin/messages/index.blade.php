@extends('layouts.admin')
@section('title', 'Messages')
@section('heading', 'Chat Management')
@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold mb-6">Interns List</h1>
    
    <!-- Intern List Section -->
    <div id="intern-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($interns as $intern)
            <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center hover:bg-gray-100 transition cursor-pointer intern-card"
                 data-intern-id="{{ $intern->id }}" data-intern-name="{{ $intern->name }}">
                <!-- Fake Profile SVG Image -->
                <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-14 h-14 text-gray-500">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-6 2.69-6 6v2h12v-2c0-3.31-2.69-6-6-6z"></path>
                    </svg>
                </div>
                
                <!-- Intern Name -->
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $intern->name }}</h3>
                
                <!-- Chat Button -->
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none">
                    <a href="{{ route('admin.messages.chat', $intern->id) }}">Chat</a>
                </button>
            </div>
        @endforeach
    </div>
</div>
@endsection
