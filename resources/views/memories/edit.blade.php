<x-app-layout>

{{-- Instagram-style Memory Edit Form --}}
<div class="max-w-2xl mx-auto px-4">

    {{-- Header --}}
    <div class="flex items-center justify-between py-6 border-b border-[#DBDBDB] -mx-4 px-4">
        <div class="flex items-center space-x-3">
            <a href="{{ route('memories.show', $memory) }}" class="text-gray-800 hover:text-gray-600 transition-colors">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-900 leading-tight">Edit Memory</h1>
                <p class="text-sm text-gray-500">Update your travel moment</p>
            </div>
        </div>
        <a href="{{ route('memories.show', $memory) }}"
           class="text-sm font-semibold text-gray-800 hover:text-gray-600 px-4 py-2 rounded-lg transition-colors">
            View Memory
        </a>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div id="flash-msg" class="mt-4 bg-[#d4edda] border border-[#c3e6cb] text-[#155724] text-sm px-4 py-3 rounded-lg">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
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

    {{-- Form --}}
    <form action="{{ route('memories.update', $memory) }}" method="POST" class="mt-6" x-data="{
        mood: '{{ old('mood', $memory->mood ?? '') }}'
    }">
        @csrf
        @method('PUT')

        <div class="space-y-6">

            {{-- Title --}}
            <div class="ig-card p-5">
                <label for="title" class="block text-sm font-semibold text-gray-900 mb-3">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="title"
                       id="title"
                       required
                       value="{{ old('title', $memory->title) }}"
                       placeholder="e.g., Amazing Sunset in Santorini"
                       class="ig-input w-full @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Location + Date --}}
            <div class="grid grid-cols-2 gap-4">
                {{-- Location --}}
                <div class="ig-card p-5">
                    <label for="location" class="block text-sm font-semibold text-gray-900 mb-3">
                        <i class="fas fa-map-marker-alt mr-1 text-gray-400"></i>Location
                    </label>
                    <input type="text"
                           name="location"
                           id="location"
                           value="{{ old('location', $memory->location) }}"
                           placeholder="e.g., Santorini, Greece"
                           class="ig-input w-full @error('location') border-red-500 @enderror">
                    @error('location')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Date --}}
                <div class="ig-card p-5">
                    <label for="date" class="block text-sm font-semibold text-gray-900 mb-3">
                        <i class="fas fa-calendar mr-1 text-gray-400"></i>Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           name="date"
                           id="date"
                           required
                           value="{{ old('date', $memory->date->format('Y-m-d')) }}"
                           class="ig-input w-full @error('date') border-red-500 @enderror">
                    @error('date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Mood Selector --}}
            <div class="ig-card p-5">
                <label class="block text-sm font-semibold text-gray-900 mb-3">
                    <i class="fas fa-smile mr-1 text-gray-400"></i>How did you feel?
                </label>
                <div class="grid grid-cols-6 gap-3">
                    @php
                        $moods = [
                            ['value' => '😊', 'label' => 'Happy'],
                            ['value' => '🥰', 'label' => 'Loved'],
                            ['value' => '😍', 'label' => 'Amazed'],
                            ['value' => '😎', 'label' => 'Cool'],
                            ['value' => '🤩', 'label' => 'Excited'],
                            ['value' => '😌', 'label' => 'Peaceful'],
                            ['value' => '🥳', 'label' => 'Celebrating'],
                            ['value' => '😴', 'label' => 'Relaxed'],
                            ['value' => '🤔', 'label' => 'Thoughtful'],
                            ['value' => '😢', 'label' => 'Emotional'],
                            ['value' => '🙏', 'label' => 'Grateful'],
                            ['value' => '💪', 'label' => 'Adventurous'],
                        ];
                    @endphp
                    @foreach($moods as $mood)
                    <button type="button"
                            @click="mood = '{{ $mood['value'] }}'"
                            :class="mood === '{{ $mood['value'] }}' ? 'ring-2 ring-ocean-500 bg-ocean-50' : 'bg-gray-50 hover:bg-gray-100'"
                            class="flex flex-col items-center p-3 rounded-lg transition-all">
                        <span class="text-2xl mb-1">{{ $mood['value'] }}</span>
                        <span class="text-[10px] text-gray-600">{{ $mood['label'] }}</span>
                    </button>
                    @endforeach
                </div>
                <input type="hidden" name="mood" x-model="mood">
            </div>

            {{-- Description --}}
            <div class="ig-card p-5">
                <label for="description" class="block text-sm font-semibold text-gray-900 mb-3">
                    <i class="fas fa-align-left mr-1 text-gray-400"></i>Story
                </label>
                <textarea name="description"
                          id="description"
                          rows="4"
                          placeholder="Tell the story behind this moment..."
                          class="ig-input w-full resize-none @error('description') border-red-500 @enderror">{{ old('description', $memory->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Link to Itinerary --}}
            <div class="ig-card p-5">
                <label for="itinerary_id" class="block text-sm font-semibold text-gray-900 mb-3">
                    <i class="fas fa-route mr-1 text-gray-400"></i>Link to Trip (Optional)
                </label>
                <select name="itinerary_id"
                        id="itinerary_id"
                        class="ig-input w-full">
                    <option value="">Select a trip...</option>
                    @foreach($itineraries as $itinerary)
                    <option value="{{ $itinerary->id }}" {{ old('itinerary_id', $memory->itinerary_id) == $itinerary->id ? 'selected' : '' }}>
                        {{ $itinerary->title }} ({{ $itinerary->destination }})
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Existing Photos --}}
            @if($memory->media_urls && count($memory->media_urls) > 0)
            <div class="ig-card p-5">
                <label class="block text-sm font-semibold text-gray-900 mb-3">
                    <i class="fas fa-images mr-1 text-gray-400"></i>Current Photos
                </label>
                <div class="grid grid-cols-4 gap-2">
                    @foreach($memory->media_urls as $url)
                    <div class="relative aspect-square rounded-lg overflow-hidden bg-gray-100">
                        <img src="{{ $url }}" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end space-x-3 pt-4 pb-8">
                <a href="{{ route('memories.show', $memory) }}"
                   class="px-6 py-2.5 border border-[#DBDBDB] rounded-lg text-sm font-semibold text-gray-800 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="ig-btn px-6 py-2.5">
                    <i class="fas fa-save mr-2"></i>Update Memory
                </button>
            </div>

        </div>{{-- /.space-y --}}
    </form>

</div>{{-- /.max-w --}}

</x-app-layout>
