<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Travellers') }}</title>

        <!-- Fonts: Instagram uses -apple-system, Segoe UI -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Use Inter like Instagram uses system fonts */
            body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }

            /* Thin scrollbar */
            ::-webkit-scrollbar { width: 4px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #DBDBDB; border-radius: 4px; }

            /* Instagram-style smooth transitions */
            * { -webkit-tap-highlight-color: transparent; }

            /* Like button animation */
            @keyframes likeAnimation {
                0%   { transform: scale(1); }
                50%  { transform: scale(1.3); }
                100% { transform: scale(1); }
            }
            .like-animate { animation: likeAnimation 0.3s ease; }

            /* Gradient story ring */
            .story-ring {
                background: linear-gradient(45deg, #0077B6, #00B4D8, #40916C, #52B788);
            }

            /* Skeleton loading */
            @keyframes skeleton-pulse {
                0%, 100% { opacity: 1; }
                50%       { opacity: 0.5; }
            }
            .skeleton { animation: skeleton-pulse 1.5s ease-in-out infinite; }

            /* Instagram-exact input style */
            .ig-input {
                background-color: #FAFAFA;
                border: 1px solid #DBDBDB;
                border-radius: 5px;
                padding: 10px 12px;
                font-size: 14px;
                outline: none;
                transition: border-color 0.1s;
            }
            .ig-input:focus { border-color: #A8A8A8; }

            /* Instagram blue button */
            .ig-btn {
                background-color: #0095F6;
                color: #fff;
                font-weight: 600;
                font-size: 14px;
                padding: 7px 16px;
                border-radius: 8px;
                transition: background-color 0.1s;
                border: none;
                cursor: pointer;
            }
            .ig-btn:hover { background-color: #1877F2; }
            .ig-btn:disabled { opacity: 0.5; cursor: not-allowed; }

            /* Toast notification */
            .ig-toast {
                position: fixed;
                bottom: 72px;
                left: 50%;
                transform: translateX(-50%);
                background: #262626;
                color: #fff;
                font-size: 13px;
                font-weight: 500;
                padding: 10px 20px;
                border-radius: 8px;
                z-index: 9999;
                opacity: 0;
                transition: opacity 0.25s ease;
                white-space: nowrap;
                pointer-events: none;
            }
            .ig-toast.show { opacity: 1; }

            /* Avatar ring --profile-- */
            .avatar-ring {
                padding: 2px;
                background: linear-gradient(45deg, #0077B6, #00B4D8, #40916C, #52B788);
                border-radius: 50%;
            }
            .avatar-ring img {
                border: 2px solid white;
                border-radius: 50%;
            }

            /* Post card shadow */
            .ig-card {
                background: #fff;
                border: 1px solid #DBDBDB;
                border-radius: 8px;
                overflow: hidden;
            }

            /* Pulse badge */
            @keyframes pulse-badge {
                0%, 100% { box-shadow: 0 0 0 0 rgba(0,149,246,0.4); }
                50%       { box-shadow: 0 0 0 6px rgba(0,149,246,0); }
            }
            .pulse-badge { animation: pulse-badge 2s infinite; }

            /* Story ring hover */
            .story-item:hover .story-ring { filter: brightness(1.1); }

            /* Reels snap */
            .reel-snap { scroll-snap-type: y mandatory; }
            .reel-snap > * { scroll-snap-align: start; }
        </style>
    </head>

    <body class="font-sans antialiased bg-[#FAFAFA]">
        @auth
        <div class="flex h-screen overflow-hidden">

            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main -->
            <div class="flex-1 flex flex-col overflow-hidden ml-0 md:ml-16 xl:ml-[244px] transition-all duration-200">

                <!-- Header -->
                @include('layouts.header')

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto pb-20 md:pb-6">
                    @isset($header)
                        <div class="px-4 md:px-6 py-4 border-b border-[#DBDBDB] bg-white mb-0">
                            {{ $header }}
                        </div>
                    @endisset
                    <div class="px-4 md:px-6 py-4">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Mobile Bottom Navigation (Instagram-style) -->
        <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-[#DBDBDB] z-30 px-2 py-1">
            <div class="flex items-center justify-around">
                <a href="{{ route('dashboard') }}"
                   class="flex flex-col items-center py-2 px-3 {{ request()->routeIs('dashboard') ? 'text-gray-900' : 'text-gray-500' }}">
                    <i class="{{ request()->routeIs('dashboard') ? 'fas' : 'far' }} fa-home text-2xl"></i>
                </a>
                <a href="{{ route('social.wall') }}"
                   class="flex flex-col items-center py-2 px-3 {{ request()->routeIs('social.wall') ? 'text-gray-900' : 'text-gray-500' }}">
                    <i class="fas fa-compass text-2xl"></i>
                </a>
                <!-- Create post button -->
                <button class="flex flex-col items-center py-2 px-3 text-gray-800">
                    <div class="w-8 h-8 border-2 border-gray-800 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus text-sm"></i>
                    </div>
                </button>
                <a href="{{ route('social.reels') }}"
                   class="flex flex-col items-center py-2 px-3 {{ request()->routeIs('social.reels') ? 'text-gray-900' : 'text-gray-500' }}">
                    <i class="fas fa-film text-2xl"></i>
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="flex flex-col items-center py-2 px-3 text-gray-500">
                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=60' }}"
                         class="w-7 h-7 rounded-full object-cover {{ request()->routeIs('profile.*') ? 'ring-2 ring-gray-900' : '' }}">
                </a>
            </div>
        </nav>

        @else
        <!-- Guest layout -->
        <div class="min-h-screen bg-[#FAFAFA] flex flex-col">
            <!-- Guest Header -->
            <header class="bg-white border-b border-[#DBDBDB] px-4 py-3 flex items-center justify-between max-w-5xl mx-auto w-full">
                <a href="/" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-tr from-ocean-500 to-grass-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plane-departure text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-ocean-600 to-grass-600 bg-clip-text text-transparent">
                        Travellers
                    </span>
                </a>
                <div class="flex space-x-3">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-white bg-ocean-500 hover:bg-ocean-600 px-4 py-1.5 rounded-lg transition-colors">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold text-ocean-600 border border-ocean-500 hover:bg-ocean-50 px-4 py-1.5 rounded-lg transition-colors">
                        Sign up
                    </a>
                </div>
            </header>
            <main class="flex-1 flex items-center justify-center p-6">
                {{ $slot }}
            </main>
        </div>
        @endauth

        @stack('scripts')

        <!-- Global Toast Notification -->
        <div id="ig-toast" class="ig-toast"></div>
        <script>
            function showToast(msg, duration = 2500) {
                const el = document.getElementById('ig-toast');
                if (!el) return;
                el.textContent = msg;
                el.classList.add('show');
                setTimeout(() => el.classList.remove('show'), duration);
            }
        </script>
    </body>
</html>
