<!-- Guest Header (for login/register pages) -->
<header class="absolute top-0 left-0 right-0 z-10 px-6 py-4">
    <div class="flex items-center justify-between">
        <a href="/" class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-white bg-opacity-20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                <i class="fas fa-plane text-white text-xl"></i>
            </div>
            <span class="text-2xl font-bold text-white">
                Travellers
            </span>
        </a>
        
        <div class="flex items-center space-x-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-white hover:text-cloud-100 font-medium transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-cloud-100 font-medium transition-colors">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-white text-ocean-600 px-6 py-2 rounded-lg font-medium hover:bg-cloud-50 transition-colors">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</header>
