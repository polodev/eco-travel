<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.hotel_search') }}</x-slot>
    
    <!-- Hero Section with Background -->
    <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 min-h-[60vh] flex items-center">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
        
        <!-- Search Container -->
        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Text -->
            <div class="text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    {{ __('messages.search_hotels') }}
                </h1>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                    {{ __('messages.find_perfect_accommodation') }}
                </p>
            </div>

            <!-- Hotel Search Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6 md:p-8 max-w-5xl mx-auto">
                @volt('hotel-search')
                <div>
                    <form wire:submit="search">
                        <!-- Main Search Row -->
                        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-6">
                            <!-- Destination - Takes 2 columns -->
                            <div class="lg:col-span-2">
                                <label for="destination" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                                    {{ __('messages.destination') }}
                                </label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        id="destination"
                                        wire:model="destination"
                                        class="w-full px-4 py-3 pl-4 pr-10 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-lg"
                                        placeholder="{{ __('messages.enter_destination') }}"
                                        required
                                    >
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                                @error('destination') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Check-in Date -->
                            <div>
                                <label for="checkin_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-calendar-alt text-green-500 mr-2"></i>
                                    {{ __('messages.checkin_date') }}
                                </label>
                                <input 
                                    type="date" 
                                    id="checkin_date"
                                    wire:model="checkin_date"
                                    min="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                    required
                                >
                                @error('checkin_date') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Check-out Date -->
                            <div>
                                <label for="checkout_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-calendar-check text-red-500 mr-2"></i>
                                    {{ __('messages.checkout_date') }}
                                </label>
                                <input 
                                    type="date" 
                                    id="checkout_date"
                                    wire:model="checkout_date"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                    required
                                >
                                @error('checkout_date') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Guests & Rooms Combined -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-users text-purple-500 mr-2"></i>
                                    {{ __('messages.guests') }} & {{ __('messages.rooms') }}
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <select 
                                        id="guests"
                                        wire:model="guests"
                                        class="px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm"
                                        required
                                    >
                                        @for($i = 1; $i <= 8; $i++)
                                            <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? __('messages.guest') : __('messages.guests') }}</option>
                                        @endfor
                                    </select>
                                    <select 
                                        id="rooms"
                                        wire:model="rooms"
                                        class="px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm"
                                        required
                                    >
                                        @for($i = 1; $i <= 4; $i++)
                                            <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? __('messages.room') : __('messages.rooms') }}</option>
                                        @endfor
                                    </select>
                                </div>
                                @error('guests') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                                @error('rooms') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>
                        </div>

                        <!-- Secondary Options Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Star Rating -->
                            <div>
                                <label for="star_rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-star text-yellow-500 mr-2"></i>
                                    {{ __('messages.star_rating') }}
                                </label>
                                <select 
                                    id="star_rating"
                                    wire:model="star_rating"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                >
                                    <option value="">{{ __('messages.any_rating') }}</option>
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">
                                            @for($j = 1; $j <= $i; $j++)⭐@endfor 
                                            {{ $i }} {{ $i == 1 ? __('messages.star') : __('messages.stars') }}
                                        </option>
                                    @endfor
                                </select>
                                @error('star_rating') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Search Button -->
                            <div class="flex items-end">
                                <button 
                                    type="submit" 
                                    wire:loading.attr="disabled"
                                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 disabled:opacity-50 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center text-lg"
                                >
                                    <span wire:loading.remove class="flex items-center">
                                        <i class="fas fa-search mr-2"></i>
                                        {{ __('messages.search_hotels') }}
                                    </span>
                                    <span wire:loading class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        {{ __('messages.searching') }}...
                                    </span>
                                </button>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-shield-alt text-green-500 mr-1"></i>
                            Secure booking • Best price guarantee • Free cancellation available
                        </div>
                    </form>

                    <!-- Loading Overlay -->
                    <div wire:loading class="absolute inset-0 bg-white bg-opacity-75 dark:bg-gray-800 dark:bg-opacity-75 rounded-2xl flex items-center justify-center z-50">
                        <div class="text-center">
                            <div class="inline-flex items-center px-6 py-3 font-semibold leading-6 text-base shadow-lg rounded-xl text-blue-600 bg-blue-50 dark:bg-blue-900 dark:text-blue-300 transition ease-in-out duration-150">
                                <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-blue-600 dark:text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ __('messages.searching_hotels') }}...
                            </div>
                        </div>
                    </div>
                </div>
                @endvolt
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gray-50 dark:bg-gray-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Why Choose Our Hotel Booking?
                </h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Experience hassle-free hotel booking with the best deals and excellent service
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-dollar-sign text-2xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Best Price Guarantee</h3>
                    <p class="text-gray-600 dark:text-gray-400">Find lower prices elsewhere? We'll match it and give you an extra discount.</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-times text-2xl text-green-600 dark:text-green-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Free Cancellation</h3>
                    <p class="text-gray-600 dark:text-gray-400">Most bookings can be cancelled free of charge up to 24 hours before check-in.</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-2xl text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">24/7 Support</h3>
                    <p class="text-gray-600 dark:text-gray-400">Get help anytime, anywhere. Our customer support team is always ready to assist.</p>
                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>