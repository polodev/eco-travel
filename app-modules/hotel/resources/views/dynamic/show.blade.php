<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.hotel_details') }}</x-slot>
    
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(isset($hotel['data']))
                        @php $hotelData = $hotel['data']; @endphp
                        
                        <!-- Hotel Header -->
                        <div class="border-b border-gray-200 dark:border-gray-600 pb-6 mb-6">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-4">
                                <div class="flex-1">
                                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                        {{ $hotelData['name'] ?? 'Hotel Name' }}
                                    </h1>
                                    
                                    <!-- Star Rating -->
                                    @if(isset($hotelData['star_rating']))
                                        <div class="flex items-center mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $hotelData['star_rating'] ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                            @endfor
                                            <span class="ml-2 text-gray-600 dark:text-gray-400">
                                                {{ $hotelData['star_rating'] }} {{ __('messages.star_hotel') }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <!-- Location -->
                                    @if(isset($hotelData['address']) || isset($hotelData['city']))
                                        <div class="flex items-center text-gray-600 dark:text-gray-400 mb-2">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            <span>
                                                {{ $hotelData['address'] ?? '' }}
                                                @if(isset($hotelData['city']))
                                                    {{ $hotelData['address'] ? ', ' : '' }}
                                                    {{ is_array($hotelData['city']) ? $hotelData['city']['name'] : $hotelData['city'] }}
                                                @endif
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Reviews -->
                                    @if(isset($hotelData['average_rating']) && $hotelData['average_rating'] > 0)
                                        <div class="flex items-center">
                                            <div class="bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 px-3 py-1 rounded-lg font-medium">
                                                {{ number_format($hotelData['average_rating'], 1) }}/5
                                            </div>
                                            <span class="ml-2 text-gray-600 dark:text-gray-400">
                                                ({{ $hotelData['total_reviews'] ?? 0 }} {{ __('messages.reviews') }})
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Price Info -->
                                <div class="mt-4 lg:mt-0 text-center lg:text-right">
                                    @php
                                        $minPrice = 0;
                                        if (isset($hotelData['rooms']) && is_array($hotelData['rooms'])) {
                                            $minPrice = collect($hotelData['rooms'])->min('base_price') ?? 0;
                                        } elseif (isset($hotelData['minimum_price'])) {
                                            $minPrice = $hotelData['minimum_price'];
                                        }
                                    @endphp
                                    
                                    <div class="text-sm text-gray-500 mb-1">{{ __('messages.starting_from') }}</div>
                                    <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                                        ${{ number_format($minPrice, 2) }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ __('messages.per_night') }}</div>
                                </div>
                            </div>

                            @if(isset($hotel['fallback']) && $hotel['fallback'])
                                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-exclamation-triangle text-amber-500 mr-2"></i>
                                        <span class="text-amber-700 dark:text-amber-300 text-sm">
                                            {{ __('messages.showing_static_data_details') }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Hotel Images -->
                        @if(isset($hotelData['images']) && is_array($hotelData['images']) && count($hotelData['images']) > 0)
                            <div class="mb-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach(array_slice($hotelData['images'], 0, 6) as $index => $image)
                                        <div class="{{ $index === 0 ? 'md:col-span-2 md:row-span-2' : '' }}">
                                            <img src="{{ $image }}" 
                                                 alt="{{ $hotelData['name'] }} - Image {{ $index + 1 }}"
                                                 class="w-full h-64 {{ $index === 0 ? 'md:h-full' : '' }} object-cover rounded-lg">
                                        </div>
                                    @endforeach
                                </div>
                                @if(count($hotelData['images']) > 6)
                                    <button class="mt-2 text-blue-600 dark:text-blue-400 text-sm hover:underline">
                                        {{ __('messages.view_all_photos') }} ({{ count($hotelData['images']) }})
                                    </button>
                                @endif
                            </div>
                        @endif

                        <!-- Hotel Information Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                            <!-- Main Content -->
                            <div class="lg:col-span-2 space-y-8">
                                <!-- Description -->
                                @if(isset($hotelData['description']))
                                    <div>
                                        <h3 class="text-xl font-semibold mb-3">{{ __('messages.about_hotel') }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                            {{ $hotelData['description'] }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Amenities -->
                                @if(isset($hotelData['amenities']) && is_array($hotelData['amenities']) && count($hotelData['amenities']) > 0)
                                    <div>
                                        <h3 class="text-xl font-semibold mb-4">{{ __('messages.amenities') }}</h3>
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                            @foreach($hotelData['amenities'] as $amenity)
                                                <div class="flex items-center">
                                                    @switch($amenity)
                                                        @case('wifi')
                                                            <i class="fas fa-wifi text-blue-500 w-5"></i>
                                                            @break
                                                        @case('pool')
                                                            <i class="fas fa-swimming-pool text-blue-500 w-5"></i>
                                                            @break
                                                        @case('gym')
                                                            <i class="fas fa-dumbbell text-green-500 w-5"></i>
                                                            @break
                                                        @case('spa')
                                                            <i class="fas fa-spa text-pink-500 w-5"></i>
                                                            @break
                                                        @case('restaurant')
                                                            <i class="fas fa-utensils text-orange-500 w-5"></i>
                                                            @break
                                                        @case('bar')
                                                            <i class="fas fa-glass-martini-alt text-purple-500 w-5"></i>
                                                            @break
                                                        @case('parking')
                                                            <i class="fas fa-parking text-gray-500 w-5"></i>
                                                            @break
                                                        @case('airport_shuttle')
                                                            <i class="fas fa-shuttle-van text-blue-500 w-5"></i>
                                                            @break
                                                        @case('room_service')
                                                            <i class="fas fa-concierge-bell text-yellow-500 w-5"></i>
                                                            @break
                                                        @case('business_center')
                                                            <i class="fas fa-briefcase text-gray-600 w-5"></i>
                                                            @break
                                                        @case('pet_friendly')
                                                            <i class="fas fa-paw text-brown-500 w-5"></i>
                                                            @break
                                                        @case('air_conditioning')
                                                            <i class="fas fa-snowflake text-cyan-500 w-5"></i>
                                                            @break
                                                        @default
                                                            <i class="fas fa-check text-green-500 w-5"></i>
                                                    @endswitch
                                                    <span class="ml-3 text-sm">
                                                        {{ ucfirst(str_replace('_', ' ', $amenity)) }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Available Rooms -->
                                @if(isset($hotelData['rooms']) && is_array($hotelData['rooms']) && count($hotelData['rooms']) > 0)
                                    <div>
                                        <h3 class="text-xl font-semibold mb-4">{{ __('messages.available_rooms') }}</h3>
                                        <div class="space-y-4">
                                            @foreach($hotelData['rooms'] as $room)
                                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                                        <div class="flex-1">
                                                            <h4 class="font-semibold text-lg">{{ $room['room_type'] ?? 'Room' }}</h4>
                                                            @if(isset($room['description']))
                                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                                    {{ $room['description'] }}
                                                                </p>
                                                            @endif
                                                            
                                                            <div class="flex items-center space-x-4 mt-2 text-sm">
                                                                @if(isset($room['max_occupancy']))
                                                                    <span class="flex items-center">
                                                                        <i class="fas fa-users mr-1"></i>
                                                                        {{ $room['max_occupancy'] }} {{ __('messages.guests') }}
                                                                    </span>
                                                                @endif
                                                                
                                                                @if(isset($room['bed_type']))
                                                                    <span class="flex items-center">
                                                                        <i class="fas fa-bed mr-1"></i>
                                                                        {{ $room['bed_type'] }}
                                                                    </span>
                                                                @endif
                                                                
                                                                @if(isset($room['room_size']))
                                                                    <span class="flex items-center">
                                                                        <i class="fas fa-expand-arrows-alt mr-1"></i>
                                                                        {{ $room['room_size'] }}m²
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mt-4 md:mt-0 md:ml-6 text-right">
                                                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                                                ${{ number_format($room['base_price'] ?? 0, 2) }}
                                                            </div>
                                                            <div class="text-sm text-gray-500 mb-2">{{ __('messages.per_night') }}</div>
                                                            <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition duration-150 ease-in-out">
                                                                {{ __('messages.book_room') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Sidebar -->
                            <div class="space-y-6">
                                <!-- Hotel Policies -->
                                @if(isset($hotelData['policies']) && is_array($hotelData['policies']) && count($hotelData['policies']) > 0)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                            {{ __('messages.hotel_policies') }}
                                        </h3>
                                        <div class="space-y-3 text-sm">
                                            @foreach($hotelData['policies'] as $policy => $value)
                                                <div>
                                                    <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $policy)) }}:</span>
                                                    <span class="text-gray-600 dark:text-gray-400 ml-1">{{ $value }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Check-in/Check-out Times -->
                                @if(isset($hotelData['checkin_time']) || isset($hotelData['checkout_time']))
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                                            <i class="fas fa-clock mr-2 text-green-500"></i>
                                            {{ __('messages.check_times') }}
                                        </h3>
                                        <div class="space-y-3 text-sm">
                                            @if(isset($hotelData['checkin_time']))
                                                <div class="flex justify-between">
                                                    <span>{{ __('messages.check_in') }}:</span>
                                                    <span class="font-medium">{{ date('g:i A', strtotime($hotelData['checkin_time'])) }}</span>
                                                </div>
                                            @endif
                                            @if(isset($hotelData['checkout_time']))
                                                <div class="flex justify-between">
                                                    <span>{{ __('messages.check_out') }}:</span>
                                                    <span class="font-medium">{{ date('g:i A', strtotime($hotelData['checkout_time'])) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Contact Information -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                                        <i class="fas fa-phone mr-2 text-blue-500"></i>
                                        {{ __('messages.contact_info') }}
                                    </h3>
                                    <div class="space-y-3 text-sm">
                                        @if(isset($hotelData['phone']))
                                            <div class="flex items-center">
                                                <i class="fas fa-phone text-gray-400 w-4"></i>
                                                <span class="ml-3">{{ $hotelData['phone'] }}</span>
                                            </div>
                                        @endif
                                        @if(isset($hotelData['email']))
                                            <div class="flex items-center">
                                                <i class="fas fa-envelope text-gray-400 w-4"></i>
                                                <span class="ml-3">{{ $hotelData['email'] }}</span>
                                            </div>
                                        @endif
                                        @if(isset($hotelData['website']))
                                            <div class="flex items-center">
                                                <i class="fas fa-globe text-gray-400 w-4"></i>
                                                <a href="{{ $hotelData['website'] }}" target="_blank" 
                                                   class="ml-3 text-blue-600 dark:text-blue-400 hover:underline">
                                                    {{ __('messages.visit_website') }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <button class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition duration-150 ease-in-out">
                                <i class="fas fa-bed mr-2"></i>
                                {{ __('messages.book_this_hotel') }}
                            </button>
                            
                            <a href="{{ route('hotel::dynamic.index') }}" 
                               class="px-8 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 font-medium rounded-lg shadow-sm transition duration-150 ease-in-out text-center">
                                <i class="fas fa-search mr-2"></i>
                                {{ __('messages.search_other_hotels') }}
                            </a>
                        </div>
                    
                    @else
                        <!-- Hotel Not Found -->
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-hotel text-6xl"></i>
                            </div>
                            <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">
                                {{ __('messages.hotel_not_found') }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                {{ __('messages.hotel_not_available') }}
                            </p>
                            <a href="{{ route('hotel::dynamic.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                                <i class="fas fa-search mr-2"></i>
                                {{ __('messages.search_hotels') }}
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>