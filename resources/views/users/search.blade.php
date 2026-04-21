<x-app-layout>
<div class="max-w-2xl mx-auto px-4">
    <div class="py-6 border-b border-[#DBDBDB] -mx-4 px-4">
        <h1 class="text-xl font-bold text-gray-900">Search Users</h1>
    </div>

    <form action="{{ route('users.search') }}" method="GET" class="mt-6 mb-6">
        <div class="relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="q" value="{{ $query }}" placeholder="Search by username or name..."
                   class="ig-input w-full pl-11" autofocus>
        </div>
    </form>

    @if(count($users) > 0)
    <div class="space-y-2">
        @foreach($users as $user)
        <div class="ig-card p-4 flex items-center justify-between">
            <a href="{{ route('users.show', $user) }}" class="flex items-center space-x-3 flex-1 min-w-0">
                <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0077B6&color=fff&size=80' }}"
                     class="w-12 h-12 rounded-full object-cover">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $user->username }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $user->name }}</p>
                </div>
            </a>
            @if(auth()->id() !== $user->id)
            <form action="{{ route('users.follow', $user) }}" method="POST">
                @csrf
                <button type="submit" class="ig-btn text-xs px-4 py-1.5">
                    {{ auth()->user()->isFollowing($user) ? 'Following' : 'Follow' }}
                </button>
            </form>
            @endif
        </div>
        @endforeach
    </div>
    @elseif($query)
    <div class="text-center py-12">
        <i class="fas fa-search text-gray-300 text-4xl mb-3"></i>
        <p class="text-gray-500">No users found for "{{ $query }}"</p>
    </div>
    @endif
</div>
</x-app-layout>
