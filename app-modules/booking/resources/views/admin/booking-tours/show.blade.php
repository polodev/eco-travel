<x-admin-dashboard-layout::layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Tour Booking Details</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $bookingTour->booking->booking_reference }} - {{ $bookingTour->tour->title ?? 'N/A' }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin-dashboard.booking.booking-tours.index') }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Tour Bookings
                        </a>
                        <a href="{{ route('admin-dashboard.booking.bookings.show', $bookingTour->booking) }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-800 border border-blue-200 dark:border-blue-600 rounded-md hover:bg-blue-100 dark:hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            View Main Booking
                        </a>
                        @if(in_array($bookingTour->booking_status, ['pending', 'confirmed']))
                            <a href="{{ route('admin-dashboard.booking.booking-tours.edit', $bookingTour) }}" 
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Tour Booking
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Tour Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Tour Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tour</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingTour->tour->title ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Duration</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingTour->tour_duration }} day{{ $bookingTour->tour_duration > 1 ? 's' : '' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Start Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingTour->tour_start_date->format('M j, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">End Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingTour->tour_end_date->format('M j, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Accommodation Type</dt>
                                <dd class="mt-1 text-sm">{!! $bookingTour->accommodation_type_badge !!}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Booking Status</dt>
                                <dd class="mt-1 text-sm">{!! $bookingTour->booking_status_badge !!}</dd>
                            </div>
                            @if($bookingTour->tour_guide)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tour Guide</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingTour->tour_guide }}</dd>
                                </div>
                            @endif
                            @if($bookingTour->tour_voucher)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tour Voucher</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $bookingTour->tour_voucher }}</dd>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Participant Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Participant Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $bookingTour->adults }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Adult{{ $bookingTour->adults > 1 ? 's' : '' }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $bookingTour->children }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Child{{ $bookingTour->children > 1 ? 'ren' : '' }}</div>
                            </div>
                        </div>
                        
                        @if($bookingTour->participant_details)
                            <div class="mt-6">
                                <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-3">Participant Details</h4>
                                <div class="space-y-3">
                                    @foreach($bookingTour->participant_details as $index => $participant)
                                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $participant['name'] ?? 'N/A' }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ ucfirst($participant['type'] ?? 'adult') }}
                                                        @if(isset($participant['age']))
                                                            • Age: {{ $participant['age'] }}
                                                        @endif
                                                    </div>
                                                </div>
                                                @if(isset($participant['passport_number']))
                                                    <div class="text-sm text-gray-500 dark:text-gray-400 font-mono">
                                                        {{ $participant['passport_number'] }}
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

                <!-- Tour Details -->
                @if($bookingTour->pickup_details || $bookingTour->tour_inclusions || $bookingTour->tour_exclusions)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Tour Details</h3>
                            
                            @if($bookingTour->pickup_details)
                                <div class="mb-4">
                                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-2">Pickup Details</h4>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        @if(is_array($bookingTour->pickup_details))
                                            <div>Location: {{ $bookingTour->pickup_details['location'] ?? 'N/A' }}</div>
                                            <div>Time: {{ $bookingTour->pickup_details['time'] ?? 'N/A' }}</div>
                                        @else
                                            {{ $bookingTour->pickup_details }}
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($bookingTour->tour_inclusions)
                                <div class="mb-4">
                                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-2">Tour Inclusions</h4>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        @if(is_array($bookingTour->tour_inclusions))
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach($bookingTour->tour_inclusions as $inclusion)
                                                    <li>{{ $inclusion }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            {{ $bookingTour->tour_inclusions }}
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($bookingTour->tour_exclusions)
                                <div class="mb-4">
                                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-2">Tour Exclusions</h4>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        @if(is_array($bookingTour->tour_exclusions))
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach($bookingTour->tour_exclusions as $exclusion)
                                                    <li>{{ $exclusion }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            {{ $bookingTour->tour_exclusions }}
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($bookingTour->what_to_bring)
                                <div>
                                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-2">What to Bring</h4>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        @if(is_array($bookingTour->what_to_bring))
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach($bookingTour->what_to_bring as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            {{ $bookingTour->what_to_bring }}
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Special Requirements -->
                @if($bookingTour->dietary_requirements || $bookingTour->medical_conditions || $bookingTour->special_requests)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Special Requirements</h3>
                            
                            @if($bookingTour->dietary_requirements)
                                <div class="mb-4">
                                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-2">Dietary Requirements</h4>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ is_array($bookingTour->dietary_requirements) ? implode(', ', $bookingTour->dietary_requirements) : $bookingTour->dietary_requirements }}
                                    </div>
                                </div>
                            @endif

                            @if($bookingTour->medical_conditions)
                                <div class="mb-4">
                                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-2">Medical Conditions</h4>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ is_array($bookingTour->medical_conditions) ? implode(', ', $bookingTour->medical_conditions) : $bookingTour->medical_conditions }}
                                    </div>
                                </div>
                            @endif

                            @if($bookingTour->special_requests)
                                <div>
                                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-2">Special Requests</h4>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ is_array($bookingTour->special_requests) ? implode(', ', $bookingTour->special_requests) : $bookingTour->special_requests }}
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
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $bookingTour->booking->booking_reference }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingTour->booking->user->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Booking Status</dt>
                                <dd class="mt-1 text-sm">{!! $bookingTour->booking_status_badge !!}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Participants</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $bookingTour->total_participants }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Pricing Details</h3>
                        <div class="space-y-3">
                            @if($bookingTour->adults > 0)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Adult Price ({{ $bookingTour->adults }}x)</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">৳{{ number_format($bookingTour->adult_price * $bookingTour->adults, 2) }}</span>
                                </div>
                            @endif
                            @if($bookingTour->children > 0 && $bookingTour->child_price)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Child Price ({{ $bookingTour->children }}x)</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">৳{{ number_format($bookingTour->child_price * $bookingTour->children, 2) }}</span>
                                </div>
                            @endif
                            @if($bookingTour->single_supplement > 0)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Single Supplement</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">৳{{ number_format($bookingTour->single_supplement, 2) }}</span>
                                </div>
                            @endif
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                                <div class="flex justify-between">
                                    <span class="text-base font-medium text-gray-900 dark:text-gray-100">Total Amount</span>
                                    <span class="text-base font-bold text-gray-900 dark:text-gray-100">৳{{ number_format($bookingTour->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                @if(in_array($bookingTour->booking_status, ['pending', 'confirmed']))
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Actions</h3>
                            <div class="space-y-2">
                                <a href="{{ route('admin-dashboard.booking.booking-tours.edit', $bookingTour) }}" 
                                   class="w-full inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Tour Details
                                </a>
                                <button type="button" onclick="deleteTourBooking({{ $bookingTour->id }})"
                                        class="w-full inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete Tour Booking
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
        function deleteTourBooking(id) {
            if (confirm('Are you sure you want to delete this tour booking? This action cannot be undone.')) {
                fetch(`/admin-dashboard/booking-tours/${id}`, {
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
                            window.location.href = '{{ route("admin-dashboard.booking.booking-tours.index") }}';
                        }
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the tour booking.');
                });
            }
        }
    </script>
    @endpush
</x-admin-dashboard-layout::layout>