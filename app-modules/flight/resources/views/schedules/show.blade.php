<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded border bg-blue-100 dark:bg-blue-800 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $flightSchedule->flight->airline->name }} {{ $flightSchedule->flight->flight_number }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $flightSchedule->flight->departureAirport->iata_code }} → {{ $flightSchedule->flight->arrivalAirport->iata_code }} - {{ \Carbon\Carbon::parse($flightSchedule->scheduled_departure)->format('M j, Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin-dashboard.flight.flight-schedules.edit', $flightSchedule->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <form method="POST" action="{{ route('admin-dashboard.flight.flight-schedules.destroy', $flightSchedule->id) }}" class="inline-block" 
                          onsubmit="return confirm('Are you sure you want to delete this flight schedule? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Schedule Information -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Schedule Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Flight Number</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $flightSchedule->flight->airline->name }} {{ $flightSchedule->flight->flight_number }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</label>
                                <div class="mt-1">{!! $flightSchedule->status_badge !!}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Route</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $flightSchedule->flight->departureAirport->name }} → {{ $flightSchedule->flight->arrivalAirport->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Flight Date</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($flightSchedule->scheduled_departure)->format('M j, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Departure Time</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($flightSchedule->scheduled_departure)->format('H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Arrival Time</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($flightSchedule->scheduled_arrival)->format('H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    @if($flightSchedule->terminal || $flightSchedule->gate)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Terminal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($flightSchedule->terminal)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Terminal</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $flightSchedule->terminal }}</p>
                            </div>
                            @endif
                            @if($flightSchedule->gate)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Gate</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $flightSchedule->gate }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Pricing Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Economy Class</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">৳{{ number_format($flightSchedule->economy_price, 0) }}</p>
                                <p class="text-xs text-gray-500">{{ $flightSchedule->available_economy_seats }} / {{ $flightSchedule->flight->economy_seats }} seats</p>
                            </div>
                            @if($flightSchedule->business_price)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Business Class</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">৳{{ number_format($flightSchedule->business_price, 0) }}</p>
                                <p class="text-xs text-gray-500">{{ $flightSchedule->available_business_seats }} / {{ $flightSchedule->flight->business_seats }} seats</p>
                            </div>
                            @endif
                            @if($flightSchedule->first_price)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">First Class</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">৳{{ number_format($flightSchedule->first_price, 0) }}</p>
                                <p class="text-xs text-gray-500">{{ $flightSchedule->available_first_seats }} / {{ $flightSchedule->flight->first_seats }} seats</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($flightSchedule->delay_minutes > 0 || $flightSchedule->notes)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Additional Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($flightSchedule->delay_minutes > 0)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Delay</label>
                                <p class="mt-1 text-sm font-medium text-red-600 dark:text-red-400">{{ $flightSchedule->delay_minutes }} minutes</p>
                            </div>
                            @endif
                            @if($flightSchedule->notes)
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Notes</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $flightSchedule->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <button type="button" onclick="updateStatus('scheduled')" class="block w-full text-center px-3 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                                Mark as Scheduled
                            </button>
                            <button type="button" onclick="updateStatus('delayed')" class="block w-full text-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                                Mark as Delayed
                            </button>
                            <button type="button" onclick="updateStatus('departed')" class="block w-full text-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                Mark as Departed
                            </button>
                            <button type="button" onclick="updateStatus('arrived')" class="block w-full text-center px-3 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md hover:bg-purple-700">
                                Mark as Arrived
                            </button>
                        </div>
                    </div>

                    <!-- Airport Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Route Details</h3>
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-gray-100 mb-2">Departure</h4>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $flightSchedule->flight->departureAirport->name }}</p>
                                <p class="text-xs text-gray-500">{{ $flightSchedule->flight->departureAirport->iata_code }} - {{ $flightSchedule->flight->departureAirport->city->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-gray-100 mb-2">Arrival</h4>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $flightSchedule->flight->arrivalAirport->name }}</p>
                                <p class="text-xs text-gray-500">{{ $flightSchedule->flight->arrivalAirport->iata_code }} - {{ $flightSchedule->flight->arrivalAirport->city->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Meta Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Meta Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Schedule ID</label>
                                <p class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100">{{ $flightSchedule->id }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $flightSchedule->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                            @if($flightSchedule->updated_at && $flightSchedule->updated_at != $flightSchedule->created_at)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $flightSchedule->updated_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function updateStatus(status) {
            if (confirm('Are you sure you want to update the status to "' + status + '"?')) {
                $.ajax({
                    url: "{{ route('admin-dashboard.flight.flight-schedules.update-status', $flightSchedule->id) }}",
                    type: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Error updating status: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Error updating status.');
                    }
                });
            }
        }
    </script>
    @endpush
</x-admin-dashboard-layout::layout>