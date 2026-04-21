<!-- Instagram-style Sidebar Navigation -->
<aside id="sidebar" class="fixed left-0 top-0 h-full bg-white border-r border-[#DBDBDB] z-30
    w-16 xl:w-[244px]
    transform -translate-x-full md:translate-x-0
    transition-all duration-200 ease-in-out">

    <!-- Logo -->
    <div class="p-3 xl:p-6 mb-2 xl:mb-0">
        <a href="{{ route('dashboard') }}" class="flex items-center xl:space-x-2 h-12">
            <!-- Icon only on small screens -->
            <div class="w-10 h-10 bg-gradient-to-tr from-ocean-500 via-cloud-300 to-grass-500 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-plane-departure text-white text-base"></i>
            </div>
            <!-- Text only on xl -->
            <span class="hidden xl:block text-xl font-bold tracking-tight bg-gradient-to-r from-ocean-600 to-grass-600 bg-clip-text text-transparent ml-2 whitespace-nowrap">
                Travellers
            </span>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="px-2 xl:px-3 space-y-1 pb-24">

        {{-- Helper macro for nav links --}}
        @php
            $navItem = function(string $route, string $icon, string $label, string $routePattern) {
                $active = request()->routeIs($routePattern);
                return [
                    'href'    => route($route),
                    'icon'    => $icon,
                    'label'   => $label,
                    'active'  => $active,
                ];
            };

            $links = [
                ['href' => route('dashboard'),          'icon' => 'fas fa-home',            'label' => 'Home',        'active' => request()->routeIs('dashboard')],
                ['href' => route('social.wall'),        'icon' => 'fas fa-compass',         'label' => 'Explore',     'active' => request()->routeIs('social.wall')],
                ['href' => route('social.reels'),       'icon' => 'fas fa-film',            'label' => 'Reels',       'active' => request()->routeIs('social.reels')],
                ['href' => route('social.stories'),     'icon' => 'fas fa-circle-play',     'label' => 'Stories',     'active' => request()->routeIs('social.stories')],
                ['href' => '#',                         'icon' => 'far fa-paper-plane',     'label' => 'Messages',    'active' => false],
                ['href' => route('memories.index'),     'icon' => 'fas fa-heart',           'label' => 'Memories',    'active' => request()->routeIs('memories.*')],
                ['href' => '#',                         'icon' => 'far fa-plus-square',     'label' => 'Create',      'active' => false],
                ['href' => route('dashboard'),          'icon' => 'far fa-user-circle',     'label' => 'Profile',     'active' => false],
            ];
        @endphp

        @foreach($links as $link)
        <a href="{{ $link['href'] }}"
           class="flex items-center px-3 py-3 rounded-xl transition-all duration-150 group
                  {{ $link['active']
                     ? 'font-bold text-gray-900'
                     : 'font-normal text-gray-700 hover:bg-gray-100' }}">
            <span class="flex-shrink-0 w-7 flex items-center justify-center">
                <i class="{{ $link['icon'] }} text-[26px] leading-none
                           {{ $link['active'] ? 'text-gray-900' : 'text-gray-700 group-hover:text-gray-900' }}"></i>
            </span>
            <span class="hidden xl:block ml-4 text-[16px] whitespace-nowrap leading-tight
                         {{ $link['active'] ? 'font-semibold text-gray-900' : '' }}">
                {{ $link['label'] }}
            </span>
        </a>
        @endforeach

        <!-- Divider -->
        <div class="border-t border-[#DBDBDB] my-3"></div>

        <!-- More Features -->
        @php
            $toolLinks = [
                ['href' => route('itineraries.index'), 'icon' => 'fas fa-map-marked-alt', 'label' => 'Itineraries', 'active' => request()->routeIs('itineraries.*')],
                ['href' => route('budgets.index'),     'icon' => 'fas fa-wallet',          'label' => 'Budget',      'active' => request()->routeIs('budgets.*')],
                ['href' => route('todos.index'),       'icon' => 'fas fa-check-square',    'label' => 'To-Do',       'active' => request()->routeIs('todos.*')],
                ['href' => route('calendar.index'),    'icon' => 'fas fa-calendar-alt',    'label' => 'Calendar',    'active' => request()->routeIs('calendar.*')],
            ];
        @endphp

        @foreach($toolLinks as $link)
        <a href="{{ $link['href'] }}"
           class="flex items-center px-3 py-3 rounded-xl transition-all duration-150 group
                  {{ $link['active']
                     ? 'font-bold text-gray-900'
                     : 'font-normal text-gray-700 hover:bg-gray-100' }}">
            <span class="flex-shrink-0 w-7 flex items-center justify-center">
                <i class="{{ $link['icon'] }} text-[22px] leading-none
                           {{ $link['active'] ? 'text-ocean-600' : 'text-gray-600 group-hover:text-gray-900' }}"></i>
            </span>
            <span class="hidden xl:block ml-4 text-[16px] whitespace-nowrap leading-tight
                         {{ $link['active'] ? 'font-semibold text-ocean-600' : '' }}">
                {{ $link['label'] }}
            </span>
        </a>
        @endforeach

        <!-- Upgrade badge -->
        <a href="{{ route('subscription.plans') }}"
           class="flex items-center px-3 py-3 rounded-xl transition-all duration-150 group hover:bg-gray-100
                  {{ request()->routeIs('subscription.*') ? 'font-bold text-gray-900' : 'font-normal text-gray-700' }}">
            <span class="flex-shrink-0 w-7 flex items-center justify-center relative">
                <i class="fas fa-crown text-[22px] text-yellow-500 group-hover:text-yellow-600"></i>
                @if(auth()->user()->subscription_tier === 'free')
                    <span class="absolute -top-1 -right-1 w-2 h-2 bg-gradient-to-tr from-ocean-500 to-grass-500 rounded-full"></span>
                @endif
            </span>
            <span class="hidden xl:block ml-4 text-[16px] whitespace-nowrap leading-tight">
                Upgrade
                @if(auth()->user()->subscription_tier === 'free')
                    <span class="ml-2 text-xs bg-gradient-to-r from-ocean-500 to-grass-500 text-white px-2 py-0.5 rounded-full">Free</span>
                @endif
            </span>
        </a>
    </nav>

    <!-- User Profile (Bottom) -->
    <div class="absolute bottom-0 left-0 right-0 p-3 xl:p-4 border-t border-[#DBDBDB] bg-white">
        <div class="flex items-center xl:space-x-3 group cursor-pointer" x-data="{ open: false }" @click="open = !open">
            <div class="relative flex-shrink-0">
                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0077B6&color=fff' }}"
                     alt="Profile"
                     class="w-10 h-10 rounded-full object-cover">
            </div>
            <!-- Name + username (xl only) -->
            <div class="hidden xl:flex flex-1 flex-col min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate leading-tight">{{ auth()->user()->username }}</p>
                <p class="text-xs text-gray-500 truncate leading-tight">{{ auth()->user()->name }}</p>
            </div>
            <!-- Logout (xl only) -->
            <form method="POST" action="{{ route('logout') }}" class="hidden xl:block">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-1">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Mobile Menu Button -->
<button id="mobile-menu-button"
        class="md:hidden fixed top-3 left-3 z-40 bg-white border border-gray-200 shadow-sm p-2.5 rounded-xl">
    <i class="fas fa-bars text-gray-800 text-lg"></i>
</button>

<!-- Mobile Overlay -->
<div id="mobile-overlay" class="fixed inset-0 bg-black/40 z-20 hidden md:hidden backdrop-blur-sm"></div>

@push('scripts')
<script>
    const btn = document.getElementById('mobile-menu-button');
    const sb  = document.getElementById('sidebar');
    const ov  = document.getElementById('mobile-overlay');
    if (btn && sb && ov) {
        btn.addEventListener('click', () => {
            sb.classList.toggle('-translate-x-full');
            ov.classList.toggle('hidden');
        });
        ov.addEventListener('click', () => {
            sb.classList.add('-translate-x-full');
            ov.classList.add('hidden');
        });
    }
</script>
@endpush