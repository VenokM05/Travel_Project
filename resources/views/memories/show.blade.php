<x-app-layout>

{{-- Instagram-style Memory Detail View --}}
<div class="max-w-[935px] mx-auto px-0 md:px-4">

    {{-- Header --}}
    <div class="flex items-center justify-between px-4 pt-6 pb-4 border-b border-[#DBDBDB]">
        <div class="flex items-center space-x-3">
            <a href="{{ route('memories.index') }}" class="text-gray-800 hover:text-gray-600 transition-colors">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-900 leading-tight">{{ $memory->title }}</h1>
                @if($memory->location)
                <p class="text-sm text-gray-500">
                    <i class="fas fa-map-marker-alt mr-1"></i>{{ $memory->location }}
                </p>
                @endif
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('memories.edit', $memory) }}"
               class="text-sm font-semibold text-gray-800 hover:text-gray-600 px-4 py-2 rounded-lg transition-colors flex items-center space-x-2">
                <i class="fas fa-edit text-xs"></i>
                <span>Edit</span>
            </a>
            <form action="{{ route('memories.destroy', $memory) }}" method="POST"
                  onsubmit="return confirm('Delete this memory? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 px-2 py-2 rounded-lg transition-colors">
                    <i class="fas fa-trash text-sm"></i>
                </button>
            </form>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div id="flash-msg" class="mx-4 mt-4 bg-[#d4edda] border border-[#c3e6cb] text-[#155724] text-sm px-4 py-3 rounded-lg">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Mood + Date Bar --}}
    <div class="flex items-center justify-between px-4 py-4 border-b border-[#DBDBDB]">
        <div class="flex items-center space-x-4">
            @if($memory->mood)
            <div class="flex items-center space-x-2">
                <span class="text-3xl">{{ $memory->mood }}</span>
                <span class="text-sm text-gray-600">Feeling</span>
            </div>
            @endif
            <div class="w-px h-8 bg-[#DBDBDB]"></div>
            <div class="flex items-center space-x-2">
                <i class="fas fa-calendar text-gray-400"></i>
                <span class="text-sm font-semibold text-gray-900">{{ $memory->date->format('M j, Y') }}</span>
            </div>
        </div>
        @if($memory->itinerary)
        <a href="{{ route('itineraries.show', $memory->itinerary) }}"
           class="flex items-center space-x-2 text-sm text-ocean-600 hover:text-ocean-700">
            <i class="fas fa-route"></i>
            <span class="font-medium">{{ $memory->itinerary->title }}</span>
        </a>
        @endif
    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6 px-4">

        {{-- Left Column (2/3) — Photo Grid --}}
        <div class="lg:col-span-2">
            @if($memory->media_urls && count($memory->media_urls) > 0)
                <div class="grid grid-cols-2 gap-[3px]">
                    @foreach($memory->media_urls as $idx => $url)
                    <div class="relative group aspect-square bg-gray-100 overflow-hidden rounded">
                        <img src="{{ $url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @if($idx === 0)
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all"></div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div class="aspect-square bg-gradient-to-br from-ocean-300 via-cloud-300 to-grass-400 rounded-lg flex items-center justify-center">
                    <div class="text-center text-white">
                        <i class="fas fa-camera text-6xl opacity-40 mb-3"></i>
                        <p class="text-lg font-semibold opacity-60">No Photos</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Right Column (1/3) — Memory Details --}}
        <div class="space-y-6">

            {{-- User Info --}}
            <div class="ig-card p-5">
                <div class="flex items-center space-x-3 mb-4">
                    <img src="{{ $memory->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($memory->user->name) . '&background=0077B6&color=fff&size=80' }}"
                         class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <a href="{{ route('users.show', $memory->user) }}" class="text-sm font-semibold text-gray-900 hover:text-ocean-600">
                            {{ $memory->user->username }}
                        </a>
                        <p class="text-xs text-gray-500">{{ $memory->user->name }}</p>
                    </div>
                </div>
                <p class="text-xs text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    Created {{ $memory->created_at->diffForHumans() }}
                </p>
            </div>

            {{-- Story/Description --}}
            @if($memory->description)
            <div class="ig-card p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">
                    <i class="fas fa-book-open mr-2 text-gray-400"></i>The Story
                </h3>
                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $memory->description }}</p>
            </div>
            @endif

            {{-- Location Details --}}
            @if($memory->location)
            <div class="ig-card p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">
                    <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>Location
                </h3>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-ocean-50 flex items-center justify-center">
                        <i class="fas fa-globe-americas text-ocean-500"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $memory->location }}</p>
                        <p class="text-xs text-gray-500">Travel destination</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Linked Itinerary --}}
            @if($memory->itinerary)
            <div class="ig-card p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">
                    <i class="fas fa-route mr-2 text-gray-400"></i>Related Trip
                </h3>
                <a href="{{ route('itineraries.show', $memory->itinerary) }}"
                   class="block p-3 bg-gradient-to-r from-ocean-50 to-grass-50 rounded-lg hover:from-ocean-100 hover:to-grass-100 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-semibold text-gray-900">{{ $memory->itinerary->title }}</p>
                        <i class="fas fa-arrow-right text-gray-400"></i>
                    </div>
                    <div class="flex items-center space-x-3 text-xs text-gray-600">
                        <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $memory->itinerary->destination }}</span>
                        <span>·</span>
                        <span>{{ $memory->itinerary->start_date->format('M j') }} - {{ $memory->itinerary->end_date->format('M j, Y') }}</span>
                    </div>
                </a>
            </div>
            @endif

            {{-- Quick Actions --}}
            <div class="ig-card p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">
                    <i class="fas fa-share-alt mr-2 text-gray-400"></i>Share
                </h3>
                <div class="grid grid-cols-3 gap-2">
                    <button onclick="navigator.clipboard.writeText(window.location.href); showToast('Link copied!')"
                            class="flex flex-col items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-link text-ocean-500 mb-1"></i>
                        <span class="text-xs text-gray-600">Copy Link</span>
                    </button>
                    <button onclick="showToast('Coming soon!')"
                            class="flex flex-col items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-download text-grass-500 mb-1"></i>
                        <span class="text-xs text-gray-600">Download</span>
                    </button>
                    <button onclick="showToast('Coming soon!')"
                            class="flex flex-col items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-print text-tree-500 mb-1"></i>
                        <span class="text-xs text-gray-600">Print</span>
                    </button>
                </div>
            </div>

        </div>{{-- /.right column --}}

    </div>{{-- /.grid --}}

    {{-- Bottom Section --}}
    <div class="mt-8 px-4 pb-8">
        <div class="ig-card p-6 text-center">
            <p class="text-sm text-gray-600 mb-2">
                <i class="fas fa-heart text-red-500 mr-1"></i>
                Cherish this moment forever
            </p>
            <p class="text-xs text-gray-400">
                {{ $memory->date->format('l, F jS, Y') }}
            </p>
        </div>
    </div>

</div>{{-- /.max-w --}}

</x-app-layout>
