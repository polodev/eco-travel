<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Flight Schedule</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $flightSchedule->flight->airline->name }} {{ $flightSchedule->flight->flight_number }} - {{ $flightSchedule->flight->departureAirport->city->name }} → {{ $flightSchedule->flight->arrivalAirport->city->name }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin-dashboard.flight.flight-schedules.show', $flightSchedule) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View
                    </a>
                    <a href="{{ route('admin-dashboard.flight.flight-schedules.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('admin-dashboard.flight.flight-schedules.update', $flightSchedule) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Flight Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Flight Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="flight_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Flight *</label>
                            <select name="flight_id" id="flight_id" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('flight_id') border-red-500 @enderror">
                                <option value="">Select Flight</option>
                                @foreach($flights as $flight)
                                    <option value="{{ $flight->id }}" {{ old('flight_id', $flightSchedule->flight_id) == $flight->id ? 'selected' : '' }}>
                                        {{ $flight->airline->name }} {{ $flight->flight_number }} - {{ $flight->departureAirport->city->name }} → {{ $flight->arrivalAirport->city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('flight_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Schedule Times -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Schedule Times</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="departure_datetime" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Departure Date & Time *</label>
                            <input type="datetime-local" name="departure_datetime" id="departure_datetime" value="{{ old('departure_datetime', \Carbon\Carbon::parse($flightSchedule->departure_datetime)->format('Y-m-d\TH:i')) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('departure_datetime') border-red-500 @enderror">
                            @error('departure_datetime')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="arrival_datetime" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Arrival Date & Time *</label>
                            <input type="datetime-local" name="arrival_datetime" id="arrival_datetime" value="{{ old('arrival_datetime', \Carbon\Carbon::parse($flightSchedule->arrival_datetime)->format('Y-m-d\TH:i')) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('arrival_datetime') border-red-500 @enderror">
                            @error('arrival_datetime')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Pricing</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="economy_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Economy Price (৳) *</label>
                            <input type="number" name="economy_price" id="economy_price" value="{{ old('economy_price', $flightSchedule->economy_price) }}" min="0" step="0.01" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('economy_price') border-red-500 @enderror">
                            @error('economy_price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="business_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Business Price (৳)</label>
                            <input type="number" name="business_price" id="business_price" value="{{ old('business_price', $flightSchedule->business_price) }}" min="0" step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('business_price') border-red-500 @enderror">
                            @error('business_price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="first_class_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">First Class Price (৳)</label>
                            <input type="number" name="first_class_price" id="first_class_price" value="{{ old('first_class_price', $flightSchedule->first_class_price) }}" min="0" step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('first_class_price') border-red-500 @enderror">
                            @error('first_class_price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Seat Availability -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Seat Availability</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="available_economy" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Available Economy Seats *</label>
                            <input type="number" name="available_economy" id="available_economy" value="{{ old('available_economy', $flightSchedule->available_economy) }}" min="0" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('available_economy') border-red-500 @enderror">
                            @error('available_economy')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="available_business" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Available Business Seats</label>
                            <input type="number" name="available_business" id="available_business" value="{{ old('available_business', $flightSchedule->available_business) }}" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('available_business') border-red-500 @enderror">
                            @error('available_business')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="available_first" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Available First Class Seats</label>
                            <input type="number" name="available_first" id="available_first" value="{{ old('available_first', $flightSchedule->available_first) }}" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('available_first') border-red-500 @enderror">
                            @error('available_first')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Airport Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Airport Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="gate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gate</label>
                            <input type="text" name="gate" id="gate" value="{{ old('gate', $flightSchedule->gate) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('gate') border-red-500 @enderror">
                            @error('gate')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="terminal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Terminal</label>
                            <input type="text" name="terminal" id="terminal" value="{{ old('terminal', $flightSchedule->terminal) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('terminal') border-red-500 @enderror">
                            @error('terminal')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="check_in_counter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Check-in Counter</label>
                            <input type="text" name="check_in_counter" id="check_in_counter" value="{{ old('check_in_counter', $flightSchedule->check_in_counter) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('check_in_counter') border-red-500 @enderror">
                            @error('check_in_counter')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-3">
                            <label for="baggage_claim" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Baggage Claim</label>
                            <input type="text" name="baggage_claim" id="baggage_claim" value="{{ old('baggage_claim', $flightSchedule->baggage_claim) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('baggage_claim') border-red-500 @enderror">
                            @error('baggage_claim')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status & Delays -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Status & Delays</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                            <select name="status" id="status" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                                <option value="scheduled" {{ old('status', $flightSchedule->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="boarding" {{ old('status', $flightSchedule->status) == 'boarding' ? 'selected' : '' }}>Boarding</option>
                                <option value="departed" {{ old('status', $flightSchedule->status) == 'departed' ? 'selected' : '' }}>Departed</option>
                                <option value="arrived" {{ old('status', $flightSchedule->status) == 'arrived' ? 'selected' : '' }}>Arrived</option>
                                <option value="delayed" {{ old('status', $flightSchedule->status) == 'delayed' ? 'selected' : '' }}>Delayed</option>
                                <option value="cancelled" {{ old('status', $flightSchedule->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="delay_minutes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Delay Minutes</label>
                            <input type="number" name="delay_minutes" id="delay_minutes" value="{{ old('delay_minutes', $flightSchedule->delay_minutes) }}" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('delay_minutes') border-red-500 @enderror">
                            @error('delay_minutes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="delay_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Delay Reason</label>
                            <input type="text" name="delay_reason" id="delay_reason" value="{{ old('delay_reason', $flightSchedule->delay_reason) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('delay_reason') border-red-500 @enderror">
                            @error('delay_reason')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes', $flightSchedule->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin-dashboard.flight.flight-schedules.show', $flightSchedule) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Update Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-dashboard-layout::layout>