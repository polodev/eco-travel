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
                    <a href="{{ route('hotel::admin.hotels.edit', $hotel) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('hotel::admin.hotels.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
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

                    <!-- Hotel Rooms -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Hotel Rooms ({{ $hotel->rooms->count() }})</h3>
                            <a href="{{ route('hotel::admin.rooms.create', ['hotel_id' => $hotel->id]) }}" 
                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Room
                            </a>
                        </div>
                        
                        @if($hotel->rooms->count() > 0)
                            <div class="space-y-3">
                                @foreach($hotel->rooms->sortBy('position') as $room)
                                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3 mb-2">
                                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $room->name }}</h4>
                                                    {!! $room->room_type_badge !!}
                                                    {!! $room->status_badge !!}
                                                    @if($room->is_refundable)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                            Refundable
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600 dark:text-gray-400">
                                                    <div>
                                                        <span class="font-medium">Occupancy:</span> {{ $room->occupancy_display }}
                                                    </div>
                                                    <div>
                                                        <span class="font-medium">Bed:</span> {{ $room->bed_display }}
                                                    </div>
                                                    <div>
                                                        <span class="font-medium">Size:</span> {{ $room->room_size_display }}
                                                    </div>
                                                    <div>
                                                        <span class="font-medium">Price:</span> 
                                                        <span class="text-green-600 dark:text-green-400 font-semibold">৳{{ number_format($room->base_price, 0) }}</span>
                                                    </div>
                                                </div>
                                                @if($room->amenities && count($room->amenities) > 0)
                                                    <div class="mt-2">
                                                        {!! $room->amenities_display !!}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex items-center space-x-2 ml-4">
                                                <a href="{{ route('hotel::admin.rooms.show', $room) }}" 
                                                   class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded hover:bg-blue-100 dark:hover:bg-blue-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    View
                                                </a>
                                                <a href="{{ route('hotel::admin.rooms.edit', $room) }}" 
                                                   class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 dark:text-yellow-300 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded hover:bg-yellow-100 dark:hover:bg-yellow-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- View All Rooms Link -->
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                <a href="{{ route('hotel::admin.rooms.index', ['hotel_id' => $hotel->id]) }}" 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-md hover:bg-blue-100 dark:hover:bg-blue-800">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Manage All Rooms for {{ $hotel->name }}
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 text-4xl mb-3">
                                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-medium text-gray-600 dark:text-gray-400 mb-2">No Rooms Found</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-500 mb-4">This hotel doesn't have any rooms configured yet.</p>
                                <a href="{{ route('hotel::admin.rooms.create', ['hotel_id' => $hotel->id]) }}" 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add First Room
                                </a>
                            </div>
                        @endif
                    </div>
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
                            <a href="{{ route('hotel::admin.hotels.edit', $hotel) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Hotel
                            </a>
                            <a href="{{ route('hotel::admin.hotels.create', ['country_id' => $hotel->country_id, 'city_id' => $hotel->city_id]) }}" 
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
