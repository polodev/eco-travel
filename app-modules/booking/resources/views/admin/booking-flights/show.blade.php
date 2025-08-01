<x-admin-dashboard-layout::layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Flight Booking Details</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $bookingFlight->booking->booking_reference }} - {{ $bookingFlight->airline_code }} {{ $bookingFlight->flight_number }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('booking::admin.booking-flights.index') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Flight Bookings
                        </a>
                        <a href="{{ route('booking::admin.bookings.show', $bookingFlight->booking) }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-800 border border-blue-200 dark:border-blue-600 rounded-md hover:bg-blue-100 dark:hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            View Main Booking
                        </a>
                        @if(in_array($bookingFlight->ticket_status, ['pending', 'issued']))
                            <a href="{{ route('booking::admin.booking-flights.edit', $bookingFlight) }}" 
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Flight
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Flight Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Flight Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Flight Number</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $bookingFlight->airline_code }} {{ $bookingFlight->flight_number }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Route</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingFlight->departure_airport }} → {{ $bookingFlight->arrival_airport }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Trip Type</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($bookingFlight->trip_type) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cabin Class</dt>
                                <dd class="mt-1 text-sm">{!! $bookingFlight->cabin_class_badge !!}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Departure</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    <div>{{ $bookingFlight->departure_datetime->format('M j, Y') }} at {{ $bookingFlight->departure_datetime->format('H:i') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $bookingFlight->departure_airport }}</div>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Arrival</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    <div>{{ $bookingFlight->arrival_datetime->format('M j, Y') }} at {{ $bookingFlight->arrival_datetime->format('H:i') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $bookingFlight->arrival_airport }}</div>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Passenger Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Passenger Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $bookingFlight->adults }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Adult{{ $bookingFlight->adults > 1 ? 's' : '' }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $bookingFlight->children }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Child{{ $bookingFlight->children > 1 ? 'ren' : '' }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $bookingFlight->infants }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Infant{{ $bookingFlight->infants > 1 ? 's' : '' }}</div>
                            </div>
                        </div>
                        
                        @if($bookingFlight->passenger_details)
                            <div class="mt-6">
                                <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-3">Passenger Details</h4>
                                <div class="space-y-3">
                                    @foreach($bookingFlight->passenger_details as $index => $passenger)
                                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $passenger['title'] ?? '' }} {{ $passenger['first_name'] ?? '' }} {{ $passenger['last_name'] ?? '' }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ ucfirst($passenger['type'] ?? 'adult') }}
                                                        @if(isset($passenger['date_of_birth']))
                                                            • DOB: {{ $passenger['date_of_birth'] }}
                                                        @endif
                                                    </div>
                                                </div>
                                                @if(isset($passenger['passport_number']))
                                                    <div class="text-sm text-gray-500 dark:text-gray-400 font-mono">
                                                        {{ $passenger['passport_number'] }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Additional Services -->
                @if($bookingFlight->seat_selections || $bookingFlight->meal_preferences || $bookingFlight->special_requests)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Additional Services</h3>
                            
                            @if($bookingFlight->seat_selections)
                                <div class="mb-4">
                                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-2">Seat Selections</h4>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ is_array($bookingFlight->seat_selections) ? implode(', ', $bookingFlight->seat_selections) : $bookingFlight->seat_selections }}
                                    </div>
                                </div>
                            @endif

                            @if($bookingFlight->meal_preferences)
                                <div class="mb-4">
                                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-2">Meal Preferences</h4>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ is_array($bookingFlight->meal_preferences) ? implode(', ', $bookingFlight->meal_preferences) : $bookingFlight->meal_preferences }}
                                    </div>
                                </div>
                            @endif

                            @if($bookingFlight->special_requests)
                                <div>
                                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-2">Special Requests</h4>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ is_array($bookingFlight->special_requests) ? implode(', ', $bookingFlight->special_requests) : $bookingFlight->special_requests }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Booking Summary -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Booking Summary</h3>
                        <div class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Main Booking</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $bookingFlight->booking->booking_reference }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingFlight->booking->user->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ticket Status</dt>
                                <dd class="mt-1 text-sm">{!! $bookingFlight->ticket_status_badge !!}</dd>
                            </div>
                            @if($bookingFlight->pnr_code)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">PNR Code</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $bookingFlight->pnr_code }}</dd>
                                </div>
                            @endif
                            @if($bookingFlight->ticket_numbers)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ticket Numbers</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $bookingFlight->ticket_numbers }}</dd>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Pricing Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Pricing Details</h3>
                        <div class="space-y-3">
                            @if($bookingFlight->adults > 0)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Adult Price ({{ $bookingFlight->adults }}x)</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">৳{{ number_format($bookingFlight->adult_price * $bookingFlight->adults, 2) }}</span>
                                </div>
                            @endif
                            @if($bookingFlight->children > 0 && $bookingFlight->child_price)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Child Price ({{ $bookingFlight->children }}x)</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">৳{{ number_format($bookingFlight->child_price * $bookingFlight->children, 2) }}</span>
                                </div>
                            @endif
                            @if($bookingFlight->infants > 0 && $bookingFlight->infant_price)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Infant Price ({{ $bookingFlight->infants }}x)</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">৳{{ number_format($bookingFlight->infant_price * $bookingFlight->infants, 2) }}</span>
                                </div>
                            @endif
                            @if($bookingFlight->taxes_fees > 0)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Taxes & Fees</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">৳{{ number_format($bookingFlight->taxes_fees, 2) }}</span>
                                </div>
                            @endif
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                                <div class="flex justify-between">
                                    <span class="text-base font-medium text-gray-900 dark:text-gray-100">Total Amount</span>
                                    <span class="text-base font-bold text-gray-900 dark:text-gray-100">৳{{ number_format($bookingFlight->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                @if(in_array($bookingFlight->ticket_status, ['pending', 'issued']))
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Actions</h3>
                            <div class="space-y-2">
                                <a href="{{ route('booking::admin.booking-flights.edit', $bookingFlight) }}" 
                                   class="w-full inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Flight Details
                                </a>
                                <button type="button" onclick="deleteFlightBooking({{ $bookingFlight->id }})"
                                        class="w-full inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete Flight
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Activity Log -->
                @if($bookingFlight->activities->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div class="p-6">
                            <x-utility::collapsible-card 
                                title="ActivityLog - Flight Booking"
                                :collapsed="true"
                                headerClass="bg-green-500 text-white hover:bg-green-600"
                                cardClass="border border-gray-200 dark:border-gray-600"
                            >
                                <x-utility::activity-log :model="$bookingFlight" />
                            </x-utility::collapsible-card>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function deleteFlightBooking(id) {
            if (confirm('Are you sure you want to delete this flight booking? This action cannot be undone.')) {
                fetch(`/admin-dashboard/booking-flights/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            window.location.href = '{{ route("booking::admin.booking-flights.index") }}';
                        }
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the flight booking.');
                });
            }
        }
    </script>
    @endpush
</x-admin-dashboard-layout::layout>