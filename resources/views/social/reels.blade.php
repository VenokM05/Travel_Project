<x-app-layout>

@push('scripts')
<script>
    // Auto-mute toggle for reels
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const vid = entry.target.querySelector('video');
                if (!vid) return;
                if (entry.isIntersecting) {
                    vid.play().catch(() => {});
                } else {
                    vid.pause();
                }
            });
        }, { threshold: 0.7 });

        document.querySelectorAll('.reel-item').forEach(el => observer.observe(el));

        // Like button
        document.querySelectorAll('.reel-like-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const icon = this.querySelector('i');
                const count = this.querySelector('span');
                if (icon.classList.contains('far')) {
                    icon.classList.replace('far','fas');
                    icon.classList.add('text-red-500');
                    count.textContent = parseInt(count.textContent) + 1;
                    icon.classList.add('like-animate');
                    setTimeout(() => icon.classList.remove('like-animate'), 400);
                } else {
                    icon.classList.replace('fas','far');
                    icon.classList.remove('text-red-500');
                    count.textContent = parseInt(count.textContent) - 1;
                }
            });
        });
    });
</script>
@endpush

{{-- Instagram Reels: Full-screen vertical feed --}}
<style>
    .reel-feed { scroll-snap-type: y mandatory; }
    .reel-item { scroll-snap-align: start; scroll-snap-stop: always; }
</style>

@php
    $reels = [
        ['user' => 'alex_travels',      'avatar' => null, 'name' => 'Alex',     'caption' => 'Sunrise at Bali 🌅 Nothing beats this view!',         'location' => 'Bali, Indonesia',    'song' => 'Tropical Vibes - Summer Mix',   'likes' => 4821, 'comments' => 312, 'color' => 'from-orange-400 via-pink-400 to-purple-500', 'icon' => 'fa-sun'],
        ['user' => 'maria.wanderlust',  'avatar' => null, 'name' => 'Maria',    'caption' => 'Lost in the streets of Tokyo 🗼✨ must visit!!',         'location' => 'Tokyo, Japan',       'song' => 'Lo-Fi Tokyo Beat',              'likes' => 9234, 'comments' => 571, 'color' => 'from-pink-300 via-red-400 to-pink-600',   'icon' => 'fa-torii-gate'],
        ['user' => 'nomad_kai',         'avatar' => null, 'name' => 'Kai',      'caption' => 'Freediving in crystal clear waters 🤿',                 'location' => 'Maldives',           'song' => 'Ocean Waves (Ambient)',         'likes' => 12450,'comments' => 820, 'color' => 'from-ocean-300 via-ocean-500 to-ocean-700','icon' => 'fa-water'],
        ['user' => 'yuki.explores',     'avatar' => null, 'name' => 'Yuki',     'caption' => 'Cherry blossom season is EVERYTHING 🌸🌸🌸',            'location' => 'Kyoto, Japan',       'song' => 'Sakura - Original Mix',         'likes' => 7880, 'comments' => 445, 'color' => 'from-pink-200 via-pink-400 to-rose-500',  'icon' => 'fa-leaf'],
        ['user' => 'sierra_trails',     'avatar' => null, 'name' => 'Sierra',   'caption' => 'Summit view after 8 hours of hiking ⛰️ Worth every step!','location' => 'Swiss Alps',         'song' => 'Epic Mountain OST',            'likes' => 5610, 'comments' => 298, 'color' => 'from-grass-400 via-tree-500 to-gray-600',  'icon' => 'fa-mountain'],
    ];
@endphp

