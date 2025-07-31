<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div>
                        <div class="flex items-center space-x-2 mb-2">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $hotel->name }}</h2>
                            <div class="text-yellow-400 text-lg">
                                {{ $hotel->star_rating_display }}
                            </div>
                            @if($hotel->is_featured)
                                {!! $hotel->featured_badge !!}
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $hotel->city->name }}, {{ $hotel->country->name }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin-dashboard.hotel.hotels.edit', $hotel) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('admin-dashboard.hotel.hotels.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
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
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hotel Name</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $hotel->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Star Rating</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $hotel->star_rating_display }} ({{ $hotel->star_rating }} {{ Str::plural('Star', $hotel->star_rating) }})
                                </p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Country</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $hotel->country->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">City</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $hotel->city->name }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Address</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $hotel->address }}</p>
                            </div>
                            @if($hotel->description)
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $hotel->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Contact Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if($hotel->phone)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Phone</label>
                                    <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $hotel->phone }}</p>
                                </div>
                            @endif
                            @if($hotel->email)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</label>
                                    <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        <a href="mailto:{{ $hotel->email }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $hotel->email }}</a>
                                    </p>
                                </div>
                            @endif
                            @if($hotel->website)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Website</label>
                                    <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        <a href="{{ $hotel->website }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $hotel->website }}</a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Location & Times -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Location & Times</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($hotel->latitude && $hotel->longitude)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Coordinates</label>
                                    <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $hotel->latitude }}, {{ $hotel->longitude }}</p>
                                </div>
                            @endif
                            @if($hotel->checkin_time)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Check-in Time</label>
                                    <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $hotel->checkin_time->format('H:i') }}</p>
                                </div>
                            @endif
                            @if($hotel->checkout_time)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Check-out Time</label>
                                    <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $hotel->checkout_time->format('H:i') }}</p>
                                </div>
                            @endif
                            @if($hotel->distance_from_airport)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Distance from Airport</label>
                                    <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $hotel->distance_from_airport }} km</p>
                                </div>
                            @endif
                            @if($hotel->distance_from_city_center)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Distance from City Center</label>
                                    <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $hotel->distance_from_city_center }} km</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Amenities -->
                    @if($hotel->amenities && count($hotel->amenities) > 0)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Amenities</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                                @foreach($hotel->amenities as $amenity)
                                    @php
                                        $amenityLabel = $hotel::getAvailableAmenities()[$amenity] ?? ucfirst(str_replace('_', ' ', $amenity));
                                    @endphp
                                    <div class="flex items-center bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-md text-xs">
                                        <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $amenityLabel }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Status & Stats -->
                <div class="space-y-6">
                    <!-- Status Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Status</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</label>
                                <div class="mt-1">{!! $hotel->status_badge !!}</div>
                            </div>
                            @if($hotel->is_featured)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Featured</label>
                                    <div class="mt-1">{!! $hotel->featured_badge !!}</div>
                                </div>
                            @endif
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Display Position</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $hotel->position }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Statistics</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Rooms</label>
                                <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $hotel->rooms_count }}</p>
                            </div>
                            @if($hotel->minimum_price > 0)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Starting Price</label>
                                    <p class="mt-1 text-xl font-semibold text-green-600 dark:text-green-400">৳{{ number_format($hotel->minimum_price, 0) }}</p>
                                </div>
                            @endif
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer Rating</label>
                                <div class="mt-1">{!! $hotel->rating_badge !!}</div>
                            </div>
                        </div>
                    </div>

                    <!-- System Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">System Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Slug</label>
                                <p class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100">{{ $hotel->slug }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $hotel->created_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $hotel->updated_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hotel ID</label>
                                <p class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100">#{{ $hotel->id }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin-dashboard.hotel.hotels.edit', $hotel) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Hotel
                            </a>
                            <a href="{{ route('admin-dashboard.hotel.hotels.create', ['country_id' => $hotel->country_id, 'city_id' => $hotel->city_id]) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md hover:bg-gray-50 dark:hover:bg-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Similar Hotel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>
