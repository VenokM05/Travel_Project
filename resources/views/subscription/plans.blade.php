<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-crown text-yellow-500 mr-3"></i>Upgrade Your Plan
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Choose the Perfect Plan for Your Travels</h3>
            <p class="text-gray-600">Unlock premium features and make your travel planning effortless</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Free Plan -->
            <div class="bg-white rounded-xl shadow-sm border-2 border-gray-200 p-8">
                <h4 class="text-2xl font-bold text-gray-900 mb-2">Free</h4>
                <p class="text-gray-600 mb-6">Perfect for getting started</p>
                <div class="mb-6">
                    <span class="text-5xl font-bold text-gray-900">$0</span>
                    <span class="text-gray-600">/month</span>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-grass-500 mr-3"></i>
                        <span>Up to 3 trips</span>
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-grass-500 mr-3"></i>
                        <span>1 GB storage</span>
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-grass-500 mr-3"></i>
                        <span>Basic budget tracking</span>
                    </li>
                    <li class="flex items-center text-gray-400">
                        <i class="fas fa-times mr-3"></i>
                        <span>No priority support</span>
                    </li>
                </ul>
                <button class="w-full py-3 border-2 border-ocean-500 text-ocean-600 rounded-lg font-medium hover:bg-ocean-50 transition-colors">
                    Current Plan
                </button>
            </div>

            <!-- Pro Plan -->
            <div class="bg-gradient-to-br from-ocean-500 to-grass-600 rounded-xl shadow-xl p-8 text-white transform scale-105">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-yellow-400 text-gray-900 px-4 py-1 rounded-full text-sm font-bold">
                        POPULAR
                    </span>
                </div>
                <h4 class="text-2xl font-bold mb-2">Pro</h4>
                <p class="mb-6 text-white text-opacity-90">For frequent travelers</p>
                <div class="mb-6">
                    <span class="text-5xl font-bold">$9.99</span>
                    <span class="text-white text-opacity-90">/month</span>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-yellow-300 mr-3"></i>
                        <span>Unlimited trips</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-yellow-300 mr-3"></i>
                        <span>10 GB storage</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-yellow-300 mr-3"></i>
                        <span>Group budget splits</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-yellow-300 mr-3"></i>
                        <span>Priority support</span>
                    </li>
                </ul>
                <button class="w-full py-3 bg-white text-ocean-600 rounded-lg font-bold hover:bg-cloud-50 transition-colors">
                    Upgrade to Pro
                </button>
            </div>

            <!-- Premium Plan -->
            <div class="bg-white rounded-xl shadow-sm border-2 border-gray-200 p-8">
                <h4 class="text-2xl font-bold text-gray-900 mb-2">Premium</h4>
                <p class="text-gray-600 mb-6">For travel enthusiasts</p>
                <div class="mb-6">
                    <span class="text-5xl font-bold text-gray-900">$19.99</span>
                    <span class="text-gray-600">/month</span>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-grass-500 mr-3"></i>
                        <span>Everything in Pro</span>
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-grass-500 mr-3"></i>
                        <span>50 GB storage</span>
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-grass-500 mr-3"></i>
                        <span>Advanced analytics</span>
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-grass-500 mr-3"></i>
                        <span>API access</span>
                    </li>
                </ul>
                <button class="w-full py-3 border-2 border-ocean-500 text-ocean-600 rounded-lg font-medium hover:bg-ocean-50 transition-colors">
                    Upgrade to Premium
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
