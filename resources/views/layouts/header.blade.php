<!-- Instagram-style Top Header (visible only on mobile, desktop uses sidebar) -->
<header class="bg-white border-b border-[#DBDBDB] px-4 py-2 md:hidden sticky top-0 z-20">
    <div class="flex items-center justify-between">
        <!-- Logo (mobile) -->
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-gradient-to-tr from-ocean-500 to-grass-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-plane-departure text-white text-sm"></i>
            </div>
            <span class="text-lg font-bold tracking-tight bg-gradient-to-r from-ocean-600 to-grass-600 bg-clip-text text-transparent">
                Travellers
            </span>
        </a>

        <!-- Right actions -->
        <div class="flex items-center space-x-3">
            <button class="relative p-1.5">
                <i class="far fa-heart text-2xl text-gray-800"></i>
            </button>
            <button class="relative p-1.5">
                <i class="far fa-paper-plane text-2xl text-gray-800"></i>
                <span class="absolute top-0.5 right-0.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
            </button>
        </div>
    </div>
</header>

<!-- Desktop Header — search bar only, minimal -->
<header class="hidden md:flex bg-white border-b border-[#DBDBDB] px-6 py-2 items-center justify-between sticky top-0 z-20">
    <!-- Search -->
    <div class="flex-1 max-w-xs">
        <form action="{{ route('users.search') }}" method="GET">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text"
                       name="q"
                       placeholder="Search users..."
                       class="w-full bg-[#EFEFEF] text-sm rounded-lg pl-9 pr-4 py-2
                              border-0 focus:outline-none focus:ring-1 focus:ring-gray-400
                              placeholder-gray-500 transition-all">
            </div>
        </form>
    </div>

    <!-- Right icons (Instagram style) -->
    <div class="flex items-center space-x-4 ml-6">
        <!-- Notifications -->
        <button class="relative p-1 text-gray-800 hover:text-gray-600 transition-colors">
            <i class="far fa-heart text-[26px]"></i>
        </button>

        <!-- Direct Messages -->
        <button class="relative p-1 text-gray-800 hover:text-gray-600 transition-colors">
            <i class="far fa-paper-plane text-[26px]"></i>
            <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-gradient-to-tr from-ocean-500 to-grass-500 rounded-full border-2 border-white"></span>
        </button>

        <!-- Create -->
        <button class="relative p-1 text-gray-800 hover:text-gray-600 transition-colors">
            <i class="far fa-plus-square text-[26px]"></i>
        </button>

        <!-- Profile avatar -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="focus:outline-none">
                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0077B6&color=fff&size=80' }}"
                     alt="Profile"
                     class="w-8 h-8 rounded-full object-cover border border-gray-300">
            </button>

            <!-- Dropdown -->
            <div x-show="open"
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-3 w-56 bg-white border border-[#DBDBDB] rounded-xl shadow-xl py-1 z-50"
                 style="display:none;">

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center px-4 py-2.5 text-sm text-gray-800 hover:bg-gray-50">
                    <i class="far fa-user-circle mr-3 text-lg"></i> Profile
                </a>
                <a href="{{ route('settings') }}"
                   class="flex items-center px-4 py-2.5 text-sm text-gray-800 hover:bg-gray-50">
                    <i class="fas fa-cog mr-3 text-lg"></i> Settings
                </a>
                <a href="{{ route('subscription.plans') }}"
                   class="flex items-center px-4 py-2.5 text-sm text-gray-800 hover:bg-gray-50">
                    <i class="fas fa-crown mr-3 text-lg text-yellow-500"></i> Upgrade Plan
                </a>
                <div class="border-t border-[#DBDBDB] my-1"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left flex items-center px-4 py-2.5 text-sm text-gray-800 hover:bg-gray-50">
                        <i class="fas fa-sign-out-alt mr-3 text-lg"></i> Log out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
