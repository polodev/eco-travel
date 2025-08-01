<x-admin-dashboard-layout::layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Booking Details</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $booking->booking_reference }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('booking::admin.bookings.index') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Bookings
                        </a>
                        @if(in_array($booking->status, ['pending', 'confirmed']))
                            <a href="{{ route('booking::admin.bookings.edit', $booking) }}" 
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Booking
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Booking Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Booking Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Booking Reference</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $booking->booking_reference }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Booking Type</dt>
                                <dd class="mt-1 text-sm">{!! $booking->booking_type_badge !!}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                <dd class="mt-1 text-sm">{!! $booking->status_badge !!}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Confirmation Code</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">
                                    {{ $booking->confirmation_code ?? 'Not assigned' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Booking Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->booking_date->format('M j, Y H:i') }}</dd>
                            </div>
                            @if($booking->confirmed_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Confirmed At</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->confirmed_at->format('M j, Y H:i') }}</dd>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Customer Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer Name</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->customer_details['name'] ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->customer_details['email'] ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nationality</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->customer_details['nationality'] ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->contact_details['phone'] ?? 'N/A' }}</dd>
                            </div>
                            @if(isset($booking->customer_details['passport_number']))
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Passport Number</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $booking->customer_details['passport_number'] }}</dd>
                            </div>
                            @endif
                            @if(isset($booking->contact_details['address']))
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->contact_details['address'] }}</dd>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Travel Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Travel Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($booking->travel_date)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Travel Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->travel_date->format('M j, Y') }}</dd>
                            </div>
                            @endif
                            @if($booking->return_date)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Return Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->return_date->format('M j, Y') }}</dd>
                            </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Adults</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->adults }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Children</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->children }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Infants</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $booking->infants }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Passengers</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $booking->total_passengers }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Discount Management -->
                <livewire:booking--discount :booking="$booking" />

                <!-- Payment Management -->
                <livewire:booking--payments :booking="$booking" />

                @if($booking->flightBookings->count() > 0 || $booking->hotelBookings->count() > 0 || $booking->tourBookings->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Booking Details</h3>
                        
                        @if($booking->flightBookings->count() > 0)
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-md font-medium text-gray-700 dark:text-gray-300">Flight Bookings ({{ $booking->flightBookings->count() }})</h4>
                                <a href="{{ route('booking::admin.booking-flights.index', ['booking_id' => $booking->id]) }}" 
                                   class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">View All →</a>
                            </div>
                            <div class="space-y-2">
                                @foreach($booking->flightBookings->take(3) as $flight)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded p-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $flight->departure_airport }} → {{ $flight->arrival_airport }}
                                            </p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                {{ $flight->airline_code }} {{ $flight->flight_number }} • {!! $flight->cabin_class_badge !!}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">৳{{ number_format($flight->total_amount, 2) }}</p>
                                            <p class="text-xs">{!! $flight->ticket_status_badge !!}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        @endif
                        <a href="{{ route('booking::admin.bookings.edit', $booking) }}" class="btn btn-primary">Edit Booking</a>
                        @if($booking->hotelBookings->count() > 0)
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-md font-medium text-gray-700 dark:text-gray-300">Hotel Bookings ({{ $booking->hotelBookings->count() }})</h4>
                                <a href="{{ route('booking::admin.booking-hotels.index', ['booking_id' => $booking->id]) }}" 
                                   class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">View All →</a>
                            </div>
                            <div class="space-y-2">
                                @foreach($booking->hotelBookings->take(3) as $hotel)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded p-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $hotel->hotel->name ?? 'Unknown Hotel' }}
                                            </p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                {{ $hotel->checkin_date }} to {{ $hotel->checkout_date }} • {{ $hotel->nights }} nights
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">৳{{ number_format($hotel->total_amount, 2) }}</p>
                                            <p class="text-xs">{!! $hotel->booking_status_badge !!}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($booking->tourBookings->count() > 0)
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-md font-medium text-gray-700 dark:text-gray-300">Tour Bookings ({{ $booking->tourBookings->count() }})</h4>
                                <a href="{{ route('booking::admin.booking-tours.index', ['booking_id' => $booking->id]) }}" 
                                   class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">View All →</a>
                            </div>
                            <div class="space-y-2">
                                @foreach($booking->tourBookings->take(3) as $tour)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded p-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $tour->tour->name ?? 'Unknown Tour' }}
                                            </p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                {{ $tour->tour_start_date }} to {{ $tour->tour_end_date }} • {{ $tour->tour_duration }} days
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">৳{{ number_format($tour->total_amount, 2) }}</p>
                                            <p class="text-xs">{!! $tour->booking_status_badge !!}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Additional Information -->
                @if($booking->notes || $booking->additional_requirements)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Additional Information</h3>
                        @if($booking->additional_requirements)
                        <div class="mb-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Special Requirements</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 p-3 rounded">
                                @if(is_array($booking->additional_requirements))
                                    @foreach($booking->additional_requirements as $key => $value)
                                        <div><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</div>
                                    @endforeach
                                @else
                                    {{ $booking->additional_requirements }}
                                @endif
                            </dd>
                        </div>
                        @endif
                        @if($booking->notes)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Internal Notes</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 p-3 rounded">{{ $booking->notes }}</dd>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Stats -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Quick Stats</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">User Account</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $booking->user->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Payment Progress</span>
                                <span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $booking->payment_completion_percentage }}%</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Days Until Travel</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    @if($booking->travel_date)
                                        {{ $booking->travel_date->diffInDays(now(), false) > 0 ? 'Completed' : abs($booking->travel_date->diffInDays(now())) . ' days' }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Actions</h3>
                        <div class="space-y-2">
                            @if($booking->booking_type === 'flight' || $booking->booking_type === 'package')
                                @if($booking->flightBookings->count() > 0)
                                <a href="{{ route('booking::admin.booking-flights.index', ['booking_id' => $booking->id]) }}" 
                                   class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md hover:bg-purple-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Flight Details ({{ $booking->flightBookings->count() }})
                                </a>
                                @endif
                            @endif

                            @if($booking->booking_type === 'hotel' || $booking->booking_type === 'package')
                                @if($booking->hotelBookings->count() > 0)
                                <a href="{{ route('booking::admin.booking-hotels.index', ['booking_id' => $booking->id]) }}" 
                                   class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Hotel Details ({{ $booking->hotelBookings->count() }})
                                </a>
                                @endif
                            @endif

                            @if($booking->booking_type === 'tour' || $booking->booking_type === 'package')
                                @if($booking->tourBookings->count() > 0)
                                <a href="{{ route('booking::admin.booking-tours.index', ['booking_id' => $booking->id]) }}" 
                                   class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Tour Details ({{ $booking->tourBookings->count() }})
                                </a>
                                @endif
                            @endif

                            <a href="#" class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Print Booking
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Activity Log -->
                @if($booking->activities->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div class="p-6">
                            <x-utility::collapsible-card 
                                title="ActivityLog - Booking"
                                :collapsed="true"
                                headerClass="bg-green-500 text-white hover:bg-green-600"
                                cardClass="border border-gray-200 dark:border-gray-600"
                            >
                                <x-utility::activity-log :model="$booking" />
                            </x-utility::collapsible-card>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>