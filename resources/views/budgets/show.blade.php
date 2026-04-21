<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('budgets.index') }}" class="text-ocean-600 hover:text-ocean-700 mr-4">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h2 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-wallet text-ocean-500 mr-3"></i>{{ $budget->name }}
                </h2>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('budgets.edit', $budget) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 bg-grass-50 border border-grass-200 text-grass-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-ocean-500 to-ocean-600 rounded-xl shadow-lg p-6 text-white">
            <p class="text-sm opacity-90 mb-1">Total Budget</p>
            <p class="text-3xl font-bold">{{ $budget->currency }} {{ number_format($stats['total_budget'], 2) }}</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-sm text-gray-600 mb-1">Total Spent</p>
            <p class="text-3xl font-bold text-orange-600">{{ $budget->currency }} {{ number_format($stats['total_spent'], 2) }}</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-sm text-gray-600 mb-1">Remaining</p>
            <p class="text-3xl font-bold {{ $stats['remaining'] >= 0 ? 'text-grass-600' : 'text-red-600' }}">
                {{ $budget->currency }} {{ number_format($stats['remaining'], 2) }}
            </p>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-sm text-gray-600 mb-1">Budget Used</p>
            <p class="text-3xl font-bold text-ocean-600">{{ number_format($stats['percentage_used'], 1) }}%</p>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-semibold text-gray-700">Spending Progress</span>
            <span class="text-sm text-gray-600">{{ $stats['expense_count'] }} expenses</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-4">
            <div class="h-4 rounded-full transition-all {{ $stats['percentage_used'] > 90 ? 'bg-red-500' : ($stats['percentage_used'] > 70 ? 'bg-orange-500' : 'bg-grass-500') }}" 
                 style="width: {{ min($stats['percentage_used'], 100) }}%"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Expenses List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-receipt text-ocean-500 mr-2"></i>Expenses
                    </h3>
                    <button onclick="document.getElementById('add-expense-form').classList.toggle('hidden')" 
                            class="bg-ocean-500 text-white px-4 py-2 rounded-lg hover:bg-ocean-600 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Expense
                    </button>
                </div>

                <!-- Add Expense Form -->
                <div id="add-expense-form" class="hidden p-6 border-b border-gray-100 bg-gray-50">
                    <form action="{{ route('budgets.expenses.store', $budget) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Title *</label>
                                <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Amount *</label>
                                <input type="number" name="amount" required min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Category *</label>
                                <select name="category" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500">
                                    <option value="Transportation">Transportation</option>
                                    <option value="Accommodation">Accommodation</option>
                                    <option value="Food">Food</option>
                                    <option value="Activities">Activities</option>
                                    <option value="Shopping">Shopping</option>
                                    <option value="Miscellaneous">Miscellaneous</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Date</label>
                                <input type="date" name="expense_date" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500"></textarea>
                        </div>
                        <div class="flex items-center justify-end space-x-3">
                            <button type="button" onclick="document.getElementById('add-expense-form').classList.add('hidden')" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-ocean-500 text-white rounded-lg hover:bg-ocean-600">Add Expense</button>
                        </div>
                    </form>
                </div>

                <!-- Expenses -->
                <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                    @if($budget->expenses->count() > 0)
                        @foreach($budget->expenses as $expense)
                            <div class="p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <h4 class="font-semibold text-gray-900">{{ $expense->title }}</h4>
                                            <span class="px-2 py-1 bg-gray-100 rounded-full text-xs font-semibold">{{ $expense->category }}</span>
                                        </div>
                                        @if($expense->description)
                                            <p class="text-sm text-gray-600 mb-1">{{ Str::limit($expense->description, 80) }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500">
                                            <i class="fas fa-calendar mr-1"></i>{{ $expense->expense_date->format('M j, Y') }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-3 ml-4">
                                        <span class="text-lg font-bold text-ocean-600">{{ $budget->currency }} {{ number_format($expense->amount, 2) }}</span>
                                        <form action="{{ route('budgets.expenses.destroy', [$budget, $expense->id]) }}" method="POST" onsubmit="return confirm('Delete this expense?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700 p-2">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="p-12 text-center">
                            <i class="fas fa-receipt text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-600">No expenses yet. Add your first expense!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Budget Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Budget Info</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Type</span>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold capitalize {{ $budget->type === 'group' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $budget->type }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Status</span>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold capitalize {{ $budget->status === 'active' ? 'bg-grass-100 text-grass-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $budget->status }}
                        </span>
                    </div>
                    @if($budget->itinerary)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Itinerary</span>
                            <span class="font-semibold">{{ $budget->itinerary->title }}</span>
                        </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Created</span>
                        <span>{{ $budget->created_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Expenses by Category -->
            @if($expensesByCategory->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">By Category</h3>
                    <div class="space-y-3">
                        @foreach($expensesByCategory as $categoryExpense)
                            @php
                                $catPercentage = $stats['total_spent'] > 0 ? ($categoryExpense->total / $stats['total_spent']) * 100 : 0;
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-700">{{ $categoryExpense->category }}</span>
                                    <span class="text-sm font-semibold">{{ $budget->currency }} {{ number_format($categoryExpense->total, 2) }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full bg-ocean-500" style="width: {{ $catPercentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
