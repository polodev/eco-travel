<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    @if($airline->hasLogo())
                        <img src="{{ $airline->logo_medium_url }}" alt="{{ $airline->name }}" class="w-12 h-12 rounded border object-cover">
                    @else
                        <div class="w-12 h-12 rounded border bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $airline->name }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $airline->code }} / {{ $airline->icao_code }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('flight::admin.airlines.edit', $airline->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('flight::admin.airlines.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
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
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Airline Name</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $airline->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</label>
                                <div class="mt-1">{!! $airline->status_badge !!}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">IATA Code</label>
                                <p class="mt-1 text-sm font-mono font-medium text-gray-900 dark:text-gray-100">{{ $airline->code }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ICAO Code</label>
                                <p class="mt-1 text-sm font-mono font-medium text-gray-900 dark:text-gray-100">{{ $airline->icao_code }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Country</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $airline->country ? $airline->country->name : 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Founded Year</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $airline->founded ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($airline->alliance || $airline->headquarters || $airline->website)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Additional Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($airline->alliance && $airline->alliance !== 'none')
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Alliance</label>
                                <div class="mt-1">{!! $airline->alliance_badge !!}</div>
                            </div>
                            @endif
                            @if($airline->headquarters)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Headquarters</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $airline->headquarters }}</p>
                            </div>
                            @endif
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Low Cost Carrier</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $airline->is_low_cost ? 'Yes' : 'No' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Display Position</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $airline->position ?? 'N/A' }}</p>
                            </div>
                            @if($airline->website)
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Website</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    <a href="{{ $airline->website }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">{{ $airline->website }}</a>
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Related Data -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Related Data</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Flights -->
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">Flights ({{ $airline->flights->count() }})</h4>
                                    <a href="{{ route('flight::admin.flights.index') }}?airline_id={{ $airline->id }}" class="text-xs text-blue-600 hover:text-blue-800">View All</a>
                                </div>
                                @if($airline->flights->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($airline->flights->take(5) as $flight)
                                            <div class="flex items-center justify-between py-1">
                                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $flight->flight_number }}</span>
                                                @if($flight->departureAirport && $flight->arrivalAirport)
                                                    <span class="text-xs text-gray-500">{{ $flight->departureAirport->iata_code }} → {{ $flight->arrivalAirport->iata_code }}</span>
                                                @endif
                                            </div>
                                        @endforeach
                                        @if($airline->flights->count() > 5)
                                            <p class="text-xs text-gray-500 pt-1">and {{ $airline->flights->count() - 5 }} more...</p>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No flights added yet</p>
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
                            <a href="{{ route('flight::admin.flights.create') }}?airline_id={{ $airline->id }}" class="block w-full text-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                Add Flight
                            </a>
                            @if($airline->is_low_cost)
                            <div class="text-center">
                                {!! $airline->low_cost_badge !!}
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Meta Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Meta Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</label>
                                <p class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100">{{ $airline->id }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $airline->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                            @if($airline->updated_at && $airline->updated_at != $airline->created_at)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $airline->updated_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>