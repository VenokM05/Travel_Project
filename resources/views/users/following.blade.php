<x-app-layout>
<div class="max-w-lg mx-auto px-4">
    <div class="py-6 border-b border-[#DBDBDB] -mx-4 px-4 flex items-center space-x-3">
        <a href="{{ route('users.show', $user) }}" class="text-gray-800 hover:text-gray-600">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-xl font-bold text-gray-900">{{ $user->username }} - Following</h1>
    </div>

    <div class="mt-6 space-y-2">
        @forelse($following as $followed)
        <div class="ig-card p-4 flex items-center justify-between">
            <a href="{{ route('users.show', $followed) }}" class="flex items-center space-x-3 flex-1 min-w-0">
                <img src="{{ $followed->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($followed->name) . '&background=0077B6&color=fff&size=80' }}"
                     class="w-12 h-12 rounded-full object-cover">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $followed->username }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $followed->name }}</p>
                </div>
            </a>
            @if(auth()->id() !== $followed->id)
            <form action="{{ route('users.follow', $followed) }}" method="POST">
                @csrf
                <button type="submit" class="ig-btn text-xs px-4 py-1.5">
                    {{ auth()->user()->isFollowing($followed) ? 'Following' : 'Follow' }}
                </button>
            </form>
            @endif
        </div>
        @empty
        <div class="text-center py-12">
            <p class="text-gray-500">Not following anyone yet</p>
        </div>
        @endforelse
    </div>

    <div class="py-6">{{ $following->links() }}</div>
</div>
</x-app-layout>
