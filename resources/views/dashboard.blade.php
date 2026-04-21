<x-app-layout>
    <!-- Instagram-style Profile Header -->
    <div class="bg-white border-b border-gray-200 pb-6 mb-6">
        <div class="max-w-4xl mx-auto px-4">
            <div class="flex items-center space-x-6 md:space-x-10">
                <!-- Profile Picture -->
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 md:w-36 md:h-36 rounded-full p-0.5 bg-gradient-to-tr from-ocean-500 via-cloud-300 to-grass-500">
                        <div class="w-full h-full rounded-full p-0.5 bg-white">
                            <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=200' }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="w-full h-full rounded-full object-cover">
                        </div>
                    </div>
                </div>
                
                <!-- Profile Info -->
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-4 mb-4">
                        <h1 class="text-xl md:text-2xl font-light text-gray-900">{{ auth()->user()->username }}</h1>
                        <div class="flex space-x-2">
                            <a href="{{ route('settings') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-900 px-4 py-1.5 rounded-lg text-sm font-semibold transition-colors">
                                Edit Profile
                            </a>
                            <a href="{{ route('settings') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-900 px-2 py-1.5 rounded-lg transition-colors">
                                <i class="fas fa-cog"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Stats -->
                    <div class="flex space-x-6 md:space-x-10 mb-4">
                        <div>
                            <span class="text-xl md:text-2xl font-bold text-gray-900">{{ auth()->user()->itineraries->count() }}</span>
                            <p class="text-sm text-gray-600">trips</p>
                        </div>
                        <div>
                            <span class="text-xl md:text-2xl font-bold text-gray-900">{{ auth()->user()->memories->count() ?? 0 }}</span>
                            <p class="text-sm text-gray-600">memories</p>
                        </div>
                        <div>
                            <span class="text-xl md:text-2xl font-bold text-gray-900">{{ auth()->user()->posts->count() ?? 0 }}</span>
                            <p class="text-sm text-gray-600">posts</p>
                        </div>
                    </div>
                    
                    <!-- Bio -->
                    <div class="hidden md:block">
                        <p class="font-semibold text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-700">{{ auth()->user()->bio ?? '✈️ Travel enthusiast | 🌍 Exploring the world | 📸 Sharing adventures' }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Bio -->
            <div class="md:hidden mt-4">
                <p class="font-semibold text-sm">{{ auth()->user()->name }}</p>
                <p class="text-sm text-gray-700">{{ auth()->user()->bio ?? '✈️ Travel enthusiast | 🌍 Exploring the world' }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4">
        <!-- Quick Actions (Instagram Story-style) -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex justify-around">
                <a href="{{ route('itineraries.create') }}" class="flex flex-col items-center space-y-2 group">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-ocean-500 to-cloud-300 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-plus text-white text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-gray-700">New Trip</span>
                </a>
                
                <a href="{{ route('budgets.create') }}" class="flex flex-col items-center space-y-2 group">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-grass-500 to-tree-300 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-wallet text-white text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-gray-700">Budget</span>
                </a>
                
                <a href="{{ route('todos.create') }}" class="flex flex-col items-center space-y-2 group">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-blue-500 to-ocean-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-check text-white text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-gray-700">Task</span>
                </a>
                
                <a href="{{ route('social.wall') }}" class="flex flex-col items-center space-y-2 group">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-purple-500 to-pink-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-share text-white text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-gray-700">Post</span>
                </a>
                
                <a href="{{ route('calendar.index') }}" class="flex flex-col items-center space-y-2 group">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-orange-500 to-red-500 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-calendar text-white text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-gray-700">Calendar</span>
                </a>
            </div>
        </div>

        <!-- Subscription Status Card -->
        @if(auth()->user()->subscription_tier === 'free')
        <div class="bg-gradient-to-r from-ocean-500 to-grass-600 rounded-lg shadow-lg p-6 mb-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold mb-1">Upgrade to Pro</h3>
                    <p class="text-sm opacity-90">Unlock unlimited storage & features!</p>
                </div>
                <a href="{{ route('subscription.plans') }}" class="bg-white text-ocean-600 px-6 py-2.5 rounded-full font-semibold hover:bg-gray-100 transition-colors text-sm">
                    Upgrade Now
                </a>
            </div>
        </div>
        @endif

        <!-- Recent Activity Feed -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-4 border-b border-gray-200">
                <h3 class="font-bold text-gray-900">Recent Activity</h3>
            </div>
            
            <div class="divide-y divide-gray-100">
                @if(auth()->user()->itineraries->count() > 0)
                    @foreach(auth()->user()->itineraries->take(5) as $itinerary)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-ocean-100 to-grass-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marked-alt text-ocean-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm">
                                    <span class="font-semibold">You created a trip:</span>
                                    <span class="text-ocean-600 font-semibold">{{ $itinerary->title }}</span>
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-map-marker-alt mr-1"></i>{{ $itinerary->destination }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-calendar mr-1"></i>{{ $itinerary->start_date->format('M j, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-compass text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-600 mb-4">Start your travel journey!</p>
                        <a href="{{ route('itineraries.create') }}" class="inline-block bg-ocean-500 text-white px-6 py-2 rounded-full font-semibold hover:bg-ocean-600 transition-colors">
                            Create Your First Trip
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
