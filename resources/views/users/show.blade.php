<x-app-layout>

{{-- Instagram User Profile --}}
<div class="max-w-[935px] mx-auto px-0 md:px-4">

    {{-- Profile Header --}}
    <div class="flex items-start space-x-8 px-4 pt-6 pb-6 border-b border-[#DBDBDB]">
        {{-- Avatar --}}
        <div class="flex-shrink-0">
            <div class="w-20 h-20 md:w-36 md:h-36 rounded-full bg-gradient-to-tr from-ocean-500 via-cloud-300 to-grass-500 p-[3px]">
                <div class="w-full h-full rounded-full bg-white p-[2px]">
                    <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0077B6&color=fff&size=150' }}"
                         class="w-full h-full rounded-full object-cover">
                </div>
            </div>
        </div>

        {{-- Info --}}
        <div class="flex-1">
            <div class="flex items-center space-x-4 mb-4">
                <h1 class="text-xl font-light text-gray-900">{{ $user->username }}</h1>
                
                @if(auth()->id() === $user->id)
                    <a href="{{ route('profile.edit') }}" class="ig-btn text-sm">Edit Profile</a>
                @else
                    <form action="{{ route('users.follow', $user) }}" method="POST" class="inline" id="follow-form">
                        @csrf
                        <button type="submit" 
                                class="ig-btn text-sm {{ $isFollowing ? 'bg-gray-200 text-gray-800 hover:bg-gray-300' : '' }}"
                                id="follow-btn">
                            {{ $isFollowing ? 'Following' : 'Follow' }}
                        </button>
                    </form>
                @endif
            </div>

            {{-- Stats --}}
            <div class="flex items-center space-x-8 mb-4 text-sm">
                <div><span class="font-semibold">{{ $user->posts_count }}</span> posts</div>
                <a href="{{ route('users.followers', $user) }}" class="hover:underline">
                    <span class="font-semibold">{{ $user->followers_count }}</span> followers
                </a>
                <a href="{{ route('users.following', $user) }}" class="hover:underline">
                    <span class="font-semibold">{{ $user->following_count }}</span> following
                </a>
            </div>

            {{-- Bio --}}
            <div>
                <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                @if($user->bio)
                <p class="text-sm text-gray-700 mt-1 whitespace-pre-wrap">{{ $user->bio }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="flex items-center justify-center border-t border-[#DBDBDB]" x-data="{ tab: 'posts' }">
        <button @click="tab = 'posts'" 
                :class="tab === 'posts' ? 'border-t border-gray-900 text-gray-900' : 'text-gray-400'"
                class="flex items-center space-x-2 py-3 text-xs font-semibold uppercase tracking-wide -mt-px px-6 transition-colors">
            <i class="fas fa-th text-xs"></i>
            <span class="hidden sm:inline">Posts</span>
        </button>
        <button @click="tab = 'reels'" 
                :class="tab === 'reels' ? 'border-t border-gray-900 text-gray-900' : 'text-gray-400'"
                class="flex items-center space-x-2 py-3 text-xs font-semibold uppercase tracking-wide -mt-px px-6 transition-colors">
            <i class="fas fa-film text-xs"></i>
            <span class="hidden sm:inline">Reels</span>
        </button>
    </div>

    {{-- Posts Grid --}}
    @if($posts->count() > 0)
    <div class="grid grid-cols-3 gap-[3px] mt-[3px]">
        @foreach($posts as $post)
        <a href="#" class="relative group aspect-square bg-gray-100 overflow-hidden">
            @if($post->media_urls && count($post->media_urls) > 0)
                <img src="{{ $post->media_urls[0] }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-ocean-300 to-grass-400 flex items-center justify-center">
                    <i class="fas fa-image text-white/40 text-3xl"></i>
                </div>
            @endif
            
            {{-- Hover overlay --}}
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                <div class="text-white flex items-center space-x-6 text-sm font-semibold">
                    <span><i class="fas fa-heart mr-1"></i>{{ $post->likes_count }}</span>
                    <span><i class="fas fa-comment mr-1"></i>{{ $post->comments_count }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    
    <div class="px-4 py-6">
        {{ $posts->links() }}
    </div>
    @else
    <div class="flex flex-col items-center py-20">
        <div class="w-16 h-16 rounded-full border-2 border-gray-300 flex items-center justify-center mb-4">
            <i class="fas fa-camera text-gray-400 text-2xl"></i>
        </div>
        <p class="text-gray-500 text-lg font-semibold">No Posts Yet</p>
    </div>
    @endif

</div>
</x-app-layout>
