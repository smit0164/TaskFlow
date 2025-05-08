<nav class="bg-white shadow-xl py-4 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="text-2xl font-extrabold text-blue-600 tracking-tight flex items-center">
                <i class="fas fa-user-graduate mr-2 text-blue-600"></i> <!-- Icon for Intern Dashboard -->
                Intern Panel
            </div>
            <div class="flex items-center gap-4">
                @if (Auth::guard('intern')->check())
                    <span class="text-sm text-gray-600 font-medium hidden sm:block flex items-center">
                        <i class="fas fa-user-circle mr-2 text-gray-600"></i> <!-- Profile icon -->
                        {{ Auth::guard('intern')->user()->email }}
                    </span>
                    <a href="{{route('intern.getAdmins')}}" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 flex items-center">
                        <i class="fas fa-comments mr-2"></i> <!-- Chat icon -->
                        Chat with Admin
                    </a>
                    <form method="POST" action="{{ route('intern.logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i> <!-- Logout icon -->
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('intern.login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center">
                        <i class="fas fa-sign-in-alt mr-2"></i> <!-- Login icon -->
                        Login
                    </a>
                    <a href="{{ route('intern.register') }}" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-900 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 flex items-center">
                        <i class="fas fa-user-plus mr-2"></i> <!-- Sign Up icon -->
                        Sign Up
                    </a>
                @endif
            </div>
        </div>
</nav>