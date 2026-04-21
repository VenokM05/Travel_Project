<x-app-layout>
<div class="max-w-lg mx-auto px-4">
    <div class="py-6 border-b border-[#DBDBDB] -mx-4 px-4 flex items-center space-x-3">
        <a href="{{ route('users.show', $user) }}" class="text-gray-800 hover:text-gray-600">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-900">{{ $user->username }} - Followers</h1>
    </div>

    <div class="mt-6 space-y-2">
        @forelse($followers as $follower)
        <div class="ig-card p-4 flex items-center justify-between">
            <a href="{{ route('users.show', $follower) }}" class="flex items-center space-x-3 flex-1 min-w-0">
                <img src="{{ $follower->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($follower->name) . '&background=0077B6&color=fff&size=80' }}"
                     class="w-12 h-12 rounded-full object-cover">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $follower->username }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $follower->name }}</p>
                </div>
            </a>
            @if(auth()->id() !== $follower->id)
            <form action="{{ route('users.follow', $follower) }}" method="POST">
                @csrf
                <button type="submit" class="ig-btn text-xs px-4 py-1.5">
                    {{ auth()->user()->isFollowing($follower) ? 'Following' : 'Follow' }}
                </button>
            </form>
            @endif
        </div>
        @empty
        <div class="text-center py-12">
            <p class="text-gray-500">No followers yet</p>
        </div>
        @endforelse
    </div>

    <div class="py-6">{{ $followers->links() }}</div>
</div>
</x-app-layout>
