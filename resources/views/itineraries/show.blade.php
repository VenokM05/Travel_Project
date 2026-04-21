<x-app-layout>

{{-- Instagram-style Itinerary Detail View --}}
<div class="max-w-[935px] mx-auto px-0 md:px-4">

    {{-- Back + Header --}}
    <div class="flex items-center justify-between px-4 pt-6 pb-4 border-b border-[#DBDBDB]">
        <div class="flex items-center space-x-3">
            <a href="{{ route('itineraries.index') }}" class="text-gray-800 hover:text-gray-600 transition-colors">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-900 leading-tight">{{ $itinerary->title }}</h1>
                <p class="text-sm text-gray-500">
                    <i class="fas fa-map-marker-alt mr-1"></i>{{ $itinerary->destination }}
                </p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('itineraries.edit', $itinerary) }}"
               class="text-sm font-semibold text-gray-800 hover:text-gray-600 px-4 py-2 rounded-lg transition-colors flex items-center space-x-2">
                <i class="fas fa-edit text-xs"></i>
                <span>Edit</span>
            </a>
            <form action="{{ route('itineraries.destroy', $itinerary) }}" method="POST"
                  onsubmit="return confirm('Delete this itinerary? This cannot be undone.');">
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
        <div id="flash-msg" class="mx-4 mt-4 bg-[#d4edda] border border-[#c3e6cb] text-[#155724] text-sm px-4 py-3 rounded-lg flex items-center justify-between">
            <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
            <button onclick="document.getElementById('flash-msg').remove()" class="text-[#155724] opacity-60 hover:opacity-100">&times;</button>
        </div>
    @endif

    {{-- Stats Row (Instagram-style) --}}
    @php
        $daysCount   = $itinerary->days->count();
        $budgetsCount = $itinerary->budgets->count();
        $todosCount   = $itinerary->todos->count();
        $memoriesCount = $itinerary->memories->count();
        $daysRemaining = max(0, now()->diffInDays($itinerary->end_date, false));
        $isPast        = $itinerary->end_date->isPast();
    @endphp
    <div class="flex items-center justify-around py-4 border-b border-[#DBDBDB] px-4">
        <div class="text-center">
            <p class="text-lg font-bold text-gray-900">{{ $daysCount }}</p>
            <p class="text-xs text-gray-500">Days</p>
        </div>
        <div class="w-px h-8 bg-[#DBDBDB]"></div>
        <div class="text-center">
            <p class="text-lg font-bold text-grass-600">${{ number_format($itinerary->budget_total, 2) }}</p>
            <p class="text-xs text-gray-500">Budget</p>
        </div>
        <div class="w-px h-8 bg-[#DBDBDB]"></div>
        <div class="text-center">
            <p class="text-lg font-bold text-ocean-600">{{ $todosCount }}</p>
            <p class="text-xs text-gray-500">Tasks</p>
        </div>
        <div class="w-px h-8 bg-[#DBDBDB]"></div>
        <div class="text-center">
            <p class="text-lg font-bold text-tree-500">{{ $memoriesCount }}</p>
            <p class="text-xs text-gray-500">Memories</p>
        </div>
    </div>

    {{-- Main Content: 2-column layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6 px-4">

        {{-- Left Column (2/3) — Trip Info + Days --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Description Card --}}
            @if($itinerary->description)
            <div class="ig-card p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-2">
                    <i class="fas fa-align-left mr-2 text-gray-400"></i>About this trip
                </h3>
                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $itinerary->description }}</p>
            </div>
            @endif

            {{-- Date Range --}}
            <div class="ig-card p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">
                    <i class="fas fa-calendar mr-2 text-gray-400"></i>Dates
                </h3>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg bg-ocean-50 flex items-center justify-center">
                            <i class="fas fa-calendar-day text-ocean-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Starts</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $itinerary->start_date->format('M j, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center text-gray-400">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg bg-grass-50 flex items-center justify-center">
                            <i class="fas fa-calendar-check text-grass-500"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Ends</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $itinerary->end_date->format('M j, Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-[#DBDBDB] flex items-center justify-between">
                    <span class="text-xs text-gray-500">Status</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold capitalize
                        @if($itinerary->status === 'active') bg-grass-50 text-grass-700
                        @elseif($itinerary->status === 'completed') bg-ocean-50 text-ocean-700
                        @elseif($itinerary->status === 'cancelled') bg-red-50 text-red-700
                        @else bg-gray-100 text-gray-600
                        @endif">
                        {{ $itinerary->status }}
                    </span>
                </div>
                @if(!$isPast && $itinerary->status === 'active')
                <div class="mt-2 text-xs text-gray-500">
                    <i class="fas fa-clock mr-1"></i>{{ $daysRemaining }} days remaining
                </div>
                @endif
            </div>

            {{-- Itinerary Days --}}
            <div class="ig-card">
                <div class="flex items-center justify-between p-5 border-b border-[#DBDBDB]">
                    <h3 class="text-sm font-semibold text-gray-900">
                        <i class="fas fa-list-ol mr-2 text-gray-400"></i>Trip Days
                    </h3>
                    @if($daysCount > 0)
                    <span class="text-xs text-gray-500">{{ $daysCount }} day(s)</span>
                    @endif
                </div>

                @if($daysCount > 0)
                <div class="divide-y divide-[#DBDBDB]">
                    @foreach($itinerary->days as $day)
                    <div class="p-5 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-ocean-400 to-ocean-600 flex items-center justify-center flex-shrink-0">
                                <span class="text-white text-xs font-bold">{{ $day->day_number }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900">{{ $day->date ? $day->date->format('l, M j') : 'Day ' . $day->day_number }}</p>
                                @if($day->notes)
                                <p class="text-xs text-gray-600 mt-1 leading-relaxed">{{ $day->notes }}</p>
                                @endif
                                @if(is_array($day->activities) && count($day->activities) > 0)
                                <ul class="mt-2 space-y-1">
                                    @foreach($day->activities as $activity)
                                    <li class="text-xs text-gray-700 flex items-start space-x-2">
                                        <i class="fas fa-circle text-[4px] text-gray-400 mt-1.5 flex-shrink-0"></i>
                                        <span>{{ is_string($activity) ? $activity : ($activity['title'] ?? '') }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="flex flex-col items-center py-12 px-4 text-center">
                    <div class="w-14 h-14 rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center mb-3">
                        <i class="fas fa-calendar-plus text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-gray-500 text-sm font-medium mb-1">No days planned yet</p>
                    <p class="text-gray-400 text-xs">Add daily activities to organize your trip.</p>
                </div>
                @endif
            </div>

        </div>{{-- /.lg:col-span-2 --}}

        {{-- Right Column (1/3) — Linked Resources --}}
        <div class="space-y-6">

            {{-- Budgets --}}
            <div class="ig-card">
                <div class="flex items-center justify-between p-5 border-b border-[#DBDBDB]">
                    <h3 class="text-sm font-semibold text-gray-900">
                        <i class="fas fa-wallet mr-2 text-gray-400"></i>Budgets
                    </h3>
                    <a href="{{ route('budgets.create') }}" class="text-[#0095F6] text-xs font-semibold hover:underline">+ Add</a>
                </div>
                @if($budgetsCount > 0)
                <div class="divide-y divide-[#DBDBDB]">
                    @foreach($itinerary->budgets as $budget)
                    <a href="{{ route('budgets.show', $budget) }}" class="block p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $budget->name }}</p>
                            <span class="text-xs text-gray-500">{{ $budget->currency }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-600">${{ number_format($budget->total_spent, 2) }} spent</span>
                            <span class="font-semibold text-gray-900">${{ number_format($budget->total_budget, 2) }}</span>
                        </div>
                        @php $pct = $budget->total_budget > 0 ? min(100, ($budget->total_spent / $budget->total_budget) * 100) : 0; @endphp
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                            <div class="h-1.5 rounded-full {{ $pct > 90 ? 'bg-red-500' : 'bg-grass-500' }}" style="width: {{ $pct }}%"></div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="py-8 text-center">
                    <p class="text-gray-400 text-xs">No budgets linked yet</p>
                </div>
                @endif
            </div>

            {{-- To-Dos --}}
            <div class="ig-card">
                <div class="flex items-center justify-between p-5 border-b border-[#DBDBDB]">
                    <h3 class="text-sm font-semibold text-gray-900">
                        <i class="fas fa-check-square mr-2 text-gray-400"></i>To-Dos
                    </h3>
                    <a href="{{ route('todos.create') }}" class="text-[#0095F6] text-xs font-semibold hover:underline">+ Add</a>
                </div>
                @if($todosCount > 0)
                <div class="divide-y divide-[#DBDBDB]">
                    @foreach($itinerary->todos->take(5) as $todo)
                    <div class="p-4 flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-0.5">
                            <div class="w-4 h-4 rounded-full border-2 {{ $todo->status === 'completed' ? 'border-grass-500 bg-grass-500' : 'border-gray-300' }} flex items-center justify-center">
                                @if($todo->status === 'completed')
                                <i class="fas fa-check text-white" style="font-size:7px;"></i>
                                @endif
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm {{ $todo->status === 'completed' ? 'line-through text-gray-400' : 'text-gray-900' }}">
                                {{ $todo->title }}
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                <span class="capitalize {{ $todo->priority === 'high' ? 'text-red-600' : ($todo->priority === 'medium' ? 'text-yellow-600' : 'text-gray-500') }}">
                                    {{ $todo->priority }}
                                </span>
                                @if($todo->due_date)
                                · {{ $todo->due_date->format('M j') }}
                                @endif
                            </p>
                        </div>
                    </div>
                    @endforeach
                    @if($todosCount > 5)
                    <a href="{{ route('todos.index', ['itinerary_id' => $itinerary->id]) }}" class="block p-4 text-center text-xs text-[#0095F6] font-semibold hover:bg-gray-50">
                        View all {{ $todosCount }} tasks
                    </a>
                    @endif
                </div>
                @else
                <div class="py-8 text-center">
                    <p class="text-gray-400 text-xs">No tasks linked yet</p>
                </div>
                @endif
            </div>

            {{-- Memories --}}
            <div class="ig-card">
                <div class="flex items-center justify-between p-5 border-b border-[#DBDBDB]">
                    <h3 class="text-sm font-semibold text-gray-900">
                        <i class="fas fa-heart mr-2 text-gray-400"></i>Memories
                    </h3>
                    <a href="{{ route('memories.index') }}" class="text-[#0095F6] text-xs font-semibold hover:underline">+ Add</a>
                </div>
                @if($memoriesCount > 0)
                <div class="grid grid-cols-3 gap-[2px] p-2">
                    @foreach($itinerary->memories->take(9) as $memory)
                    <div class="aspect-square bg-gradient-to-br from-ocean-300 to-grass-400 rounded overflow-hidden">
                        @if(is_array($memory->media_urls) && count($memory->media_urls) > 0)
                        <img src="{{ $memory->media_urls[0] }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-camera text-white/40 text-lg"></i>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @if($memoriesCount > 9)
                <div class="p-4 text-center border-t border-[#DBDBDB]">
                    <a href="{{ route('memories.index') }}" class="text-xs text-[#0095F6] font-semibold hover:underline">
                        View all {{ $memoriesCount }} memories
                    </a>
                </div>
                @endif
                @else
                <div class="py-8 text-center">
                    <p class="text-gray-400 text-xs">No memories saved yet</p>
                </div>
                @endif
            </div>

        </div>{{-- /.right column --}}

    </div>{{-- /.grid --}}

</div>{{-- /.max-w --}}
</x-app-layout>
