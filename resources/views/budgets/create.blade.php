<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('budgets.index') }}" class="text-ocean-600 hover:text-ocean-700 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h2 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-plus-circle text-ocean-500 mr-3"></i>Create New Budget
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('budgets.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            @csrf
            
            <div class="space-y-6">
                <!-- Budget Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Budget Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                           placeholder="e.g., Bali Trip Budget"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 @error('name') border-red-500 @enderror">
                    @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="3"
                              placeholder="Budget description..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Budget Amount & Currency -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="total_budget" class="block text-sm font-semibold text-gray-700 mb-2">
                            Total Budget <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="total_budget" id="total_budget" required min="0" step="0.01" value="{{ old('total_budget') }}"
                               placeholder="5000"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 @error('total_budget') border-red-500 @enderror">
                        @error('total_budget')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="currency" class="block text-sm font-semibold text-gray-700 mb-2">
                            Currency <span class="text-red-500">*</span>
                        </label>
                        <select name="currency" id="currency" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 @error('currency') border-red-500 @enderror">
                            <option value="USD" {{ old('currency', 'USD') === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                            <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                            <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                            <option value="PHP" {{ old('currency') === 'PHP' ? 'selected' : '' }}>PHP - Philippine Peso</option>
                            <option value="AUD" {{ old('currency') === 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                        </select>
                        @error('currency')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Budget Type -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Budget Type <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="border-2 rounded-lg p-4 cursor-pointer transition-all hover:border-ocean-500 has-[:checked]:border-ocean-500 has-[:checked]:bg-ocean-50">
                            <input type="radio" name="type" value="solo" {{ old('type', 'solo') === 'solo' ? 'checked' : '' }} class="hidden">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Solo Budget</p>
                                    <p class="text-xs text-gray-600">Personal expenses tracking</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="border-2 rounded-lg p-4 cursor-pointer transition-all hover:border-ocean-500 has-[:checked]:border-ocean-500 has-[:checked]:bg-ocean-50">
                            <input type="radio" name="type" value="group" {{ old('type') === 'group' ? 'checked' : '' }} class="hidden">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-users text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Group Budget</p>
                                    <p class="text-xs text-gray-600">Split expenses with friends</p>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('type')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Link to Itinerary -->
                <div>
                    <label for="itinerary_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Link to Itinerary (Optional)
                    </label>
                    <select name="itinerary_id" id="itinerary_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-ocean-500 @error('itinerary_id') border-red-500 @enderror">
                        <option value="">No itinerary</option>
                        @foreach($itineraries as $itinerary)
                            <option value="{{ $itinerary->id }}" {{ old('itinerary_id') == $itinerary->id ? 'selected' : '' }}>
                                {{ $itinerary->title }} - {{ $itinerary->destination }}
                            </option>
                        @endforeach
                    </select>
                    @error('itinerary_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Group Splits (shown when group type selected) -->
                <div id="group-splits" class="hidden">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Split Between Users (Optional)
                    </label>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-3">Select users to split this budget with:</p>
                        <div class="space-y-2 max-h-40 overflow-y-auto">
                            @foreach($users as $user)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="split_users[]" value="{{ $user->id }}" class="rounded">
                                    <span class="text-sm">{{ $user->name }} ({{ $user->email }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('budgets.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 bg-ocean-500 text-white rounded-lg hover:bg-ocean-600 transition-colors font-medium">
                        <i class="fas fa-save mr-2"></i>Create Budget
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        const typeRadios = document.querySelectorAll('input[name="type"]');
        const groupSplits = document.getElementById('group-splits');
        
        typeRadios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                if (e.target.value === 'group') {
                    groupSplits.classList.remove('hidden');
                } else {
                    groupSplits.classList.add('hidden');
                }
            });
        });
        
        // Show on load if group is selected
        if (document.querySelector('input[name="type"]:checked')?.value === 'group') {
            groupSplits.classList.remove('hidden');
        }
    </script>
    @endpush
</x-app-layout>
