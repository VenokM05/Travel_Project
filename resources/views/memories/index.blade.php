<x-app-layout>

{{-- Instagram-style Memories: Archive/Explore Grid --}}
<div class="max-w-[935px] mx-auto px-0 md:px-4">

    {{-- Header Bar --}}
    <div class="flex items-center justify-between px-4 pt-6 pb-4 border-b border-[#DBDBDB]">
        <div class="flex items-center space-x-4">
            <div class="w-14 h-14 bg-gradient-to-tr from-tree-400 to-grass-500 rounded-full flex items-center justify-center">
                <i class="fas fa-heart text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 leading-tight">Memories</h1>
                <p class="text-sm text-gray-500">Your travel moments &amp; highlights</p>
            </div>
        </div>
        <a href="{{ route('memories.create') }}"
           class="bg-[#0095F6] hover:bg-[#1877F2] text-white text-sm font-semibold px-5 py-2 rounded-lg transition-colors flex items-center space-x-2">
            <i class="fas fa-plus text-xs"></i>
            <span>Add Memory</span>
        </a>
    </div>

    @if(session('success'))
        <div id="flash-msg" class="mx-4 mt-4 bg-[#d4edda] border border-[#c3e6cb] text-[#155724] text-sm px-4 py-3 rounded-lg">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if($memories->count() > 0)

    {{-- Photo Grid --}}
    <div class="grid grid-cols-3 gap-[3px] mt-[3px]">
        @foreach($memories as $memory)
        <a href="{{ route('memories.show', $memory) }}"
           class="relative group cursor-pointer overflow-hidden bg-gray-200"
           style="aspect-ratio: 1/1;">

            {{-- Image or gradient background --}}
            @if($memory->media_urls && count($memory->media_urls) > 0)
                <img src="{{ $memory->media_urls[0] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-ocean-300 to-grass-400 group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 flex items-center justify-center opacity-25">
                        <i class="fas fa-camera text-white text-5xl"></i>
                    </div>
                </div>
            @endif

            {{-- Hover overlay --}}
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/35 transition-all duration-200 flex items-end opacity-0 group-hover:opacity-100">
                <div class="w-full px-3 py-3 text-white">
                    <p class="font-semibold text-sm leading-tight truncate">{{ $memory->title }}</p>
                    @if($memory->location)
                    <p class="text-xs opacity-80"><i class="fas fa-map-marker-alt mr-1"></i>{{ $memory->location }}</p>
                    @endif
                    <p class="text-xs opacity-70 mt-1">{{ $memory->date->format('M j, Y') }}</p>
                </div>
            </div>

            {{-- Mood badge --}}
            @if($memory->mood)
            <div class="absolute top-2 right-2 text-2xl">{{ $memory->mood }}</div>
            @endif
        </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="px-4 py-6">
        {{ $memories->links() }}
    </div>

    @else
    {{-- Empty State --}}
    <div class="flex flex-col items-center justify-center py-20 px-4">
        <div class="w-20 h-20 rounded-full border-2 border-gray-300 flex items-center justify-center mb-5">
            <i class="fas fa-camera text-gray-400 text-3xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Save your first memory</h3>
        <p class="text-gray-500 text-sm text-center mb-6 max-w-xs">
            Capture your travel moments and create a beautiful journal of your adventures.
        </p>
        <a href="{{ route('memories.create') }}"
           class="bg-[#0095F6] hover:bg-[#1877F2] text-white text-sm font-semibold px-8 py-2.5 rounded-lg transition-colors">
            Add Memory
        </a>
    </div>
    @endif

</div>{{-- /.max-w --}}
</x-app-layout>
