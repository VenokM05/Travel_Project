<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('todos.index') }}" class="text-ocean-600 hover:text-ocean-700 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h2 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-plus-circle text-cloud-300 mr-3"></i>Add New Task
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('todos.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            @csrf
            
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Task Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           required
                           value="{{ old('title') }}"
                           placeholder="e.g., Book flight tickets"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('title') border-red-500 @enderror">
                    @error('title')
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
                              rows="3"
                              placeholder="Add details about this task..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority & Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="priority" class="block text-sm font-semibold text-gray-700 mb-2">
                            Priority <span class="text-red-500">*</span>
                        </label>
                        <select name="priority" 
                                id="priority" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('priority') border-red-500 @enderror">
                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                            <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                        @error('priority')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" 
                                id="status" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('status') border-red-500 @enderror">
                            <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Due Date & Category -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="due_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Due Date
                        </label>
                        <input type="date" 
                               name="due_date" 
                               id="due_date" 
                               value="{{ old('due_date') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('due_date') border-red-500 @enderror">
                        @error('due_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                            Category
                        </label>
                        <input type="text" 
                               name="category" 
                               id="category" 
                               value="{{ old('category') }}"
                               placeholder="e.g., Pre-trip, During trip"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('category') border-red-500 @enderror">
                        @error('category')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Link to Itinerary -->
                <div>
                    <label for="itinerary_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Link to Itinerary (Optional)
                    </label>
                    <select name="itinerary_id" 
                            id="itinerary_id" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent @error('itinerary_id') border-red-500 @enderror">
                        <option value="">No itinerary</option>
                        @foreach($itineraries as $itinerary)
                            <option value="{{ $itinerary->id }}" {{ old('itinerary_id') == $itinerary->id ? 'selected' : '' }}>
                                {{ $itinerary->title }} - {{ $itinerary->destination }}
                            </option>
                        @endforeach
                    </select>
                    @error('itinerary_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('todos.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 bg-ocean-500 text-white rounded-lg hover:bg-ocean-600 transition-colors font-medium">
                        <i class="fas fa-save mr-2"></i>Create Task
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
