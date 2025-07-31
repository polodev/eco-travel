<x-admin-dashboard-layout::layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Hotel Booking Details</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $bookingHotel->booking->booking_reference }} - {{ $bookingHotel->hotel->name ?? 'N/A' }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin-dashboard.booking.booking-hotels.index') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Hotel Bookings
                        </a>
                        <a href="{{ route('admin-dashboard.booking.bookings.show', $bookingHotel->booking) }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-800 border border-blue-200 dark:border-blue-600 rounded-md hover:bg-blue-100 dark:hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            View Main Booking
                        </a>
                        @if(in_array($bookingHotel->booking_status, ['pending', 'confirmed']))
                            <a href="{{ route('admin-dashboard.booking.booking-hotels.edit', $bookingHotel) }}" 
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Hotel Booking
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Hotel Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Hotel Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Hotel</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingHotel->hotel->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Room Type</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingHotel->hotelRoom->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Check-in Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingHotel->checkin_date->format('M j, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Check-out Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingHotel->checkout_date->format('M j, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nights</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingHotel->nights }} night{{ $bookingHotel->nights > 1 ? 's' : '' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Rooms</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingHotel->rooms }} room{{ $bookingHotel->rooms > 1 ? 's' : '' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Rate Plan</dt>
                                <dd class="mt-1 text-sm">{!! $bookingHotel->rate_plan_badge !!}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Booking Status</dt>
                                <dd class="mt-1 text-sm">{!! $bookingHotel->booking_status_badge !!}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guest Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Guest Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $bookingHotel->adults }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Adult{{ $bookingHotel->adults > 1 ? 's' : '' }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $bookingHotel->children }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Child{{ $bookingHotel->children > 1 ? 'ren' : '' }}</div>
                            </div>
                        </div>
                        
                        @if($bookingHotel->guest_details)
                            <div class="mt-6">
                                <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-3">Guest Details</h4>
                                <div class="space-y-3">
                                    @foreach($bookingHotel->guest_details as $index => $guest)
                                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $guest['name'] ?? 'N/A' }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ ucfirst($guest['type'] ?? 'adult') }}
                                                        @if(isset($guest['age']))
                                                            • Age: {{ $guest['age'] }}
                                                        @endif
                                                    </div>
                                                </div>
                                                @if(isset($guest['id_number']))
                                                    <div class="text-sm text-gray-500 dark:text-gray-400 font-mono">
                                                        ID: {{ $guest['id_number'] }}
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
                @if($bookingHotel->room_preferences || $bookingHotel->special_requests || $bookingHotel->included_services)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Additional Services & Preferences</h3>
                            
                            @if($bookingHotel->room_preferences)
                                <div class="mb-4">
                                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-2">Room Preferences</h4>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ is_array($bookingHotel->room_preferences) ? implode(', ', $bookingHotel->room_preferences) : $bookingHotel->room_preferences }}
                                    </div>
                                </div>
                            @endif

                            @if($bookingHotel->included_services)
                                <div class="mb-4">
                                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-2">Included Services</h4>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ is_array($bookingHotel->included_services) ? implode(', ', $bookingHotel->included_services) : $bookingHotel->included_services }}
                                    </div>
                                </div>
                            @endif

                            @if($bookingHotel->special_requests)
                                <div>
                                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-2">Special Requests</h4>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ is_array($bookingHotel->special_requests) ? implode(', ', $bookingHotel->special_requests) : $bookingHotel->special_requests }}
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
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $bookingHotel->booking->booking_reference }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingHotel->booking->user->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Booking Status</dt>
                                <dd class="mt-1 text-sm">{!! $bookingHotel->booking_status_badge !!}</dd>
                            </div>
                            @if($bookingHotel->confirmation_number)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Confirmation Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $bookingHotel->confirmation_number }}</dd>
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
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Room Rate (per night)</span>
                                <span class="text-sm text-gray-900 dark:text-gray-100">৳{{ number_format($bookingHotel->room_rate, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Total Room Cost ({{ $bookingHotel->nights }} nights × {{ $bookingHotel->rooms }} rooms)</span>
                                <span class="text-sm text-gray-900 dark:text-gray-100">৳{{ number_format($bookingHotel->total_room_cost, 2) }}</span>
                            </div>
                            @if($bookingHotel->taxes_fees > 0)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Taxes & Fees</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">৳{{ number_format($bookingHotel->taxes_fees, 2) }}</span>
                                </div>
                            @endif
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                                <div class="flex justify-between">
                                    <span class="text-base font-medium text-gray-900 dark:text-gray-100">Total Amount</span>
                                    <span class="text-base font-bold text-gray-900 dark:text-gray-100">৳{{ number_format($bookingHotel->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                @if(in_array($bookingHotel->booking_status, ['pending', 'confirmed']))
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Actions</h3>
                            <div class="space-y-2">
                                <a href="{{ route('admin-dashboard.booking.booking-hotels.edit', $bookingHotel) }}" 
                                   class="w-full inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Hotel Details
                                </a>
                                <button type="button" onclick="deleteHotelBooking({{ $bookingHotel->id }})"
                                        class="w-full inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete Hotel Booking
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function deleteHotelBooking(id) {
            if (confirm('Are you sure you want to delete this hotel booking? This action cannot be undone.')) {
                fetch(`/admin-dashboard/booking-hotels/${id}`, {
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
                            window.location.href = '{{ route("admin-dashboard.booking.booking-hotels.index") }}';
                        }
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the hotel booking.');
                });
            }
        }
    </script>
    @endpush
</x-admin-dashboard-layout::layout>