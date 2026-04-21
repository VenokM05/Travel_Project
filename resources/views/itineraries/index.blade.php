<x-app-layout>

{{-- Instagram-style Itineraries: Profile grid layout --}}
<div class="max-w-[935px] mx-auto px-0 md:px-4">

    {{-- Flash Message --}}
    @if(session('success'))
        <div id="flash-msg" class="mx-4 mt-4 bg-[#d4edda] border border-[#c3e6cb] text-[#155724] text-sm px-4 py-3 rounded-lg flex items-center justify-between">
            <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
            <button onclick="document.getElementById('flash-msg').remove()" class="text-[#155724] opacity-60 hover:opacity-100">&times;</button>
        </div>
    @endif

    {{-- Profile-style Header Bar --}}
    <div class="flex items-center justify-between px-4 pt-6 pb-4 border-b border-[#DBDBDB]">
        <div class="flex items-center space-x-4">
            <div class="w-14 h-14 bg-gradient-to-tr from-ocean-500 via-cloud-300 to-grass-500 rounded-full flex items-center justify-center">
                <i class="fas fa-map-marked-alt text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 leading-tight">My Itineraries</h1>
                <p class="text-sm text-gray-500">Travel plans &amp; adventures</p>
            </div>
        </div>
        <a href="{{ route('itineraries.create') }}"
           class="bg-[#0095F6] hover:bg-[#1877F2] text-white text-sm font-semibold px-5 py-2 rounded-lg transition-colors flex items-center space-x-2">
            <i class="fas fa-plus text-xs"></i>
            <span>New Trip</span>
        </a>
    </div>

    {{-- Stats Row (Instagram-style) --}}
    @php
        $total      = $itineraries->total();
        $active     = $itineraries->getCollection()->where('status','active')->count();
        $completed  = $itineraries->getCollection()->where('status','completed')->count();
    @endphp
    <div class="flex items-center justify-around py-4 border-b border-[#DBDBDB] px-4">
        <div class="text-center">
            <p class="text-lg font-bold text-gray-900">{{ $total }}</p>
            <p class="text-xs text-gray-500">Trips</p>
        </div>
        <div class="w-px h-8 bg-[#DBDBDB]"></div>
        <div class="text-center">
            <p class="text-lg font-bold text-grass-600">{{ $active }}</p>
            <p class="text-xs text-gray-500">Active</p>
        </div>
        <div class="w-px h-8 bg-[#DBDBDB]"></div>
        <div class="text-center">
            <p class="text-lg font-bold text-ocean-600">{{ $completed }}</p>
            <p class="text-xs text-gray-500">Completed</p>
        </div>
    </div>

    @if($itineraries->count() > 0)

    {{-- Instagram Photo Grid (3 columns, square tiles) --}}
    @php
        $gradients = [
            'from-ocean-400 to-ocean-600',
            'from-grass-400 to-grass-600',
            'from-cloud-400 to-ocean-500',
            'from-tree-400 to-grass-500',
            'from-ocean-500 to-tree-500',
            'from-cloud-300 to-grass-400',
        ];
        $icons = ['fa-plane','fa-mountain','fa-umbrella-beach','fa-globe','fa-anchor','fa-campground','fa-city','fa-ship'];
    @endphp

    <div class="grid grid-cols-3 gap-[3px] mt-[3px]">
        @foreach($itineraries as $i => $itinerary)
        @php
            $grad = $gradients[$i % count($gradients)];
            $icon = $icons[$i % count($icons)];
            $isBig = $i % 9 === 0;
        @endphp
        <a href="{{ route('itineraries.show', $itinerary) }}"
           class="relative group overflow-hidden bg-gray-100
                  {{ $isBig ? 'col-span-2 row-span-2' : '' }}"
           style="aspect-ratio: 1 / 1;">

            {{-- Background gradient / placeholder image --}}
            <div class="absolute inset-0 bg-gradient-to-br {{ $grad }} transition-transform duration-300 group-hover:scale-105">
                <div class="absolute inset-0 flex items-center justify-center opacity-30">
                    <i class="fas {{ $icon }} text-white"
                       style="font-size: {{ $isBig ? '5rem' : '3rem' }}"></i>
                </div>
            </div>

            {{-- Status Badge --}}
            <div class="absolute top-2 right-2">
                @if($itinerary->status === 'active')
                    <span class="bg-grass-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">Active</span>
                @elseif($itinerary->status === 'completed')
                    <span class="bg-ocean-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">Done</span>
                @elseif($itinerary->status === 'cancelled')
                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">Cancelled</span>
                @else
                    <span class="bg-gray-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">Draft</span>
                @endif
            </div>

            {{-- Hover Overlay --}}
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-200 flex items-center justify-center opacity-0 group-hover:opacity-100">
                <div class="text-white text-center px-3">
                    <p class="font-bold text-sm leading-tight truncate">{{ $itinerary->title }}</p>
                    <p class="text-xs mt-1 opacity-80"><i class="fas fa-map-marker-alt mr-1"></i>{{ $itinerary->destination }}</p>
                    <div class="flex items-center justify-center space-x-3 mt-2 text-xs">
                        <span><i class="fas fa-heart mr-1"></i>{{ rand(0,99) }}</span>
                        <span><i class="fas fa-comment mr-1"></i>{{ rand(0,20) }}</span>
                    </div>
                </div>
            </div>

            {{-- Bottom info strip (always visible on large tile) --}}
            @if($isBig)
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent px-3 py-3">
                <p class="text-white font-semibold text-sm leading-tight truncate">{{ $itinerary->title }}</p>
                <p class="text-white/70 text-xs mt-0.5">
                    <i class="fas fa-calendar mr-1"></i>
                    {{ $itinerary->start_date->format('M j') }} &ndash; {{ $itinerary->end_date->format('M j, Y') }}
                </p>
            </div>
            @endif

        </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="px-4 py-6">
        {{ $itineraries->links() }}
    </div>

    @else
    {{-- Empty State --}}
    <div class="flex flex-col items-center justify-center py-20 px-4">
        <div class="w-20 h-20 rounded-full border-2 border-gray-300 flex items-center justify-center mb-5">
            <i class="fas fa-suitcase-rolling text-gray-400 text-3xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Start your journey</h3>
        <p class="text-gray-500 text-sm text-center mb-6 max-w-xs">
            Plan your first adventure! Create an itinerary and organize all your travel details.
        </p>
        <a href="{{ route('itineraries.create') }}"
           class="bg-[#0095F6] hover:bg-[#1877F2] text-white text-sm font-semibold px-8 py-2.5 rounded-lg transition-colors">
            Create Your First Trip
        </a>
    </div>
    @endif

</div>{{-- /.max-w --}}
</x-app-layout>
