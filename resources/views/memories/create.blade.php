<x-app-layout>

{{-- Instagram-style Memory Create Form --}}
<div class="max-w-2xl mx-auto px-4">

    {{-- Header --}}
    <div class="flex items-center justify-between py-6 border-b border-[#DBDBDB] -mx-4 px-4">
        <div class="flex items-center space-x-3">
            <a href="{{ route('memories.index') }}" class="text-gray-800 hover:text-gray-600 transition-colors">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-900 leading-tight">Create Memory</h1>
                <p class="text-sm text-gray-500">Capture your travel moment</p>
            </div>
        </div>
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
    <form action="{{ route('memories.store') }}" method="POST" class="mt-6" x-data="{
        ...photoUploader(),
        mood: '{{ old('mood', '') }}'
    }">
        @csrf

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
                       value="{{ old('title') }}"
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
                           value="{{ old('location') }}"
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
                           value="{{ old('date', now()->format('Y-m-d')) }}"
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
                          class="ig-input w-full resize-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
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
                    <option value="{{ $itinerary->id }}" {{ old('itinerary_id') == $itinerary->id ? 'selected' : '' }}>
                        {{ $itinerary->title }} ({{ $itinerary->destination }})
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Photo Upload --}}
            <div class="ig-card p-5">
                <label class="block text-sm font-semibold text-gray-900 mb-3">
                    <i class="fas fa-camera mr-1 text-gray-400"></i>Photos
                </label>
                
                {{-- Upload Area --}}
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-ocean-500 transition-colors cursor-pointer"
                     @click="$refs.photoInput.click()"
                     @dragover.prevent="dragOver = true"
                     @dragleave.prevent="dragOver = false"
                     @drop.prevent="handleDrop($event)"
                     :class="dragOver ? 'border-ocean-500 bg-ocean-50' : ''">
                    <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                    <p class="text-sm text-gray-600 mb-1">Click or drag photos here</p>
                    <p class="text-xs text-gray-400">JPG, PNG, WebP (max 5MB each)</p>
                    <input type="file"
                           x-ref="photoInput"
                           id="photo-upload"
                           multiple
                           accept="image/*"
                           class="hidden"
                           @change="handleFileSelect($event)">
                </div>

                {{-- Upload Progress --}}
                <div x-show="uploading" class="mt-4" style="display: none;">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-gray-600">Uploading...</span>
                        <span class="text-xs text-gray-600" x-text="uploadProgress + '%'"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-ocean-500 h-2 rounded-full transition-all duration-300" 
                             :style="'width: ' + uploadProgress + '%'"></div>
                    </div>
                </div>

                {{-- Preview Grid --}}
                <template x-if="uploadedPhotos.length > 0">
                    <div class="grid grid-cols-4 gap-2 mt-4">
                        <template x-for="(photo, index) in uploadedPhotos" :key="photo.id">
                            <div class="relative aspect-square rounded-lg overflow-hidden bg-gray-100 group">
                                <img :src="photo.url" class="w-full h-full object-cover">
                                
                                {{-- Upload overlay --}}
                                <div x-show="photo.uploading" 
                                     class="absolute inset-0 bg-black/50 flex items-center justify-center"
                                     style="display: none;">
                                    <div class="text-white text-center">
                                        <i class="fas fa-spinner fa-spin text-2xl mb-1"></i>
                                        <p class="text-xs" x-text="photo.progress + '%'"></p>
                                    </div>
                                </div>
                                
                                {{-- Remove button --}}
                                <button type="button"
                                        @click="removePhoto(index)"
                                        class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </template>

                <p class="text-xs text-gray-500 mt-3">
                    <i class="fas fa-info-circle mr-1"></i>
                    Photos are uploaded immediately when selected
                </p>
            </div>

            {{-- Hidden field for media_urls (populated by AJAX uploads) --}}
            <input type="hidden" name="media_urls[]" id="media_urls" value="">

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end space-x-3 pt-4 pb-8">
                <a href="{{ route('memories.index') }}"
                   class="px-6 py-2.5 border border-[#DBDBDB] rounded-lg text-sm font-semibold text-gray-800 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="ig-btn px-6 py-2.5">
                    <i class="fas fa-save mr-2"></i>Save Memory
                </button>
            </div>

        </div>{{-- /.space-y --}}
    </form>

</div>{{-- /.max-w --}}

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('photoUploader', () => ({
            uploadedPhotos: [],
            uploading: false,
            uploadProgress: 0,
            dragOver: false,
            photoCounter: 0,
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

            handleFileSelect(event) {
                const files = Array.from(event.target.files);
                this.uploadFiles(files);
                // Reset input so same file can be selected again
                event.target.value = '';
            },

            handleDrop(event) {
                this.dragOver = false;
                const files = Array.from(event.dataTransfer.files).filter(f => f.type.startsWith('image/'));
                this.uploadFiles(files);
            },

            async uploadFiles(files) {
                for (const file of files) {
                    // Validate file size (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        this.showToast(`File ${file.name} is too large (max 5MB)`, 'error');
                        continue;
                    }

                    const photoId = ++this.photoCounter;
                    const photo = {
                        id: photoId,
                        file: file,
                        url: URL.createObjectURL(file),
                        uploading: true,
                        progress: 0,
                        serverUrl: null
                    };

                    this.uploadedPhotos.push(photo);
                    await this.uploadSinglePhoto(photo);
                }
                this.updateMediaUrlsField();
            },

            async uploadSinglePhoto(photo) {
                const formData = new FormData();
                formData.append('file', photo.file);
                formData.append('type', 'image');

                try {
                    const response = await fetch('/upload/photo', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        photo.serverUrl = result.url;
                        photo.uploading = false;
                        photo.progress = 100;
                        this.showToast('Photo uploaded successfully', 'success');
                    } else {
                        throw new Error(result.message || 'Upload failed');
                    }
                } catch (error) {
                    console.error('Upload error:', error);
                    photo.uploading = false;
                    photo.error = true;
                    this.showToast(error.message || 'Upload failed', 'error');
                }
            },

            async removePhoto(index) {
                const photo = this.uploadedPhotos[index];
                
                // If photo was uploaded to server, delete it
                if (photo.serverUrl) {
                    try {
                        const response = await fetch('/upload/photo', {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ url: photo.serverUrl })
                        });

                        const result = await response.json();
                        if (result.success) {
                            this.showToast('Photo removed', 'success');
                        }
                    } catch (error) {
                        console.error('Delete error:', error);
                    }
                }

                // Remove from array
                this.uploadedPhotos.splice(index, 1);
                this.updateMediaUrlsField();
            },

            updateMediaUrlsField() {
                const urls = this.uploadedPhotos
                    .filter(p => p.serverUrl)
                    .map(p => p.serverUrl);
                
                const hiddenField = document.getElementById('media_urls');
                hiddenField.value = JSON.stringify(urls);
            },

            showToast(message, type = 'success') {
                const toast = document.createElement('div');
                const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
                const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
                
                toast.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2 animate-fade-in`;
                toast.innerHTML = `
                    <i class="fas ${icon}"></i>
                    <span>${message}</span>
                `;
                
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }
        }));
    });
</script>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>
@endpush

</x-app-layout>