{{-- Dark full-screen container (breaks out of main padding) --}}
<div class="bg-black -mx-4 md:-mx-6 -my-4 relative overflow-hidden" id="reels-container"
     style="height: calc(100vh - 57px);">

    {{-- Reels Feed --}}
    <div class="reel-feed h-full overflow-y-scroll" style="scrollbar-width:none;-webkit-overflow-scrolling:touch;">

        @foreach($reels as $idx => $reel)
        @php
            $initials = strtoupper(substr($reel['name'], 0, 2));
        @endphp
        <div class="reel-item relative flex items-center justify-center bg-black" style="height:100%;min-height:100vh;">

            {{-- Video / Gradient background --}}
            <div class="absolute inset-0 bg-gradient-to-b {{ $reel['color'] }} opacity-80"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <i class="fas {{ $reel['icon'] }} text-white opacity-20" style="font-size:12rem;"></i>
            </div>

            {{-- Mute button (top right) --}}
            <button class="absolute top-4 right-4 z-20 text-white bg-black/30 rounded-full w-9 h-9 flex items-center justify-center">
                <i class="fas fa-volume-mute text-sm"></i>
            </button>

            {{-- More options (top right, below mute) --}}
            <button class="absolute top-16 right-4 z-20 text-white">
                <i class="fas fa-ellipsis-v text-xl"></i>
            </button>

            {{-- Right Action Bar --}}
            <div class="absolute right-3 bottom-24 flex flex-col items-center space-y-5 z-20">

                {{-- Like --}}
                <div class="flex flex-col items-center">
                    <button class="reel-like-btn text-white flex flex-col items-center group">
                        <i class="far fa-heart text-[28px] group-hover:scale-110 transition-transform"></i>
                    </button>
                    <span class="text-white text-xs font-semibold mt-1">{{ number_format($reel['likes']) }}</span>
                </div>

                {{-- Comment --}}
                <div class="flex flex-col items-center">
                    <button class="text-white">
                        <i class="far fa-comment text-[28px]"></i>
                    </button>
                    <span class="text-white text-xs font-semibold mt-1">{{ number_format($reel['comments']) }}</span>
                </div>

                {{-- Share --}}
                <div class="flex flex-col items-center">
                    <button class="text-white">
                        <i class="far fa-paper-plane text-[28px]"></i>
                    </button>
                    <span class="text-white text-xs font-semibold mt-1">Share</span>
                </div>

                {{-- More --}}
                <button class="text-white">
                    <i class="fas fa-ellipsis-h text-[22px]"></i>
                </button>

                {{-- User Avatar (bottom of right bar) --}}
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-ocean-400 to-grass-400 border-2 border-white flex items-center justify-center overflow-hidden">
                        <span class="text-white text-xs font-bold">{{ $initials }}</span>
                    </div>
                    <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-5 h-5 bg-[#0095F6] rounded-full flex items-center justify-center border border-black">
                        <i class="fas fa-plus text-white" style="font-size:8px;"></i>
                    </div>
                </div>
            </div>

            {{-- Bottom Info --}}
            <div class="absolute bottom-6 left-4 right-16 z-20">

                {{-- User --}}
                <div class="flex items-center space-x-2 mb-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-ocean-400 to-grass-400 border-2 border-white flex items-center justify-center">
                        <span class="text-white text-xs font-bold">{{ $initials }}</span>
                    </div>
                    <span class="text-white font-semibold text-sm">{{ $reel['user'] }}</span>
                    <button class="ml-1 border border-white text-white text-xs font-semibold px-3 py-0.5 rounded-lg">Follow</button>
                </div>

                {{-- Caption --}}
                <p class="text-white text-sm leading-snug mb-2 pr-2">{{ $reel['caption'] }}</p>

                {{-- Location --}}
                <p class="text-white/70 text-xs mb-3">
                    <i class="fas fa-map-marker-alt mr-1"></i>{{ $reel['location'] }}
                </p>

                {{-- Audio bar --}}
                <div class="flex items-center space-x-2">
                    <div class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-music text-white" style="font-size:8px;"></i>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-white text-xs whitespace-nowrap" style="animation: marquee 8s linear infinite;">{{ $reel['song'] }}</p>
                    </div>
                </div>
            </div>

        </div>{{-- /.reel-item --}}
        @endforeach

    </div>{{-- /.reel-feed --}}

    {{-- Top Reels Header --}}
    <div class="absolute top-0 left-0 right-0 flex items-center justify-between px-4 py-3 z-30" style="background: linear-gradient(to bottom, rgba(0,0,0,0.5), transparent);">
        <h1 class="text-white font-bold text-xl">Reels</h1>
        <div class="flex items-center space-x-3">
            <button class="text-white">
                <i class="fas fa-search text-lg"></i>
            </button>
            <a href="#" class="text-white">
                <i class="fas fa-video text-lg"></i>
            </a>
        </div>
    </div>

</div>{{-- /.reels-container --}}

<style>
    @keyframes marquee {
        0%   { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }
    /* Hide main padding on reels page */
    main > div:last-child { padding: 0 !important; }
    main { padding-bottom: 0 !important; }
</style>

</x-app-layout>
