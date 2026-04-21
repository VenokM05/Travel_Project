<x-app-layout>

{{-- Instagram-style Itinerary Edit View --}}
<div class="max-w-2xl mx-auto px-4">

    {{-- Back + Header --}}
    <div class="flex items-center justify-between py-6 border-b border-[#DBDBDB] -mx-4 px-4">
        <div class="flex items-center space-x-3">
            <a href="{{ route('itineraries.show', $itinerary) }}" class="text-gray-800 hover:text-gray-600 transition-colors">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-900 leading-tight">Edit Itinerary</h1>
                <p class="text-sm text-gray-500">Update your trip details</p>
            </div>
        </div>
        <a href="{{ route('itineraries.show', $itinerary) }}"
           class="text-sm font-semibold text-gray-800 hover:text-gray-600 px-4 py-2 rounded-lg transition-colors">
            View Trip
        </a>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div id="flash-msg" class="mt-4 bg-[#d4edda] border border-[#c3e6cb] text-[#155724] text-sm px-4 py-3 rounded-lg flex items-center justify-between">
            <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
            <button onclick="document.getElementById('flash-msg').remove()" class="text-[#155724] opacity-60 hover:opacity-100">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="mt-4 bg-[#f8d7da] border border-[#f5c6cb] text-[#721c24] text-sm px-4 py-3 rounded-lg">
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                <li><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Edit Form --}}
    <form action="{{ route('itineraries.update', $itinerary) }}" method="POST" class="mt-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">

            {{-- Title --}}
            <div class="ig-card p-5">
                <label for="title" class="block text-sm font-semibold text-gray-900 mb-3">
                    Trip Title <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="title"
                       id="title"
                       required
                       value="{{ old('title', $itinerary->title) }}"
                       placeholder="e.g., Summer Vacation in Bali"
                       class="ig-input w-full @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Destination --}}
            <div class="ig-card p-5">
                <label for="destination" class="block text-sm font-semibold text-gray-900 mb-3">
                    Destination <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="destination"
                       id="destination"
                       required
                       value="{{ old('destination', $itinerary->destination) }}"
                       placeholder="e.g., Bali, Indonesia"
                       class="ig-input w-full @error('destination') border-red-500 @enderror">
                @error('destination')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Date Range --}}
            <div class="ig-card p-5">
                <label class="block text-sm font-semibold text-gray-900 mb-3">
                    Travel Dates <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-xs text-gray-500 mb-1.5">Start Date</label>
                        <input type="date"
                               name="start_date"
                               id="start_date"
                               required
                               value="{{ old('start_date', $itinerary->start_date->format('Y-m-d')) }}"
                               class="ig-input w-full @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_date" class="block text-xs text-gray-500 mb-1.5">End Date</label>
                        <input type="date"
                               name="end_date"
                               id="end_date"
                               required
                               value="{{ old('end_date', $itinerary->end_date->format('Y-m-d')) }}"
                               class="ig-input w-full @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Budget + Status --}}
            <div class="grid grid-cols-2 gap-4">
                {{-- Budget --}}
                <div class="ig-card p-5">
                    <label for="budget_total" class="block text-sm font-semibold text-gray-900 mb-3">
                        Total Budget
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">$</span>
                        <input type="number"
                               name="budget_total"
                               id="budget_total"
                               step="0.01"
                               min="0"
                               value="{{ old('budget_total', $itinerary->budget_total) }}"
                               placeholder="0.00"
                               class="ig-input w-full pl-7 @error('budget_total') border-red-500 @enderror">
                    </div>
                    @error('budget_total')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="ig-card p-5">
                    <label for="status" class="block text-sm font-semibold text-gray-900 mb-3">
                        Status
                    </label>
                    <select name="status"
                            id="status"
                            class="ig-input w-full @error('status') border-red-500 @enderror">
                        <option value="draft" {{ old('status', $itinerary->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="active" {{ old('status', $itinerary->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ old('status', $itinerary->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $itinerary->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="ig-card p-5">
                <label for="description" class="block text-sm font-semibold text-gray-900 mb-3">
                    Description
                </label>
                <textarea name="description"
                          id="description"
                          rows="4"
                          placeholder="Describe your trip..."
                          class="ig-input w-full resize-none @error('description') border-red-500 @enderror">{{ old('description', $itinerary->description) }}</textarea>
                <div class="flex items-center justify-between mt-2">
                    <p class="text-xs text-gray-500">Add details about your trip</p>
                    <span id="char-count" class="text-xs text-gray-400">{{ strlen(old('description', $itinerary->description ?? '')) }}/1000</span>
                </div>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end space-x-3 pt-4 pb-8">
                <a href="{{ route('itineraries.show', $itinerary) }}"
                   class="px-6 py-2.5 border border-[#DBDBDB] rounded-lg text-sm font-semibold text-gray-800 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="ig-btn px-6 py-2.5">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </div>

        </div>{{-- /.space-y --}}
    </form>

</div>{{-- /.max-w --}}

@push('scripts')
<script>
    // Character counter for description
    const textarea = document.getElementById('description');
    const counter = document.getElementById('char-count');
    if (textarea && counter) {
        textarea.addEventListener('input', function() {
            const len = this.value.length;
            counter.textContent = len + '/1000';
            counter.classList.toggle('text-red-500', len > 1000);
        });
    }
</script>
@endpush

</x-app-layout>
