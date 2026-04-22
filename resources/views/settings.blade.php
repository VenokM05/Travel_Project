<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-cog text-ocean-500 mr-3"></i>Settings
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Account Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-[#DBDBDB] overflow-hidden">
            <div class="px-6 py-4 border-b border-[#DBDBDB] bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-user-circle text-ocean-500 mr-2"></i>Account Settings
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <div>
                        <p class="font-medium text-gray-900">Profile Information</p>
                        <p class="text-sm text-gray-600">Update your name, username, and bio</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="ig-btn">
                        Edit Profile
                    </a>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <div>
                        <p class="font-medium text-gray-900">Password</p>
                        <p class="text-sm text-gray-600">Change your password</p>
                    </div>
                    <button onclick="showToast('Navigate to Profile to change password')" class="ig-btn">
                        Change Password
                    </button>
                </div>
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-medium text-gray-900">Avatar</p>
                        <p class="text-sm text-gray-600">Update your profile picture</p>
                    </div>
                    <button onclick="showToast('Navigate to Profile to update avatar')" class="ig-btn">
                        Update Avatar
                    </button>
                </div>
            </div>
        </div>

        <!-- Notification Preferences -->
        <div class="bg-white rounded-xl shadow-sm border border-[#DBDBDB] overflow-hidden">
            <div class="px-6 py-4 border-b border-[#DBDBDB] bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-bell text-yellow-500 mr-2"></i>Notification Preferences
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('profile.preferences') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <p class="font-medium text-gray-900">Email Notifications</p>
                                <p class="text-sm text-gray-600">Receive updates via email</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="notification_email" value="1" 
                                       {{ auth()->user()->notification_email ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-ocean-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-ocean-500"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <p class="font-medium text-gray-900">Push Notifications</p>
                                <p class="text-sm text-gray-600">Browser push notifications</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="notification_push" value="1"
                                       {{ auth()->user()->notification_push ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-ocean-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-ocean-500"></div>
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="ig-btn">
                            <i class="fas fa-save mr-2"></i>Save Preferences
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Privacy Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-[#DBDBDB] overflow-hidden">
            <div class="px-6 py-4 border-b border-[#DBDBDB] bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-shield-alt text-grass-500 mr-2"></i>Privacy Settings
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('profile.preferences') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="space-y-4">
                        <div class="py-3 border-b border-gray-100">
                            <p class="font-medium text-gray-900 mb-2">Profile Privacy</p>
                            <p class="text-sm text-gray-600 mb-3">Control who can see your profile</p>
                            <div class="flex space-x-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="profile_privacy" value="public" 
                                           {{ auth()->user()->profile_privacy === 'public' ? 'checked' : '' }}
                                           class="w-4 h-4 text-ocean-500 border-gray-300 focus:ring-ocean-500">
                                    <span class="ml-2 text-sm text-gray-700">Public</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="profile_privacy" value="private"
                                           {{ auth()->user()->profile_privacy === 'private' ? 'checked' : '' }}
                                           class="w-4 h-4 text-ocean-500 border-gray-300 focus:ring-ocean-500">
                                    <span class="ml-2 text-sm text-gray-700">Private</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="py-3">
                            <p class="font-medium text-gray-900 mb-2">Default Post Privacy</p>
                            <p class="text-sm text-gray-600 mb-3">Default visibility for new posts</p>
                            <div class="flex space-x-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="default_post_privacy" value="public"
                                           {{ auth()->user()->default_post_privacy === 'public' ? 'checked' : '' }}
                                           class="w-4 h-4 text-ocean-500 border-gray-300 focus:ring-ocean-500">
                                    <span class="ml-2 text-sm text-gray-700">Public</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="default_post_privacy" value="followers"
                                           {{ auth()->user()->default_post_privacy === 'followers' ? 'checked' : '' }}
                                           class="w-4 h-4 text-ocean-500 border-gray-300 focus:ring-ocean-500">
                                    <span class="ml-2 text-sm text-gray-700">Followers Only</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="default_post_privacy" value="private"
                                           {{ auth()->user()->default_post_privacy === 'private' ? 'checked' : '' }}
                                           class="w-4 h-4 text-ocean-500 border-gray-300 focus:ring-ocean-500">
                                    <span class="ml-2 text-sm text-gray-700">Private</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="ig-btn">
                            <i class="fas fa-save mr-2"></i>Save Privacy Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Subscription & Storage -->
        <div class="bg-white rounded-xl shadow-sm border border-[#DBDBDB] overflow-hidden">
            <div class="px-6 py-4 border-b border-[#DBDBDB] bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-crown text-yellow-500 mr-2"></i>Subscription & Storage
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <div>
                        <p class="font-medium text-gray-900">Current Plan</p>
                        <p class="text-sm text-gray-600">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                {{ auth()->user()->subscription_tier === 'premium' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ auth()->user()->subscription_tier === 'pro' ? 'bg-ocean-100 text-ocean-800' : '' }}
                                {{ auth()->user()->subscription_tier === 'free' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst(auth()->user()->subscription_tier) }}
                            </span>
                        </p>
                    </div>
                    <a href="{{ route('subscription.plans') }}" class="ig-btn">
                        Upgrade Plan
                    </a>
                </div>
                
                <div class="py-3">
                    <p class="font-medium text-gray-900 mb-2">Storage Usage</p>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600">{{ auth()->user()->storage_used ?? 0 }} GB of {{ auth()->user()->getStorageLimit() }} GB used</span>
                        <span class="text-sm font-medium text-ocean-600">{{ number_format((auth()->user()->storage_used ?? 0) / auth()->user()->getStorageLimit() * 100, 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-gradient-to-r from-ocean-500 to-grass-500 h-2.5 rounded-full" 
                             style="width: {{ min(100, (auth()->user()->storage_used ?? 0) / auth()->user()->getStorageLimit() * 100) }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">{{ auth()->user()->getStorageRemaining() }} GB remaining</p>
                </div>
            </div>
        </div>

        <!-- Travel Preferences -->
        <div class="bg-white rounded-xl shadow-sm border border-[#DBDBDB] overflow-hidden">
            <div class="px-6 py-4 border-b border-[#DBDBDB] bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-plane text-ocean-500 mr-2"></i>Travel Preferences
                </h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">Customize your travel planning experience</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 border border-gray-200 rounded-lg hover:border-ocean-300 transition-colors cursor-pointer">
                        <i class="fas fa-dollar-sign text-2xl text-grass-500 mb-2"></i>
                        <p class="font-medium text-gray-900">Default Currency</p>
                        <p class="text-sm text-gray-600">Set your preferred currency for budgets</p>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg hover:border-ocean-300 transition-colors cursor-pointer">
                        <i class="fas fa-calendar text-2xl text-ocean-500 mb-2"></i>
                        <p class="font-medium text-gray-900">Date Format</p>
                        <p class="text-sm text-gray-600">Choose your preferred date format</p>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg hover:border-ocean-300 transition-colors cursor-pointer">
                        <i class="fas fa-map-marker-alt text-2xl text-red-500 mb-2"></i>
                        <p class="font-medium text-gray-900">Distance Units</p>
                        <p class="text-sm text-gray-600">Metric or Imperial units</p>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg hover:border-ocean-300 transition-colors cursor-pointer">
                        <i class="fas fa-clock text-2xl text-yellow-500 mb-2"></i>
                        <p class="font-medium text-gray-900">Time Zone</p>
                        <p class="text-sm text-gray-600">Set your local time zone</p>
                    </div>
                </div>
                <div class="mt-4 p-4 bg-ocean-50 border border-ocean-200 rounded-lg">
                    <p class="text-sm text-ocean-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Travel preferences will be available in a future update. Stay tuned!
                    </p>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="bg-white rounded-xl shadow-sm border-2 border-red-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-red-200 bg-red-50">
                <h3 class="text-lg font-semibold text-red-600">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Danger Zone
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <div>
                        <p class="font-medium text-gray-900">Delete All Data</p>
                        <p class="text-sm text-gray-600">Remove all your itineraries, budgets, and memories</p>
                    </div>
                    <button onclick="showToast('This feature is disabled for safety')" class="px-4 py-2 border-2 border-red-500 text-red-600 rounded-lg font-medium hover:bg-red-50 transition-colors">
                        Delete Data
                    </button>
                </div>
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-medium text-gray-900">Delete Account</p>
                        <p class="text-sm text-gray-600">Permanently delete your account and all data</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition-colors">
                        Delete Account
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
