<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div>
                        <div class="flex items-center space-x-2 mb-2">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Room Inventory Details</h2>
                            {!! $roomInventory->availability_badge !!}
                            @if($roomInventory->discount_percentage > 0)
                                {!! $roomInventory->discount_badge !!}
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <a href="{{ route('hotel::admin.hotels.show', $roomInventory->hotelRoom->hotel) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $roomInventory->hotelRoom->hotel->name }}</a> - 
                            <a href="{{ route('hotel::admin.rooms.show', $roomInventory->hotelRoom) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $roomInventory->hotelRoom->name }}</a>
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('hotel::admin.room-inventories.edit', $roomInventory) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('hotel::admin.room-inventories.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
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
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hotel</label>
                                <p class="mt-1 text-sm font-medium">
                                    <a href="{{ route('hotel::admin.hotels.show', $roomInventory->hotelRoom->hotel) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline transition-colors">
                                        {{ $roomInventory->hotelRoom->hotel->name }}
                                    </a>
                                </p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Room</label>
                                <p class="mt-1 text-sm font-medium">
                                    <a href="{{ route('hotel::admin.rooms.show', $roomInventory->hotelRoom) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline transition-colors">
                                        {{ $roomInventory->hotelRoom->name }}
                                    </a>
                                </p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $roomInventory->date_formatted }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Rate Plan</label>
                                <div class="mt-1">{!! $roomInventory->rate_plan_badge !!}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Room Availability -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Room Availability</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Rooms</label>
                                <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $roomInventory->total_rooms }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Available</label>
                                <p class="mt-1 text-2xl font-bold text-green-600 dark:text-green-400">{{ $roomInventory->available_rooms }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Booked</label>
                                <p class="mt-1 text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $roomInventory->booked_rooms }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Blocked</label>
                                <p class="mt-1 text-2xl font-bold text-red-600 dark:text-red-400">{{ $roomInventory->blocked_rooms }}</p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Occupancy Rate</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $roomInventory->occupancy_percentage }}%</span>
                            </div>
                            <div class="mt-2 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $roomInventory->occupancy_percentage }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Pricing Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Base Price</label>
                                <p class="mt-1 text-lg font-medium text-gray-900 dark:text-gray-100">৳{{ number_format($roomInventory->price, 2) }}</p>
                            </div>
                            @if($roomInventory->discount_percentage > 0)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Discount</label>
                                    <p class="mt-1 text-lg font-medium text-red-600 dark:text-red-400">{{ $roomInventory->discount_percentage }}% OFF</p>
                                </div>
                            @endif
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Final Price</label>
                                <p class="mt-1 text-xl font-bold text-green-600 dark:text-green-400">৳{{ number_format($roomInventory->final_price, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stay Requirements -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Stay Requirements</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Minimum Stay</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $roomInventory->minimum_stay }} {{ Str::plural('night', $roomInventory->minimum_stay) }}</p>
                            </div>
                            @if($roomInventory->maximum_stay)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Maximum Stay</label>
                                    <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $roomInventory->maximum_stay }} {{ Str::plural('night', $roomInventory->maximum_stay) }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="mt-4">
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Summary</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $roomInventory->stay_requirements }}</p>
                        </div>
                    </div>

                    <!-- Inclusions -->
                    @if($roomInventory->inclusions && count($roomInventory->inclusions) > 0)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Inclusions</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach($roomInventory->inclusions as $inclusion)
                                    @php
                                        $inclusionLabel = $roomInventory::getAvailableInclusions()[$inclusion] ?? ucfirst(str_replace('_', ' ', $inclusion));
                                    @endphp
                                    <div class="flex items-center bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-200 px-3 py-2 rounded-md text-sm">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $inclusionLabel }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Notes -->
                    @if($roomInventory->notes)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Notes</h3>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $roomInventory->notes }}</p>
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
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Availability</label>
                                <div class="mt-1">{!! $roomInventory->availability_badge !!}</div>
                            </div>
                            @if($roomInventory->stop_sell)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Stop Sell</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                        Active
                                    </span>
                                </div>
                            @endif
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Booking Status</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $roomInventory->isBookingAllowed() ? 'Booking Allowed' : 'Booking Not Allowed' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Statistics</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Revenue Potential</label>
                                <p class="mt-1 text-xl font-bold text-green-600 dark:text-green-400">
                                    ৳{{ number_format($roomInventory->final_price * $roomInventory->available_rooms, 2) }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Current Revenue</label>
                                <p class="mt-1 text-lg font-semibold text-blue-600 dark:text-blue-400">
                                    ৳{{ number_format($roomInventory->final_price * $roomInventory->booked_rooms, 2) }}
                                </p>
                            </div>
                            @if($roomInventory->discount_percentage > 0)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Discount</label>
                                    <p class="mt-1 text-lg font-semibold text-red-600 dark:text-red-400">
                                        ৳{{ number_format(($roomInventory->price - $roomInventory->final_price) * $roomInventory->total_rooms, 2) }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- System Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">System Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $roomInventory->created_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $roomInventory->updated_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Inventory ID</label>
                                <p class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100">#{{ $roomInventory->id }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('hotel::admin.room-inventories.edit', $roomInventory) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Inventory
                            </a>
                            <a href="{{ route('hotel::admin.room-inventories.create', ['hotel_room_id' => $roomInventory->hotel_room_id, 'date' => $roomInventory->date->addDay()->toDateString()]) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md hover:bg-gray-50 dark:hover:bg-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Next Day
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>