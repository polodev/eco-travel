<x-admin-dashboard-layout::layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Flight Booking</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $bookingFlight->booking->booking_reference }} - {{ $bookingFlight->airline_code }} {{ $bookingFlight->flight_number }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin-dashboard.booking.booking-flights.show', $bookingFlight) }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Flight Details
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <form action="{{ route('admin-dashboard.booking.booking-flights.update', $bookingFlight) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Flight Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Flight Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="airline_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Airline Code</label>
                                <input type="text" name="airline_code" id="airline_code" 
                                       value="{{ old('airline_code', $bookingFlight->airline_code) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('airline_code') border-red-500 @enderror">
                                @error('airline_code')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="flight_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Flight Number</label>
                                <input type="text" name="flight_number" id="flight_number" 
                                       value="{{ old('flight_number', $bookingFlight->flight_number) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('flight_number') border-red-500 @enderror">
                                @error('flight_number')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="departure_airport" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departure Airport</label>
                                <input type="text" name="departure_airport" id="departure_airport" 
                                       value="{{ old('departure_airport', $bookingFlight->departure_airport) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('departure_airport') border-red-500 @enderror">
                                @error('departure_airport')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="arrival_airport" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Arrival Airport</label>
                                <input type="text" name="arrival_airport" id="arrival_airport" 
                                       value="{{ old('arrival_airport', $bookingFlight->arrival_airport) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('arrival_airport') border-red-500 @enderror">
                                @error('arrival_airport')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="departure_datetime" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departure Date & Time</label>
                                <input type="datetime-local" name="departure_datetime" id="departure_datetime" 
                                       value="{{ old('departure_datetime', $bookingFlight->departure_datetime->format('Y-m-d\TH:i')) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('departure_datetime') border-red-500 @enderror">
                                @error('departure_datetime')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="arrival_datetime" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Arrival Date & Time</label>
                                <input type="datetime-local" name="arrival_datetime" id="arrival_datetime" 
                                       value="{{ old('arrival_datetime', $bookingFlight->arrival_datetime->format('Y-m-d\TH:i')) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('arrival_datetime') border-red-500 @enderror">
                                @error('arrival_datetime')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="trip_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Trip Type</label>
                                <select name="trip_type" id="trip_type" 
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('trip_type') border-red-500 @enderror">
                                    <option value="oneway" {{ old('trip_type', $bookingFlight->trip_type) == 'oneway' ? 'selected' : '' }}>One Way</option>
                                    <option value="roundtrip" {{ old('trip_type', $bookingFlight->trip_type) == 'roundtrip' ? 'selected' : '' }}>Round Trip</option>
                                </select>
                                @error('trip_type')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cabin_class" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cabin Class</label>
                                <select name="cabin_class" id="cabin_class" 
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('cabin_class') border-red-500 @enderror">
                                    <option value="economy" {{ old('cabin_class', $bookingFlight->cabin_class) == 'economy' ? 'selected' : '' }}>Economy</option>
                                    <option value="business" {{ old('cabin_class', $bookingFlight->cabin_class) == 'business' ? 'selected' : '' }}>Business</option>
                                    <option value="first" {{ old('cabin_class', $bookingFlight->cabin_class) == 'first' ? 'selected' : '' }}>First Class</option>
                                </select>
                                @error('cabin_class')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Passenger & Pricing Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Passenger & Pricing Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="adults" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adults</label>
                                <input type="number" name="adults" id="adults" min="1" max="20"
                                       value="{{ old('adults', $bookingFlight->adults) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('adults') border-red-500 @enderror">
                                @error('adults')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="children" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Children</label>
                                <input type="number" name="children" id="children" min="0" max="20"
                                       value="{{ old('children', $bookingFlight->children) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('children') border-red-500 @enderror">
                                @error('children')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="infants" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Infants</label>
                                <input type="number" name="infants" id="infants" min="0" max="20"
                                       value="{{ old('infants', $bookingFlight->infants) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('infants') border-red-500 @enderror">
                                @error('infants')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="adult_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adult Price (৳)</label>
                                <input type="number" name="adult_price" id="adult_price" min="0" step="0.01"
                                       value="{{ old('adult_price', $bookingFlight->adult_price) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('adult_price') border-red-500 @enderror">
                                @error('adult_price')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="child_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Child Price (৳)</label>
                                <input type="number" name="child_price" id="child_price" min="0" step="0.01"
                                       value="{{ old('child_price', $bookingFlight->child_price) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('child_price') border-red-500 @enderror">
                                @error('child_price')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="infant_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Infant Price (৳)</label>
                                <input type="number" name="infant_price" id="infant_price" min="0" step="0.01"
                                       value="{{ old('infant_price', $bookingFlight->infant_price) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('infant_price') border-red-500 @enderror">
                                @error('infant_price')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="taxes_fees" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Taxes & Fees (৳)</label>
                                <input type="number" name="taxes_fees" id="taxes_fees" min="0" step="0.01"
                                       value="{{ old('taxes_fees', $bookingFlight->taxes_fees) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('taxes_fees') border-red-500 @enderror">
                                @error('taxes_fees')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="total_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Amount (৳)</label>
                                <input type="number" name="total_amount" id="total_amount" min="0" step="0.01"
                                       value="{{ old('total_amount', $bookingFlight->total_amount) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('total_amount') border-red-500 @enderror">
                                @error('total_amount')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="pnr_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">PNR Code</label>
                                <input type="text" name="pnr_code" id="pnr_code" 
                                       value="{{ old('pnr_code', $bookingFlight->pnr_code) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('pnr_code') border-red-500 @enderror">
                                @error('pnr_code')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ticket_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ticket Status</label>
                                <select name="ticket_status" id="ticket_status" 
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('ticket_status') border-red-500 @enderror">
                                    <option value="pending" {{ old('ticket_status', $bookingFlight->ticket_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="issued" {{ old('ticket_status', $bookingFlight->ticket_status) == 'issued' ? 'selected' : '' }}>Issued</option>
                                    <option value="cancelled" {{ old('ticket_status', $bookingFlight->ticket_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="refunded" {{ old('ticket_status', $bookingFlight->ticket_status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                                @error('ticket_status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="ticket_numbers" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ticket Numbers</label>
                            <textarea name="ticket_numbers" id="ticket_numbers" rows="2"
                                      placeholder="Enter ticket numbers separated by commas"
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('ticket_numbers') border-red-500 @enderror">{{ old('ticket_numbers', $bookingFlight->ticket_numbers) }}</textarea>
                            @error('ticket_numbers')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin-dashboard.booking.booking-flights.show', $bookingFlight) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Flight Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto-calculate total amount
        function calculateTotal() {
            const adults = parseInt(document.getElementById('adults').value) || 0;
            const children = parseInt(document.getElementById('children').value) || 0;
            const infants = parseInt(document.getElementById('infants').value) || 0;
            
            const adultPrice = parseFloat(document.getElementById('adult_price').value) || 0;
            const childPrice = parseFloat(document.getElementById('child_price').value) || 0;
            const infantPrice = parseFloat(document.getElementById('infant_price').value) || 0;
            const taxesFees = parseFloat(document.getElementById('taxes_fees').value) || 0;
            
            const total = (adults * adultPrice) + (children * childPrice) + (infants * infantPrice) + taxesFees;
            
            document.getElementById('total_amount').value = total.toFixed(2);
        }

        // Add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const fields = ['adults', 'children', 'infants', 'adult_price', 'child_price', 'infant_price', 'taxes_fees'];
            fields.forEach(field => {
                document.getElementById(field).addEventListener('input', calculateTotal);
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>