<div class="w-64 bg-blue-100 p-4 min-h-screen">
    <h3 class="text-lg font-semibold text-blue-900 mb-4">Admin Menu</h3>
    <ul class="space-y-2">
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="block p-2 text-blue-800 hover:bg-blue-200 rounded {{ Route::is('admin.dashboard') ? 'bg-blue-300' : '' }}"
               aria-label="Dashboard">Dashboard</a>
        </li>
        <li>
            <a href="{{ route('admin.tasks.index') }}"
               class="block p-2 text-blue-800 hover:bg-blue-200 rounded {{ Route::is('admin.tasks') ? 'bg-blue-300' : '' }}"
               aria-label="Task Management">Task Management</a>
        </li>
    </ul>
</div>