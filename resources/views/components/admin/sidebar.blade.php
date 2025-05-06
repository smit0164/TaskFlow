<div class="w-64 bg-white shadow-lg p-5 min-h-screen border-r border-gray-200">
    <h3 class="text-xl font-bold text-blue-900 mb-6">Admin Panel</h3>
    <ul class="space-y-3 text-sm font-medium">
        @can('manage-dashboard')
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center p-2 rounded-lg transition hover:bg-blue-100 {{ Route::is('admin.dashboard') ? 'bg-blue-200 text-blue-900 font-semibold' : 'text-gray-700' }}">
                <span>Dashboard</span>
            </a>
        </li>
        @endcan

        @can('manage-tasks')
        <li>
            <a href="{{ route('admin.tasks.index') }}"
               class="flex items-center p-2 rounded-lg transition hover:bg-blue-100 {{ Route::is('admin.tasks.*') ? 'bg-blue-200 text-blue-900 font-semibold' : 'text-gray-700' }}">
                <span>Task Management</span>
            </a>
        </li>
        @endcan

        @can('manage-interns')
        <li>
            <a href="{{ route('admin.interns.index') }}"
               class="flex items-center p-2 rounded-lg transition hover:bg-blue-100 {{ Route::is('admin.interns.*') ? 'bg-blue-200 text-blue-900 font-semibold' : 'text-gray-700' }}">
                <span>Manage Interns</span>
            </a>
        </li>
        @endcan

        @can('manage-roles')
        <li>
            <a href="{{ route('admin.roles.index') }}"
               class="flex items-center p-2 rounded-lg transition hover:bg-blue-100 {{ Route::is('admin.roles.*') ? 'bg-blue-200 text-blue-900 font-semibold' : 'text-gray-700' }}">
                <span>Manage Roles</span>
            </a>
        </li>
        @endcan

        @can('manage-users')
        <li>
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center p-2 rounded-lg transition hover:bg-blue-100 {{ Route::is('admin.users.*') ? 'bg-blue-200 text-blue-900 font-semibold' : 'text-gray-700' }}">
                <span>Manage Users</span>
            </a>
        </li>
        @endcan
    </ul>
</div>
