@extends('layouts.intern')

@section('title', 'TaskFlow – Admin List')
@section('heading', 'Admin List')

@section('content')
    <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-md mx-auto">
        <div class="flex justify-end mb-6">
            <a href="{{ route('intern.dashboard') }}"
               class="text-sm bg-gray-200 text-gray-700 px-3 py-1 rounded-full hover:bg-gray-300 hover:shadow-sm transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
        </div>
        <h1 class="text-2xl font-bold mb-6 text-center text-indigo-600">TaskFlow – Admin List</h1>

        @if (empty($admins))
            <div class="text-gray-600 text-center">No admins found.</div>
        @else
            <div class="space-y-4">
                @foreach ($admins as $admin)
                    <a href="{{ route('intern.message.chat', $admin->id) }}" class="block">
                        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200 hover:bg-gray-100 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center">
                                <i class="fas fa-user-circle text-3xl text-gray-600 mr-4"></i>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">{{ $admin->name }}</h2>
                                    <p class="text-sm text-gray-600">{{ $admin->email }}</p>
                                </div>
                            </div>
                            <i class="fas fa-comments text-xl text-indigo-600"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection