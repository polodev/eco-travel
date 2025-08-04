<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.flight_details') }}</x-slot>
    
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(isset($flight['data']))
                        @php $flightData = $flight['data']; @endphp
                        
                        <!-- Flight Header -->
                        <div class="border-b border-gray-200 dark:border-gray-600 pb-6 mb-6">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                        {{ __('messages.flight_details') }}
                                    </h1>
                                    @if(isset($flightData['airline']))
                                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-1">
                                            {{ $flightData['airline']['name'] }} {{ $flightData['flight_number'] ?? '' }}
                                        </p>
                                    @endif
                                </div>
                                
                                <div class="mt-4 lg:mt-0 text-right">
                                    <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                                        ${{ number_format($flightData['base_price'] ?? 0, 2) }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ __('messages.per_person') }}</div>
                                </div>
                            </div>

                            @if(isset($flight['fallback']) && $flight['fallback'])
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

                        <!-- Flight Route Information -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                            <!-- Departure -->
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2">
                                    {{ isset($flightData['departure_time']) ? date('H:i', strtotime($flightData['departure_time'])) : '--:--' }}
                                </div>
                                <div class="text-lg font-medium text-gray-700 dark:text-gray-300">
                                    {{ $flightData['departure_airport']['iata_code'] ?? 'DEP' }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $flightData['departure_airport']['name'] ?? __('messages.departure_airport') }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $flightData['departure_airport']['city'] ?? '' }}
                                </div>
                            </div>

                            <!-- Flight Path -->
                            <div class="flex flex-col items-center justify-center">
                                <div class="flex items-center w-full mb-2">
                                    <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                                    <div class="flex-1 h-0.5 bg-blue-300 mx-2"></div>
                                    <i class="fas fa-plane text-blue-500 text-lg"></i>
                                    <div class="flex-1 h-0.5 bg-blue-300 mx-2"></div>
                                    <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ isset($flightData['duration_minutes']) ? floor($flightData['duration_minutes'] / 60) . 'h ' . ($flightData['duration_minutes'] % 60) . 'm' : '--' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ ucfirst($flightData['flight_type'] ?? 'direct') }}
                                </div>
                            </div>

                            <!-- Arrival -->
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2">
                                    {{ isset($flightData['arrival_time']) ? date('H:i', strtotime($flightData['arrival_time'])) : '--:--' }}
                                </div>
                                <div class="text-lg font-medium text-gray-700 dark:text-gray-300">
                                    {{ $flightData['arrival_airport']['iata_code'] ?? 'ARR' }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $flightData['arrival_airport']['name'] ?? __('messages.arrival_airport') }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $flightData['arrival_airport']['city'] ?? '' }}
                                </div>
                            </div>
                        </div>

                        <!-- Flight Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <!-- Aircraft Information -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-plane mr-2 text-blue-500"></i>
                                    {{ __('messages.aircraft_information') }}
                                </h3>
                                <div class="space-y-3 text-sm">
                                    @if(isset($flightData['aircraft_type']))
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">{{ __('messages.aircraft_type') }}:</span>
                                            <span class="font-medium">{{ $flightData['aircraft_type'] }}</span>
                                        </div>
                                    @endif
                                    
                                    @if(isset($flightData['total_seats']))
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">{{ __('messages.total_seats') }}:</span>
                                            <span class="font-medium">{{ $flightData['total_seats'] }}</span>
                                        </div>
                                    @endif
                                    
                                    @if(isset($flightData['economy_seats']))
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">{{ __('messages.economy_seats') }}:</span>
                                            <span class="font-medium">{{ $flightData['economy_seats'] }}</span>
                                        </div>
                                    @endif
                                    
                                    @if(isset($flightData['business_seats']) && $flightData['business_seats'] > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">{{ __('messages.business_seats') }}:</span>
                                            <span class="font-medium">{{ $flightData['business_seats'] }}</span>
                                        </div>
                                    @endif
                                    
                                    @if(isset($flightData['first_seats']) && $flightData['first_seats'] > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600 dark:text-gray-400">{{ __('messages.first_class_seats') }}:</span>
                                            <span class="font-medium">{{ $flightData['first_seats'] }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Flight Services -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-concierge-bell mr-2 text-green-500"></i>
                                    {{ __('messages.flight_services') }}
                                </h3>
                                <div class="space-y-3">
                                    @if(isset($flightData['has_meal']))
                                        <div class="flex items-center">
                                            <i class="fas fa-utensils text-orange-500 w-5"></i>
                                            <span class="ml-3 text-sm">
                                                {{ $flightData['has_meal'] ? __('messages.meal_included') : __('messages.no_meal') }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if(isset($flightData['has_wifi']))
                                        <div class="flex items-center">
                                            <i class="fas fa-wifi text-blue-500 w-5"></i>
                                            <span class="ml-3 text-sm">
                                                {{ $flightData['has_wifi'] ? __('messages.wifi_available') : __('messages.no_wifi') }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if(isset($flightData['has_entertainment']))
                                        <div class="flex items-center">
                                            <i class="fas fa-tv text-purple-500 w-5"></i>
                                            <span class="ml-3 text-sm">
                                                {{ $flightData['has_entertainment'] ? __('messages.entertainment_available') : __('messages.no_entertainment') }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if(isset($flightData['baggage_allowance']) && is_array($flightData['baggage_allowance']))
                                        <div class="flex items-start">
                                            <i class="fas fa-suitcase text-gray-500 w-5 mt-0.5"></i>
                                            <div class="ml-3 text-sm">
                                                <div class="font-medium">{{ __('messages.baggage_allowance') }}:</div>
                                                @foreach($flightData['baggage_allowance'] as $type => $allowance)
                                                    <div class="text-gray-600 dark:text-gray-400">
                                                        {{ ucfirst($type) }}: {{ $allowance }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Operating Days -->
                        @if(isset($flightData['operating_days']) && is_array($flightData['operating_days']))
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 mb-8">
                                <h3 class="text-lg font-semibold mb-3 flex items-center">
                                    <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                                    {{ __('messages.operating_days') }}
                                </h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ in_array($day, $flightData['operating_days']) ? 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
                                            {{ __(ucfirst(substr($day, 0, 3))) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <button class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition duration-150 ease-in-out">
                                <i class="fas fa-ticket-alt mr-2"></i>
                                {{ __('messages.book_this_flight') }}
                            </button>
                            
                            <a href="{{ route('flight::dynamic.index') }}" 
                               class="px-8 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 font-medium rounded-lg shadow-sm transition duration-150 ease-in-out text-center">
                                <i class="fas fa-search mr-2"></i>
                                {{ __('messages.search_other_flights') }}
                            </a>
                        </div>
                    
                    @else
                        <!-- Flight Not Found -->
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-plane-slash text-6xl"></i>
                            </div>
                            <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">
                                {{ __('messages.flight_not_found') }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                {{ __('messages.flight_not_available') }}
                            </p>
                            <a href="{{ route('flight::dynamic.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                                <i class="fas fa-search mr-2"></i>
                                {{ __('messages.search_flights') }}
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>