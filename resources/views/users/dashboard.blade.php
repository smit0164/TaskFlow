@extends('layouts.intern')

@section('title', 'Intern Dashboard')
@section('heading', 'My Assigned Tasks')

@section('content')
    @if($tasks->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tasks as $task)
                <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500 hover:shadow-lg transition-all">
                    <h2 class="text-lg font-semibold text-blue-600">{{ $task->title }}</h2>
                    <p class="text-sm text-gray-600 mt-2">{{ $task->description }}</p>

                    <div class="mt-4 text-sm text-gray-500">
                        Created By: <span class="font-medium"> {{ $task->createdBy ? $task->createdBy->name : 'No Admin Found' }}</span>
                    </div>

                    <div class="mt-2 flex justify-end">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">Task ID: {{ $task->id }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">You have no assigned tasks at the moment.</p>
    @endif
@endsection
