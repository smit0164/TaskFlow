@extends('layouts.admin') {{-- Or your layout --}}

@section('title', 'Access Denied')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen text-center">
    <h1 class="text-4xl font-bold text-red-600 mb-4">403 | Unauthorized</h1>
    <p class="text-gray-700 mb-6">You do not have permission to access this page.</p>
</div>
@endsection
