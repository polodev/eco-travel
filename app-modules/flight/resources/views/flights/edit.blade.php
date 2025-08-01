<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Flight</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $flight->airline->name }} {{ $flight->flight_number }} - {{ $flight->route_display }}</p>
                </div>
<a href="{{ route('flight::admin.flights.show', $flight->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View
                    </a>
                    <a href="{{ route('flight::admin.flights.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('flight::admin.flights.update', $flight) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Basic Flight Information -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Basic Flight Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Airline -->
                        <div>
                            <label for="airline_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Airline *
                            </label>
                            <select id="airline_id" 
                                    name="airline_id" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">Select Airline</option>
                                @foreach($airlines as $airline)
                                    <option value="{{ $airline->id }}" {{ old('airline_id', $flight->airline_id) == $airline->id ? 'selected' : '' }}>
                                        {{ $airline->name }} ({{ $airline->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('airline_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Flight Number -->
                        <div>
                            <label for="flight_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Flight Number *
                            </label>
                            <input type="text" 
                                   id="flight_number"
                                   name="flight_number"
                                   value="{{ old('flight_number', $flight->flight_number) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., 101, 2501"
                                   required>
                            @error('flight_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Departure Airport -->
                        <div>
                            <label for="departure_airport_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Departure Airport *
                            </label>
                            <select id="departure_airport_id" 
                                    name="departure_airport_id" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">Select Departure Airport</option>
                                @foreach($airports as $airport)
                                    <option value="{{ $airport->id }}" {{ old('departure_airport_id', $flight->departure_airport_id) == $airport->id ? 'selected' : '' }}>
                                        {{ $airport->name }} ({{ $airport->iata_code }}) - {{ $airport->city->name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('departure_airport_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Arrival Airport -->
                        <div>
                            <label for="arrival_airport_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Arrival Airport *
                            </label>
                            <select id="arrival_airport_id" 
                                    name="arrival_airport_id" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">Select Arrival Airport</option>
                                @foreach($airports as $airport)
                                    <option value="{{ $airport->id }}" {{ old('arrival_airport_id', $flight->arrival_airport_id) == $airport->id ? 'selected' : '' }}>
                                        {{ $airport->name }} ({{ $airport->iata_code }}) - {{ $airport->city->name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('arrival_airport_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Schedule & Route Information -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Schedule & Route Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Departure Time -->
                        <div>
                            <label for="departure_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Departure Time *
                            </label>
                            <input type="time" 
                                   id="departure_time"
                                   name="departure_time"
                                   value="{{ old('departure_time', $flight->departure_time ? $flight->departure_time->format('H:i') : '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('departure_time')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Arrival Time -->
                        <div>
                            <label for="arrival_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Arrival Time *
                            </label>
                            <input type="time" 
                                   id="arrival_time"
                                   name="arrival_time"
                                   value="{{ old('arrival_time', $flight->arrival_time ? $flight->arrival_time->format('H:i') : '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('arrival_time')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div>
                            <label for="duration_minutes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Duration (minutes) *
                            </label>
                            <input type="number" 
                                   id="duration_minutes"
                                   name="duration_minutes"
                                   value="{{ old('duration_minutes', $flight->duration_minutes) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., 90, 180"
                                   min="1"
                                   required>
                            @error('duration_minutes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Flight Type -->
                        <div>
                            <label for="flight_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Flight Type *
                            </label>
                            <select id="flight_type" 
                                    name="flight_type" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">Select Flight Type</option>
                                @foreach(\Modules\Flight\Models\Flight::getAvailableFlightTypes() as $value => $label)
                                    <option value="{{ $value }}" {{ old('flight_type', $flight->flight_type) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('flight_type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Aircraft Type -->
                        <div>
                            <label for="aircraft_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Aircraft Type *
                            </label>
                            <select id="aircraft_type" 
                                    name="aircraft_type" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">Select Aircraft Type</option>
                                @foreach(\Modules\Flight\Models\Flight::getAvailableAircraftTypes() as $value => $label)
                                    <option value="{{ $value }}" {{ old('aircraft_type', $flight->aircraft_type) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('aircraft_type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Base Price -->
                        <div>
                            <label for="base_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Base Price
                            </label>
                            <input type="number" 
                                   id="base_price"
                                   name="base_price"
                                   value="{{ old('base_price', $flight->base_price) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0.00"
                                   step="0.01"
                                   min="0">
                            @error('base_price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Operating Days -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Operating Days</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                        @foreach(\Modules\Flight\Models\Flight::getAvailableOperatingDays() as $value => $label)
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="operating_days[]" 
                                       value="{{ $value }}" 
                                       {{ (is_array(old('operating_days', $flight->operating_days)) && in_array($value, old('operating_days', $flight->operating_days))) ? 'checked' : '' }}
                                       class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('operating_days')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Seat Configuration -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Seat Configuration</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Total Seats -->
                        <div>
                            <label for="total_seats" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Total Seats
                            </label>
                            <input type="number" 
                                   id="total_seats"
                                   name="total_seats"
                                   value="{{ old('total_seats', $flight->total_seats) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0"
                                   min="0">
                            @error('total_seats')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Economy Seats -->
                        <div>
                            <label for="economy_seats" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Economy Seats
                            </label>
                            <input type="number" 
                                   id="economy_seats"
                                   name="economy_seats"
                                   value="{{ old('economy_seats', $flight->economy_seats) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0"
                                   min="0">
                            @error('economy_seats')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Business Seats -->
                        <div>
                            <label for="business_seats" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Business Seats
                            </label>
                            <input type="number" 
                                   id="business_seats"
                                   name="business_seats"
                                   value="{{ old('business_seats', $flight->business_seats) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0"
                                   min="0">
                            @error('business_seats')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- First Class Seats -->
                        <div>
                            <label for="first_seats" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                First Class Seats
                            </label>
                            <input type="number" 
                                   id="first_seats"
                                   name="first_seats"
                                   value="{{ old('first_seats', $flight->first_seats) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0"
                                   min="0">
                            @error('first_seats')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Amenities & Settings -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Amenities & Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Amenities -->
                        <div class="space-y-3">
                            <h4 class="font-medium text-gray-800 dark:text-gray-100">Amenities</h4>
                            <label class="flex items-center">
                                <input type="hidden" name="has_meal" value="0">
                                <input type="checkbox" 
                                       name="has_meal" 
                                       value="1" 
                                       {{ old('has_meal', $flight->has_meal) ? 'checked' : '' }}
                                       class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Meal Service</span>
                            </label>
                            <label class="flex items-center">
                                <input type="hidden" name="has_wifi" value="0">
                                <input type="checkbox" 
                                       name="has_wifi" 
                                       value="1" 
                                       {{ old('has_wifi', $flight->has_wifi) ? 'checked' : '' }}
                                       class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">WiFi Available</span>
                            </label>
                            <label class="flex items-center">
                                <input type="hidden" name="has_entertainment" value="0">
                                <input type="checkbox" 
                                       name="has_entertainment" 
                                       value="1" 
                                       {{ old('has_entertainment', $flight->has_entertainment) ? 'checked' : '' }}
                                       class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">In-flight Entertainment</span>
                            </label>
                        </div>

                        <!-- Other Settings -->
                        <div class="space-y-3">
                            <h4 class="font-medium text-gray-800 dark:text-gray-100">Settings</h4>
                            <!-- Position -->
                            <div>
                                <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Display Position
                                </label>
                                <input type="number" 
                                       id="position"
                                       name="position"
                                       value="{{ old('position', $flight->position) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="0"
                                       min="0">
                                @error('position')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Lower numbers appear first in lists</p>
                            </div>
                            <!-- Active Status -->
                            <label class="flex items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', $flight->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                            </label>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Active flights will be available for booking</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
<div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('flight::admin.flights.show', $flight->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Update Flight
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-dashboard-layout::layout>