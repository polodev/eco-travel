<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Booking Details</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Reference: {{ $booking->booking_reference }}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin-dashboard.booking.bookings.index') }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        Back to Bookings
                    </a>
                    @if($booking->isModifiable())
                        <a href="{{ route('admin-dashboard.booking.bookings.edit', $booking) }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Booking
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Booking Information -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Booking Summary -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Booking Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking Reference</label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $booking->booking_reference }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking Type</label>
                                <div class="mt-1">{!! $booking->booking_type_badge !!}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <div class="mt-1">{!! $booking->status_badge !!}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Status</label>
                                <div class="mt-1">{!! $booking->payment_status_badge !!}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking Date</label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->created_at->format('M j, Y H:i') }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Travel Date</label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->travel_date_formatted }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Customer Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Holder</label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->user->name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $booking->user->email ?? 'N/A' }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer Name</label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->customer_name }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->customer_email }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
                                <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->customer_phone }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Passenger Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Passenger Information</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $booking->adults }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Adults</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $booking->children }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Children</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $booking->infants }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Infants</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Payment Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Total Amount</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">৳{{ number_format($booking->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Discount</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">৳{{ number_format($booking->discount, 2) }}</span>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 dark:border-gray-600 pt-3">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Net Receivable</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $booking->formatted_net_receivable_amount }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Paid Amount</span>
                                <span class="text-sm font-medium text-green-600 dark:text-green-400">{{ $booking->formatted_total_paid }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Remaining</span>
                                <span class="text-sm font-medium text-red-600 dark:text-red-400">{{ $booking->formatted_remaining_amount }}</span>
                            </div>
                        </div>

                        <!-- Payment Progress -->
                        <div class="mt-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600 dark:text-gray-400">Payment Progress</span>
                                <span class="text-gray-900 dark:text-gray-100">{{ $booking->payment_completion_percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-600">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $booking->payment_completion_percentage }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Related Bookings</h3>
                        <div class="space-y-2">
                            @if($booking->flightBookings->count() > 0)
                                <a href="{{ route('admin-dashboard.booking.booking-flights.index', ['booking_id' => $booking->id]) }}" 
                                   class="block w-full text-left px-3 py-2 text-sm text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 rounded hover:bg-blue-100 dark:hover:bg-blue-900/40">
                                    View Flight Bookings ({{ $booking->flightBookings->count() }})
                                </a>
                            @endif
                            @if($booking->hotelBookings->count() > 0)
                                <a href="{{ route('admin-dashboard.booking.booking-hotels.index', ['booking_id' => $booking->id]) }}" 
                                   class="block w-full text-left px-3 py-2 text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 rounded hover:bg-green-100 dark:hover:bg-green-900/40">
                                    View Hotel Bookings ({{ $booking->hotelBookings->count() }})
                                </a>
                            @endif
                            @if($booking->tourBookings->count() > 0)
                                <a href="{{ route('admin-dashboard.booking.booking-tours.index', ['booking_id' => $booking->id]) }}" 
                                   class="block w-full text-left px-3 py-2 text-sm text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-900/20 rounded hover:bg-purple-100 dark:hover:bg-purple-900/40">
                                    View Tour Bookings ({{ $booking->tourBookings->count() }})
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>