<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Community Wall</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <!-- Stories Bar (Instagram-style) -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex space-x-4 overflow-x-auto pb-2">
                <!-- Your Story -->
                <div class="flex flex-col items-center space-y-1 flex-shrink-0">
                    <div class="w-16 h-16 rounded-full p-0.5 bg-gradient-to-tr from-ocean-500 to-grass-500">
                        <div class="w-full h-full rounded-full p-0.5 bg-white">
                            <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                                 class="w-full h-full rounded-full object-cover">
                        </div>
                    </div>
                    <span class="text-xs text-gray-600">Your Story</span>
                </div>
                
                <!-- Other Stories -->
                @for($i = 1; $i <= 8; $i++)
                <div class="flex flex-col items-center space-y-1 flex-shrink-0 cursor-pointer">
                    <div class="w-16 h-16 rounded-full p-0.5 bg-gradient-to-tr from-ocean-500 via-cloud-300 to-grass-500">
                        <div class="w-full h-full rounded-full p-0.5 bg-white">
                            <img src="https://i.pravatar.cc/150?img={{ $i + 10 }}" 
                                 class="w-full h-full rounded-full object-cover">
                        </div>
                    </div>
                    <span class="text-xs text-gray-600">User{{ $i }}</span>
                </div>
                @endfor
            </div>
        </div>

        <!-- Create Post Box -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex space-x-3">
                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                     class="w-10 h-10 rounded-full object-cover">
                <div class="flex-1">
                    <input type="text" 
                           placeholder="Share your travel experience..." 
                           class="w-full px-4 py-2.5 bg-gray-100 rounded-full border-0 focus:outline-none focus:ring-2 focus:ring-ocean-500">
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                        <div class="flex space-x-4">
                            <button class="flex items-center space-x-2 text-gray-600 hover:text-ocean-600">
                                <i class="fas fa-image text-lg"></i>
                                <span class="text-sm">Photo</span>
                            </button>
                            <button class="flex items-center space-x-2 text-gray-600 hover:text-ocean-600">
                                <i class="fas fa-video text-lg"></i>
                                <span class="text-sm">Video</span>
                            </button>
                            <button class="flex items-center space-x-2 text-gray-600 hover:text-ocean-600">
                                <i class="fas fa-map-marker-alt text-lg"></i>
                                <span class="text-sm">Location</span>
                            </button>
                        </div>
                        <button class="bg-ocean-500 text-white px-6 py-2 rounded-full font-semibold hover:bg-ocean-600 transition-colors">
                            Post
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Posts Feed -->
        <div class="space-y-6">
            <!-- Sample Post 1 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <!-- Post Header -->
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full p-0.5 bg-gradient-to-tr from-ocean-500 to-grass-500">
                            <img src="https://i.pravatar.cc/150?img=32" class="w-full h-full rounded-full object-cover p-0.5 bg-white">
                        </div>
                        <div>
                            <p class="font-semibold text-sm">sarah_travels</p>
                            <p class="text-xs text-gray-500">Bali, Indonesia</p>
                        </div>
                    </div>
                    <button class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>

                <!-- Post Image -->
                <div class="aspect-square bg-gradient-to-br from-ocean-100 to-grass-100 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800" 
                         class="w-full h-full object-cover"
                         onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'text-6xl\'>🌴</div><p class=\'text-gray-600 mt-2\'>Beautiful Bali Temple</p>'">
                </div>

                <!-- Post Actions -->
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-4">
                            <button class="text-2xl text-gray-700 hover:text-red-500 transition-colors" onclick="this.classList.toggle('text-red-500'); this.classList.toggle('fas'); this.classList.toggle('far')">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="text-2xl text-gray-700 hover:text-ocean-600 transition-colors">
                                <i class="far fa-comment"></i>
                            </button>
                            <button class="text-2xl text-gray-700 hover:text-ocean-600 transition-colors">
                                <i class="far fa-paper-plane"></i>
                            </button>
                        </div>
                        <button class="text-2xl text-gray-700 hover:text-ocean-600 transition-colors">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>

                    <!-- Likes -->
                    <p class="font-semibold text-sm mb-2">2,847 likes</p>

                    <!-- Caption -->
                    <div class="text-sm mb-2">
                        <span class="font-semibold">sarah_travels</span>
                        <span class="text-gray-700"> Exploring the beautiful temples of Bali! The architecture is absolutely stunning 🕌✨ #Bali #Travel #Temple</span>
                    </div>

                    <!-- Comments -->
                    <button class="text-gray-500 text-sm mb-2">View all 128 comments</button>
                    <div class="space-y-1 mb-3">
                        <p class="text-sm"><span class="font-semibold">john_doe</span> Amazing! 😍</p>
                        <p class="text-sm"><span class="font-semibold">traveler_mike</span> I need to visit this place!</p>
                    </div>

                    <!-- Timestamp -->
                    <p class="text-gray-400 text-xs uppercase">2 hours ago</p>
                </div>
            </div>

            <!-- Sample Post 2 -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <!-- Post Header -->
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full p-0.5 bg-gradient-to-tr from-cloud-300 to-tree-300">
                            <img src="https://i.pravatar.cc/150?img=45" class="w-full h-full rounded-full object-cover p-0.5 bg-white">
                        </div>
                        <div>
                            <p class="font-semibold text-sm">adventure_alex</p>
                            <p class="text-xs text-gray-500">Swiss Alps</p>
                        </div>
                    </div>
                    <button class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>

                <!-- Post Image -->
                <div class="aspect-square bg-gradient-to-br from-blue-100 to-green-100 flex items-center justify-center">
                    <img src="https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=800" 
                         class="w-full h-full object-cover"
                         onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'text-6xl\'>🏔️</div><p class=\'text-gray-600 mt-2\'>Swiss Alps Adventure</p>'">
                </div>

                <!-- Post Actions -->
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-4">
                            <button class="text-2xl text-gray-700 hover:text-red-500 transition-colors">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="text-2xl text-gray-700 hover:text-ocean-600 transition-colors">
                                <i class="far fa-comment"></i>
                            </button>
                            <button class="text-2xl text-gray-700 hover:text-ocean-600 transition-colors">
                                <i class="far fa-paper-plane"></i>
                            </button>
                        </div>
                        <button class="text-2xl text-gray-700 hover:text-ocean-600 transition-colors">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>

                    <!-- Likes -->
                    <p class="font-semibold text-sm mb-2">5,234 likes</p>

                    <!-- Caption -->
                    <div class="text-sm mb-2">
                        <span class="font-semibold">adventure_alex</span>
                        <span class="text-gray-700"> Breathtaking views from the Swiss Alps! Nature at its finest 🏔️💚 #Switzerland #Alps #MountainLife</span>
                    </div>

                    <!-- Comments -->
                    <button class="text-gray-500 text-sm mb-2">View all 256 comments</button>
                    
                    <!-- Timestamp -->
                    <p class="text-gray-400 text-xs uppercase">5 hours ago</p>
                </div>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-ocean-500"></div>
            <p class="text-gray-500 text-sm mt-2">Loading more posts...</p>
        </div>
    </div>
</x-app-layout>
