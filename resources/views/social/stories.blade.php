<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Stories</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Stories Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <!-- Add Story -->
            <div class="bg-white rounded-lg shadow-sm border-2 border-dashed border-gray-300 p-6 flex flex-col items-center justify-center cursor-pointer hover:border-ocean-500 transition-colors aspect-square">
                <div class="w-16 h-16 rounded-full bg-ocean-50 flex items-center justify-center mb-3">
                    <i class="fas fa-plus text-ocean-500 text-2xl"></i>
                </div>
                <p class="text-sm font-semibold text-gray-700">Add Story</p>
            </div>

            <!-- Story Items -->
            @for($i = 1; $i <= 7; $i++)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden cursor-pointer hover:shadow-md transition-shadow aspect-square relative">
                <img src="https://images.unsplash.com/photo-{{ 1500000 + ($i * 100000) }}?w=400" 
                     class="w-full h-full object-cover"
                     onerror="this.style.display='none'; this.parentElement.querySelector('.fallback').style.display='flex'">
                <div class="fallback hidden w-full h-full bg-gradient-to-br from-ocean-100 to-grass-100 items-center justify-center text-4xl">
                    @if($i == 1) 🏖️
                    @elseif($i == 2) 🌄
                    @elseif($i == 3) 🏕️
                    @elseif($i == 4) 🌊
                    @elseif($i == 5) 🏔️
                    @elseif($i == 6) 🌅
                    @else 🎒
                    @endif
                </div>
                
                <!-- Story Overlay -->
                <div class="absolute top-0 left-0 right-0 p-3 bg-gradient-to-b from-black/50 to-transparent">
                    <div class="flex items-center space-x-2">
                        <img src="https://i.pravatar.cc/150?img={{ $i + 20 }}" class="w-8 h-8 rounded-full border-2 border-white">
                        <span class="text-white text-xs font-semibold">User{{ $i }}</span>
                    </div>
                </div>
                
                <!-- Time Badge -->
                <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/50 to-transparent">
                    <span class="text-white text-xs">{{ $i }}h ago</span>
                </div>
            </div>
            @endfor
        </div>

        <!-- Story Viewer Modal (Hidden by default) -->
        <div id="story-viewer" class="hidden fixed inset-0 bg-black z-50 flex items-center justify-center">
            <!-- Story Content -->
            <div class="relative w-full max-w-md h-full max-h-[90vh] bg-gray-900 rounded-lg overflow-hidden">
                <!-- Progress Bar -->
                <div class="absolute top-0 left-0 right-0 p-2 z-10">
                    <div class="flex space-x-1 mb-2">
                        <div class="flex-1 h-1 bg-white/30 rounded-full overflow-hidden">
                            <div class="h-full bg-white w-1/3"></div>
                        </div>
                        <div class="flex-1 h-1 bg-white/30 rounded-full"></div>
                        <div class="flex-1 h-1 bg-white/30 rounded-full"></div>
                    </div>
                    
                    <!-- Story Header -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img src="https://i.pravatar.cc/150?img=25" class="w-8 h-8 rounded-full border-2 border-white">
                            <span class="text-white text-sm font-semibold">traveler_mike</span>
                            <span class="text-white/60 text-xs">2h</span>
                        </div>
                        <button onclick="document.getElementById('story-viewer').classList.add('hidden')" class="text-white">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Story Image -->
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-ocean-500 to-grass-600">
                    <div class="text-center text-white">
                        <div class="text-8xl mb-4">🌴</div>
                        <p class="text-xl font-semibold">Beautiful Sunset in Bali</p>
                    </div>
                </div>

                <!-- Story Actions -->
                <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/50 to-transparent">
                    <div class="flex items-center space-x-3">
                        <input type="text" 
                               placeholder="Send message..." 
                               class="flex-1 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full border border-white/30 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white">
                        <button class="text-white text-2xl">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="text-white text-2xl">
                            <i class="far fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Your Active Stories -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Your Active Stories</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @for($i = 1; $i <= 3; $i++)
                <div class="relative rounded-lg overflow-hidden aspect-[9/16] cursor-pointer group">
                    <div class="w-full h-full bg-gradient-to-br from-ocean-100 to-grass-100 flex items-center justify-center text-4xl">
                        @if($i == 1) 🏖️
                        @elseif($i == 2) 🌅
                        @else 🎒
                        @endif
                    </div>
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                            <button class="bg-white text-gray-900 px-4 py-2 rounded-full font-semibold text-sm">
                                <i class="fas fa-eye mr-2"></i>View
                            </button>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/60 to-transparent">
                        <p class="text-white text-xs font-semibold">{{ $i * 2 }}h left</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</x-app-layout>
