<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('itineraries.index') }}" class="text-ocean-600 hover:text-ocean-700 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h2 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-plus-circle text-ocean-500 mr-3"></i>Create New Itinerary
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('itineraries.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            @csrf
            
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Trip Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           required
                           value="{{ old('title') }}"
                           placeholder="e.g., Summer Vacation in Bali"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Destination -->
                <div>
                    <label for="destination" class="block text-sm font-semibold text-gray-700 mb-2">
                        Destination <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="destination" 
                           id="destination" 
                           required
                           value="{{ old('destination') }}"
                           placeholder="e.g., Bali, Indonesia"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('destination') border-red-500 @enderror">
                    @error('destination')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Start Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="start_date" 
                               id="start_date" 
                               required
                               value="{{ old('start_date') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            End Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="end_date" 
                               id="end_date" 
                               required
                               value="{{ old('end_date') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Budget -->
                <div>
                    <label for="budget_total" class="block text-sm font-semibold text-gray-700 mb-2">
                        Total Budget
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                        <input type="number" 
                               name="budget_total" 
                               id="budget_total" 
                               step="0.01"
                               min="0"
                               value="{{ old('budget_total', 0) }}"
                               placeholder="0.00"
                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('budget_total') border-red-500 @enderror">
                    </div>
                    @error('budget_total')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status
                    </label>
                    <select name="status" 
                            id="status" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('status') border-red-500 @enderror">
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              placeholder="Describe your trip..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('itineraries.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 bg-ocean-500 text-white rounded-lg hover:bg-ocean-600 transition-colors font-medium">
                        <i class="fas fa-save mr-2"></i>Create Itinerary
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
