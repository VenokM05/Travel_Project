<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-wallet text-ocean-500 mr-3"></i>Budget Management
            </h2>
            <a href="{{ route('budgets.create') }}" class="bg-ocean-500 text-white px-6 py-3 rounded-lg hover:bg-ocean-600 transition-colors font-medium">
                <i class="fas fa-plus mr-2"></i>Create Budget
            </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 bg-grass-50 border border-grass-200 text-grass-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Total Budgets</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_budgets'] }}</p>
                </div>
                <div class="w-10 h-10 bg-ocean-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-wallet text-ocean-500"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Total Allocated</p>
                    <p class="text-2xl font-bold text-ocean-600">${{ number_format($stats['total_allocated'], 2) }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-coins text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Total Spent</p>
                    <p class="text-2xl font-bold text-orange-600">${{ number_format($stats['total_spent'], 2) }}</p>
                </div>
                <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-receipt text-orange-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Remaining</p>
                    <p class="text-2xl font-bold {{ $stats['total_remaining'] >= 0 ? 'text-grass-600' : 'text-red-600' }}">
                        ${{ number_format($stats['total_remaining'], 2) }}
                    </p>
                </div>
                <div class="w-10 h-10 bg-grass-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-piggy-bank text-grass-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('budgets.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Itinerary</label>
                <select name="itinerary_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500">
                    <option value="">All Itineraries</option>
                    @foreach($itineraries as $itinerary)
                        <option value="{{ $itinerary->id }}" {{ request('itinerary_id') == $itinerary->id ? 'selected' : '' }}>
                            {{ $itinerary->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Type</label>
                <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500">
                    <option value="">All Types</option>
                    <option value="solo" {{ request('type') === 'solo' ? 'selected' : '' }}>Solo</option>
                    <option value="group" {{ request('type') === 'group' ? 'selected' : '' }}>Group</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full bg-ocean-500 text-white px-4 py-2 rounded-lg hover:bg-ocean-600 transition-colors">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Budgets Grid -->
    @if($budgets->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($budgets as $budget)
                @php
                    $percentageUsed = $budget->total_budget > 0 ? ($budget->total_spent / $budget->total_budget) * 100 : 0;
                    $remaining = $budget->total_budget - $budget->total_spent;
                @endphp
                
                <a href="{{ route('budgets.show', $budget) }}" class="block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all">
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $budget->name }}</h3>
                                @if($budget->itinerary)
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-plane mr-1"></i>{{ $budget->itinerary->title }}
                                    </p>
                                @endif
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold capitalize
                                {{ $budget->type === 'group' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $budget->type }}
                            </span>
                        </div>
                        
                        <!-- Budget Amount -->
                        <div class="mb-4">
                            <div class="flex items-baseline justify-between mb-2">
                                <span class="text-sm text-gray-600">Budget</span>
                                <span class="text-2xl font-bold text-ocean-600">{{ $budget->currency }} {{ number_format($budget->total_budget, 2) }}</span>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                <div class="h-2 rounded-full transition-all {{ $percentageUsed > 90 ? 'bg-red-500' : ($percentageUsed > 70 ? 'bg-orange-500' : 'bg-grass-500') }}" 
                                     style="width: {{ min($percentageUsed, 100) }}%"></div>
                            </div>
                            
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-600">Spent: {{ $budget->currency }} {{ number_format($budget->total_spent, 2) }}</span>
                                <span class="{{ $remaining >= 0 ? 'text-grass-600' : 'text-red-600' }} font-semibold">
                                    {{ $remaining >= 0 ? 'Remaining' : 'Over' }}: {{ $budget->currency }} {{ number_format(abs($remaining), 2) }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Stats -->
                        <div class="flex items-center justify-between text-sm text-gray-600 pt-4 border-t border-gray-100">
                            <span><i class="fas fa-receipt mr-1"></i>{{ $budget->expenses->count() }} expenses</span>
                            <span class="{{ $budget->status === 'active' ? 'text-grass-600' : 'text-gray-500' }}">
                                <i class="fas fa-circle text-xs mr-1"></i>{{ ucfirst($budget->status) }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $budgets->appends(request()->query())->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-24 h-24 bg-ocean-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-wallet text-ocean-500 text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">No budgets yet</h3>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                Start tracking your travel expenses! Create budgets for solo or group trips.
            </p>
            <a href="{{ route('budgets.create') }}" class="inline-block bg-ocean-500 text-white px-8 py-3 rounded-lg hover:bg-ocean-600 transition-colors font-medium">
                <i class="fas fa-plus mr-2"></i>Create Your First Budget
            </a>
        </div>
    @endif
</x-app-layout>
