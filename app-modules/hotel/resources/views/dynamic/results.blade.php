<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.hotel_results') }}</x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Search Summary -->
                    <div class="mb-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <h2 class="text-xl font-semibold mb-2">{{ __('messages.search_results') }}</h2>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <span class="font-medium">{{ $searchParams['destination'] }}</span>
                            | {{ date('M d, Y', strtotime($searchParams['checkin_date'])) }}
                            - {{ date('M d, Y', strtotime($searchParams['checkout_date'])) }}
                            | {{ $searchParams['guests'] }} {{ $searchParams['guests'] == 1 ? __('messages.guest') : __('messages.guests') }}
                            | {{ $searchParams['rooms'] }} {{ $searchParams['rooms'] == 1 ? __('messages.room') : __('messages.rooms') }}
                            @if($searchParams['star_rating'])
                                | {{ $searchParams['star_rating'] }} {{ $searchParams['star_rating'] == 1 ? __('messages.star') : __('messages.stars') }}
                            @endif
                        </div>
                        
                        @if(isset($results['fallback']) && $results['fallback'])
                            <div class="mt-2 text-amber-600 dark:text-amber-400 text-sm">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                {{ __('messages.showing_static_data') }}
                            </div>
                        @endif
                        
                        @if(isset($results['provider']))
                            <div class="mt-2 text-xs text-gray-500">
                                {{ __('messages.powered_by') }}: {{ ucfirst($results['provider']) }}
                            </div>
                        @endif
                    </div>

                    <!-- Hotel Results -->
                    @if(isset($results['data']) && count($results['data']) > 0)
                        <div class="space-y-6">
                            @foreach($results['data'] as $hotel)
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                    <div class="md:flex">
                                        <!-- Hotel Image -->
                                        <div class="md:w-64 md:flex-shrink-0">
                                            @if(isset($hotel['images']) && is_array($hotel['images']) && count($hotel['images']) > 0)
                                                <img src="{{ $hotel['images'][0] }}" 
                                                     alt="{{ $hotel['name'] ?? 'Hotel' }}"
                                                     class="h-48 w-full object-cover md:h-full">
                                            @else
                                                <div class="h-48 md:h-full w-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                    <i class="fas fa-hotel text-4xl text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Hotel Details -->
                                        <div class="flex-1 p-6">
                                            <div class="flex flex-col lg:flex-row lg:justify-between">
                                                <div class="flex-1">
                                                    <!-- Hotel Name & Rating -->
                                                    <div class="flex items-start justify-between mb-2">
                                                        <div>
                                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                                {{ $hotel['name'] ?? 'Hotel Name' }}
                                                            </h3>
                                                            
                                                            <!-- Star Rating -->
                                                            @if(isset($hotel['star_rating']))
                                                                <div class="flex items-center mt-1">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <i class="fas fa-star text-sm {{ $i <= $hotel['star_rating'] ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                                    @endfor
                                                                    <span class="ml-1 text-sm text-gray-600 dark:text-gray-400">
                                                                        {{ $hotel['star_rating'] }} {{ __('messages.star_hotel') }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        
                                                        @if(isset($hotel['is_featured']) && $hotel['is_featured'])
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                                                {{ __('messages.featured') }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <!-- Location -->
                                                    @if(isset($hotel['address']) || isset($hotel['city']))
                                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-3">
                                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                                            {{ $hotel['address'] ?? '' }}
                                                            @if(isset($hotel['city']))
                                                                {{ $hotel['address'] ? ', ' : '' }}{{ $hotel['city']['name'] ?? $hotel['city'] }}
                                                            @endif
                                                        </div>
                                                    @endif

                                                    <!-- Reviews -->
                                                    @if(isset($hotel['average_rating']) && $hotel['average_rating'] > 0)
                                                        <div class="flex items-center mb-3">
                                                            <div class="bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 px-2 py-1 rounded text-sm font-medium">
                                                                {{ number_format($hotel['average_rating'], 1) }}
                                                            </div>
                                                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                                                ({{ $hotel['total_reviews'] ?? 0 }} {{ __('messages.reviews') }})
                                                            </span>
                                                        </div>
                                                    @endif

                                                    <!-- Amenities -->
                                                    @if(isset($hotel['amenities']) && is_array($hotel['amenities']) && count($hotel['amenities']) > 0)
                                                        <div class="flex flex-wrap gap-1 mb-3">
                                                            @foreach(array_slice($hotel['amenities'], 0, 4) as $amenity)
                                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                                                    @switch($amenity)
                                                                        @case('wifi')
                                                                            <i class="fas fa-wifi mr-1"></i>
                                                                            @break
                                                                        @case('pool')
                                                                            <i class="fas fa-swimming-pool mr-1"></i>
                                                                            @break
                                                                        @case('parking')
                                                                            <i class="fas fa-parking mr-1"></i>
                                                                            @break
                                                                        @case('restaurant')
                                                                            <i class="fas fa-utensils mr-1"></i>
                                                                            @break
                                                                        @default
                                                                            <i class="fas fa-check mr-1"></i>
                                                                    @endswitch
                                                                    {{ ucfirst(str_replace('_', ' ', $amenity)) }}
                                                                </span>
                                                            @endforeach
                                                            @if(count($hotel['amenities']) > 4)
                                                                <span class="text-xs text-gray-500">
                                                                    +{{ count($hotel['amenities']) - 4 }} {{ __('messages.more') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    <!-- Distance Information -->
                                                    @if(isset($hotel['distance_from_city_center']) || isset($hotel['distance_from_airport']))
                                                        <div class="text-xs text-gray-500 space-y-1">
                                                            @if(isset($hotel['distance_from_city_center']))
                                                                <div>
                                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                                    {{ $hotel['distance_from_city_center'] }}km {{ __('messages.from_city_center') }}
                                                                </div>
                                                            @endif
                                                            @if(isset($hotel['distance_from_airport']))
                                                                <div>
                                                                    <i class="fas fa-plane mr-1"></i>
                                                                    {{ $hotel['distance_from_airport'] }}km {{ __('messages.from_airport') }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Price & Action -->
                                                <div class="mt-4 lg:mt-0 lg:ml-6 text-center lg:text-right">
                                                    @php
                                                        $minPrice = 0;
                                                        if (isset($hotel['rooms']) && is_array($hotel['rooms'])) {
                                                            $minPrice = collect($hotel['rooms'])->min('base_price') ?? 0;
                                                        } elseif (isset($hotel['minimum_price'])) {
                                                            $minPrice = $hotel['minimum_price'];
                                                        }
                                                    @endphp
                                                    
                                                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                                        ${{ number_format($minPrice, 2) }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 mb-3">
                                                        {{ __('messages.per_night') }}
                                                    </div>
                                                    
                                                    <div class="space-y-2">
                                                        <a href="{{ route('hotel::dynamic.show', $hotel['id']) }}" 
                                                           class="inline-block w-full lg:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                                                            {{ __('messages.view_details') }}
                                                        </a>
                                                        
                                                        <button class="block w-full lg:w-auto px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                                                            {{ __('messages.book_now') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- No Results -->
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-hotel text-6xl"></i>
                            </div>
                            <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">
                                {{ __('messages.no_hotels_found') }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                {{ __('messages.try_different_search') }}
                            </p>
                            <a href="{{ route('hotel::dynamic.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                                <i class="fas fa-search mr-2"></i>
                                {{ __('messages.new_search') }}
                            </a>
                        </div>
                    @endif

                    <!-- Back to Search -->
                    <div class="mt-8 text-center">
                        <a href="{{ route('hotel::dynamic.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                            <i class="fas fa-arrow-left mr-2"></i>
                            {{ __('messages.modify_search') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>