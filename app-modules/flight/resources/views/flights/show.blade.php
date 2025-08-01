<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded border bg-blue-100 dark:bg-blue-800 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $flight->airline->name }} {{ $flight->flight_number }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $flight->route_display }} - {{ $flight->duration_display }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('flight::admin.flights.edit', $flight->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <form method="POST" action="{{ route('flight::admin.flights.destroy', $flight->id) }}" class="inline-block" 
                          onsubmit="return confirm('Are you sure you want to delete this flight? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                    <a href="{{ route('flight::admin.flights.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
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
                <!-- Basic Information -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Flight Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Flight Number</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $flight->full_flight_number }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</label>
                                <div class="mt-1">{!! $flight->status_badge !!}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Route</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $flight->route_display }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Flight Type</label>
                                <div class="mt-1">{!! $flight->flight_type_badge !!}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aircraft Type</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ \Modules\Flight\Models\Flight::getAvailableAircraftTypes()[$flight->aircraft_type] ?? $flight->aircraft_type }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Duration</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $flight->duration_display }}</p>
                            </div>
                        </div>
                    </div>

                    @if($flight->departure_time || $flight->arrival_time)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Schedule Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($flight->departure_time)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Departure Time</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $flight->departure_time->format('H:i') }}</p>
                            </div>
                            @endif
                            @if($flight->arrival_time)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Arrival Time</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $flight->arrival_time->format('H:i') }}</p>
                            </div>
                            @endif
                            @if($flight->operating_days && count($flight->operating_days) > 0)
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Operating Days</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $flight->operating_days_display }}</p>
                            </div>
                            @endif
                            @if($flight->base_price)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Base Price</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">৳{{ number_format($flight->base_price, 0) }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($flight->total_seats || $flight->economy_seats || $flight->business_seats || $flight->first_seats)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Seat Configuration</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @if($flight->total_seats)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Seats</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ number_format($flight->total_seats) }}</p>
                            </div>
                            @endif
                            @if($flight->economy_seats)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Economy</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ number_format($flight->economy_seats) }}</p>
                            </div>
                            @endif
                            @if($flight->business_seats)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Business</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ number_format($flight->business_seats) }}</p>
                            </div>
                            @endif
                            @if($flight->first_seats)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">First Class</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ number_format($flight->first_seats) }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($flight->has_meal || $flight->has_wifi || $flight->has_entertainment)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Amenities</h3>
                        <div class="space-y-2">
                            {!! $flight->amenities_badges !!}
                        </div>
                    </div>
                    @endif

                    <!-- Related Data -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Related Data</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Schedules -->
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">Flight Schedules ({{ $flight->schedules->count() }})</h4>
                                    <a href="{{ route('flight::admin.flight-schedules.index') }}?flight_id={{ $flight->id }}" class="text-xs text-blue-600 hover:text-blue-800">View All</a>
                                </div>
                                @if($flight->schedules->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($flight->schedules->take(5) as $schedule)
                                            <div class="flex items-center justify-between py-1">
                                                <span class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $schedule->departure_datetime ? $schedule->departure_datetime->format('M d, Y') : 'Not scheduled' }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ $schedule->departure_datetime ? $schedule->departure_datetime->format('H:i') : '--:--' }} - 
                                                    {{ $schedule->arrival_datetime ? $schedule->arrival_datetime->format('H:i') : '--:--' }}
                                                </span>
                                            </div>
                                        @endforeach
                                        @if($flight->schedules->count() > 5)
                                            <p class="text-xs text-gray-500 pt-1">and {{ $flight->schedules->count() - 5 }} more...</p>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No schedules added yet</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('flight::admin.flight-schedules.create') }}?flight_id={{ $flight->id }}" class="block w-full text-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                Add Schedule
                            </a>
                        </div>
                    </div>

                    <!-- Airport Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Route Details</h3>
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-gray-100 mb-2">Departure</h4>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $flight->departureAirport->name }}</p>
                                <p class="text-xs text-gray-500">{{ $flight->departureAirport->iata_code }} - {{ $flight->departureAirport->city->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-gray-100 mb-2">Arrival</h4>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $flight->arrivalAirport->name }}</p>
                                <p class="text-xs text-gray-500">{{ $flight->arrivalAirport->iata_code }} - {{ $flight->arrivalAirport->city->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Meta Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Meta Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</label>
                                <p class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100">{{ $flight->id }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $flight->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                            @if($flight->updated_at && $flight->updated_at != $flight->created_at)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $flight->updated_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>