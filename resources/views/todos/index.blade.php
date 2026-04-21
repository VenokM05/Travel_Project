<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-check-circle text-cloud-300 mr-3"></i>To-Do List
            </h2>
            <a href="{{ route('todos.create') }}" class="bg-ocean-500 text-white px-6 py-3 rounded-lg hover:bg-ocean-600 transition-colors font-medium">
                <i class="fas fa-plus mr-2"></i>Add Task
            </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 bg-grass-50 border border-grass-200 text-grass-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-list text-gray-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">In Progress</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['in_progress'] }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-spinner text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Completed</p>
                    <p class="text-2xl font-bold text-grass-600">{{ $stats['completed'] }}</p>
                </div>
                <div class="w-10 h-10 bg-grass-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check text-grass-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Urgent</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['urgent'] }}</p>
                </div>
                <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('todos.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Priority</label>
                <select name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500">
                    <option value="">All Priorities</option>
                    <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                    <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Category</label>
                <input type="text" name="category" value="{{ request('category') }}" placeholder="e.g., Pre-trip" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500">
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full bg-ocean-500 text-white px-4 py-2 rounded-lg hover:bg-ocean-600 transition-colors">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Tasks List -->
    @if($todos->count() > 0)
        <div class="space-y-3">
            @foreach($todos as $todo)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 hover:shadow-md transition-all {{ $todo->status === 'completed' ? 'opacity-60' : '' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3 flex-1">
                            <!-- Checkbox -->
                            <form action="{{ route('todos.toggle', $todo) }}" method="POST" class="mt-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-colors
                                    {{ $todo->status === 'completed' ? 'bg-grass-500 border-grass-500' : 'border-gray-300 hover:border-ocean-500' }}">
                                    @if($todo->status === 'completed')
                                        <i class="fas fa-check text-white text-xs"></i>
                                    @endif
                                </button>
                            </form>
                            
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-1">
                                    <h3 class="font-semibold text-gray-900 {{ $todo->status === 'completed' ? 'line-through' : '' }}">
                                        {{ $todo->title }}
                                    </h3>
                                    
                                    <!-- Priority Badge -->
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold capitalize
                                        @if($todo->priority === 'urgent') bg-red-100 text-red-700
                                        @elseif($todo->priority === 'high') bg-orange-100 text-orange-700
                                        @elseif($todo->priority === 'medium') bg-yellow-100 text-yellow-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ $todo->priority }}
                                    </span>
                                    
                                    <!-- Status Badge -->
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold capitalize
                                        @if($todo->status === 'completed') bg-grass-100 text-grass-700
                                        @elseif($todo->status === 'in_progress') bg-blue-100 text-blue-700
                                        @elseif($todo->status === 'cancelled') bg-red-100 text-red-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ str_replace('_', ' ', $todo->status) }}
                                    </span>
                                </div>
                                
                                @if($todo->description)
                                    <p class="text-sm text-gray-600 mb-2">{{ Str::limit($todo->description, 100) }}</p>
                                @endif
                                
                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                    @if($todo->due_date)
                                        <span class="{{ $todo->due_date->isPast() && $todo->status !== 'completed' ? 'text-red-600 font-semibold' : '' }}">
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $todo->due_date->format('M j, Y') }}
                                            @if($todo->due_date->isPast() && $todo->status !== 'completed')
                                                (Overdue)
                                            @endif
                                        </span>
                                    @endif
                                    
                                    @if($todo->category)
                                        <span><i class="fas fa-tag mr-1"></i>{{ $todo->category }}</span>
                                    @endif
                                    
                                    @if($todo->itinerary)
                                        <span><i class="fas fa-plane mr-1"></i>{{ $todo->itinerary->title }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center space-x-2 ml-4">
                            <a href="{{ route('todos.edit', $todo) }}" class="text-blue-600 hover:text-blue-700 p-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="inline" onsubmit="return confirm('Delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 p-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $todos->appends(request()->query())->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-24 h-24 bg-cloud-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-tasks text-cloud-300 text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">No tasks yet</h3>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                Start organizing your trip preparation! Add tasks with priorities and due dates.
            </p>
            <a href="{{ route('todos.create') }}" class="inline-block bg-ocean-500 text-white px-8 py-3 rounded-lg hover:bg-ocean-600 transition-colors font-medium">
                <i class="fas fa-plus mr-2"></i>Add Your First Task
            </a>
        </div>
    @endif
</x-app-layout>
