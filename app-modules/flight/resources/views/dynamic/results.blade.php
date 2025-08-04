<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.flight_results') }}</x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Search Summary -->
                    <div class="mb-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <h2 class="text-xl font-semibold mb-2">{{ __('messages.search_results') }}</h2>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <span class="font-medium">{{ $searchParams['departure_city'] }}</span> 
                            → 
                            <span class="font-medium">{{ $searchParams['arrival_city'] }}</span>
                            | {{ date('M d, Y', strtotime($searchParams['departure_date'])) }}
                            @if($searchParams['return_date'])
                                - {{ date('M d, Y', strtotime($searchParams['return_date'])) }}
                            @endif
                            | {{ $searchParams['passengers'] }} {{ $searchParams['passengers'] == 1 ? __('messages.passenger') : __('messages.passengers') }}
                            | {{ ucfirst($searchParams['class']) }}
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

                    <!-- Flight Results -->
                    @if(isset($results['data']) && count($results['data']) > 0)
                        <div class="space-y-4">
                            @foreach($results['data'] as $flight)
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                        
                                        <!-- Flight Info -->
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-4 mb-2">
                                                @if(isset($flight['airline']))
                                                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                                        {{ $flight['airline']['name'] ?? 'Unknown Airline' }}
                                                    </div>
                                                @endif
                                                
                                                @if(isset($flight['flight_number']))
                                                    <div class="text-sm text-gray-500">
                                                        {{ $flight['flight_number'] }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                                <!-- Departure -->
                                                <div class="text-center md:text-left">
                                                    <div class="text-2xl font-bold">
                                                        {{ isset($flight['departure_time']) ? date('H:i', strtotime($flight['departure_time'])) : '--:--' }}
                                                    </div>
                                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $flight['departure_airport']['iata_code'] ?? $searchParams['departure_city'] }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $flight['departure_airport']['name'] ?? '' }}
                                                    </div>
                                                </div>

                                                <!-- Duration & Route -->
                                                <div class="text-center">
                                                    <div class="flex items-center justify-center space-x-2">
                                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                                        <div class="flex-1 h-0.5 bg-blue-300"></div>
                                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                                    </div>
                                                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                        {{ isset($flight['duration_minutes']) ? floor($flight['duration_minutes'] / 60) . 'h ' . ($flight['duration_minutes'] % 60) . 'm' : '--' }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $flight['flight_type'] ?? 'Direct' }}
                                                    </div>
                                                </div>

                                                <!-- Arrival -->
                                                <div class="text-center md:text-right">
                                                    <div class="text-2xl font-bold">
                                                        {{ isset($flight['arrival_time']) ? date('H:i', strtotime($flight['arrival_time'])) : '--:--' }}
                                                    </div>
                                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $flight['arrival_airport']['iata_code'] ?? $searchParams['arrival_city'] }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $flight['arrival_airport']['name'] ?? '' }}
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Amenities -->
                                            @if(isset($flight['has_meal']) || isset($flight['has_wifi']) || isset($flight['has_entertainment']))
                                                <div class="flex flex-wrap gap-2 mt-3">
                                                    @if($flight['has_meal'] ?? false)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                                            <i class="fas fa-utensils mr-1"></i> {{ __('messages.meal') }}
                                                        </span>
                                                    @endif
                                                    @if($flight['has_wifi'] ?? false)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                            <i class="fas fa-wifi mr-1"></i> {{ __('messages.wifi') }}
                                                        </span>
                                                    @endif
                                                    @if($flight['has_entertainment'] ?? false)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                                            <i class="fas fa-tv mr-1"></i> {{ __('messages.entertainment') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Price & Action -->
                                        <div class="mt-4 lg:mt-0 lg:ml-6 text-center lg:text-right">
                                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                                ${{ number_format($flight['base_price'] ?? 0, 2) }}
                                            </div>
                                            <div class="text-sm text-gray-500 mb-3">
                                                {{ __('messages.per_person') }}
                                            </div>
                                            
                                            <div class="space-y-2">
                                                <a href="{{ route('flight::dynamic.show', $flight['id']) }}" 
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
                            @endforeach
                        </div>
                    @else
                        <!-- No Results -->
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-plane-slash text-6xl"></i>
                            </div>
                            <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">
                                {{ __('messages.no_flights_found') }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                {{ __('messages.try_different_search') }}
                            </p>
                            <a href="{{ route('flight::dynamic.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                                <i class="fas fa-search mr-2"></i>
                                {{ __('messages.new_search') }}
                            </a>
                        </div>
                    @endif

                    <!-- Back to Search -->
                    <div class="mt-8 text-center">
                        <a href="{{ route('flight::dynamic.index') }}" 
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