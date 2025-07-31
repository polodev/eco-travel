<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div>
                        <div class="flex items-center space-x-2 mb-2">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $tour->name }}</h2>
                            {!! $tour->tour_type_badge !!}
                            {!! $tour->difficulty_badge !!}
                            @if($tour->is_featured)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">Featured</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $tour->city->name }}, {{ $tour->country->name }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin-dashboard.tour.tours.edit', $tour) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('admin-dashboard.tour.tours.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
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
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tour Name</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $tour->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tour Type</label>
                                <div class="mt-1">{!! $tour->tour_type_badge !!}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Country</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $tour->country->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">City</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $tour->city->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Duration</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $tour->formatted_duration }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Difficulty Level</label>
                                <div class="mt-1">{!! $tour->difficulty_badge !!}</div>
                            </div>
                            @if($tour->description)
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tour->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Group & Pricing Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Group & Pricing Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Group Size</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $tour->min_group_size }} - {{ $tour->max_group_size }} people</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Base Price</label>
                                <p class="mt-1 text-lg font-bold text-green-600 dark:text-green-400">৳{{ number_format($tour->base_price, 2) }}</p>
                            </div>
                            @if($tour->child_price)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Child Price</label>
                                    <p class="mt-1 text-sm font-medium text-green-600 dark:text-green-400">৳{{ number_format($tour->child_price, 2) }}</p>
                                </div>
                            @endif
                            @if($tour->single_supplement)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Single Supplement</label>
                                    <p class="mt-1 text-sm font-medium text-blue-600 dark:text-blue-400">৳{{ number_format($tour->single_supplement, 2) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Included Services -->
                        @if($tour->included_services && count($tour->included_services) > 0)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Included Services</h3>
                                <ul class="space-y-2">
                                    @foreach($tour->included_services as $service)
                                        <li class="flex items-start">
                                            <svg class="w-4 h-4 mt-0.5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm text-gray-900 dark:text-gray-100">{{ $service }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Excluded Services -->
                        @if($tour->excluded_services && count($tour->excluded_services) > 0)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Excluded Services</h3>
                                <ul class="space-y-2">
                                    @foreach($tour->excluded_services as $service)
                                        <li class="flex items-start">
                                            <svg class="w-4 h-4 mt-0.5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm text-gray-900 dark:text-gray-100">{{ $service }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- Tour Itineraries -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Tour Itineraries ({{ $tour->itineraries->count() }})</h3>
                            <a href="{{ route('admin-dashboard.tour.itineraries.create', ['tour_id' => $tour->id]) }}" 
                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Itinerary
                            </a>
                        </div>
                        
                        @if($tour->itineraries->count() > 0)
                            <div class="space-y-3">
                                @foreach($tour->itineraries->sortBy('sort_order')->sortBy('day_number') as $itinerary)
                                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3 mb-2">
                                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Day {{ $itinerary->day_number }}: {{ $itinerary->day_title }}</h4>
                                                    {!! $itinerary->day_type_badge !!}
                                                    @if($itinerary->is_rest_day)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100">
                                                            Rest Day
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600 dark:text-gray-400">
                                                    @if($itinerary->location)
                                                        <div>
                                                            <span class="font-medium">Location:</span> {{ $itinerary->location }}
                                                        </div>
                                                    @endif
                                                    @if($itinerary->start_time && $itinerary->end_time)
                                                        <div>
                                                            <span class="font-medium">Time:</span> {{ $itinerary->start_time->format('H:i') }} - {{ $itinerary->end_time->format('H:i') }}
                                                        </div>
                                                    @endif
                                                    @if($itinerary->estimated_duration)
                                                        <div>
                                                            <span class="font-medium">Duration:</span> {{ $itinerary->formatted_duration }}
                                                        </div>
                                                    @endif
                                                    @if($itinerary->accommodation)
                                                        <div>
                                                            <span class="font-medium">Stay:</span> {{ $itinerary->accommodation }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                                    {{ Str::limit($itinerary->day_description, 100) }}
                                                </div>
                                                @if($itinerary->activities && count($itinerary->activities) > 0)
                                                    <div class="mt-2 flex flex-wrap gap-1">
                                                        @foreach(array_slice($itinerary->activities, 0, 3) as $activity)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                                                {{ $activity }}
                                                            </span>
                                                        @endforeach
                                                        @if(count($itinerary->activities) > 3)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100">
                                                                +{{ count($itinerary->activities) - 3 }} more
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex items-center space-x-2 ml-4">
                                                <a href="{{ route('admin-dashboard.tour.itineraries.show', $itinerary) }}" 
                                                   class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded hover:bg-blue-100 dark:hover:bg-blue-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    View
                                                </a>
                                                <a href="{{ route('admin-dashboard.tour.itineraries.edit', $itinerary) }}" 
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
                            
                            <!-- View All Itineraries Link -->
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                <a href="{{ route('admin-dashboard.tour.itineraries.index', ['tour_id' => $tour->id]) }}" 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-md hover:bg-blue-100 dark:hover:bg-blue-800">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Manage All Itineraries for {{ $tour->name }}
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 text-4xl mb-3">
                                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2H9m0 0V3a2 2 0 10-4 0v2m4 0a2 2 0 014 0v2M7 13h10m-5-5v8"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-medium text-gray-600 dark:text-gray-400 mb-2">No Itineraries Found</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-500 mb-4">This tour doesn't have any day-by-day itineraries configured yet.</p>
                                <a href="{{ route('admin-dashboard.tour.itineraries.create', ['tour_id' => $tour->id]) }}" 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add First Itinerary
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
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Active Status</label>
                                <div class="mt-1">
                                    @if($tour->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Availability</label>
                                <div class="mt-1">{!! $tour->availability_badge !!}</div>
                            </div>
                            @if($tour->is_featured)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Featured</label>
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">Featured Tour</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Statistics</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Itineraries</label>
                                <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $tour->itineraries_count ?? $tour->itineraries->count() }}</p>
                            </div>
                            @if($tour->rating > 0)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer Rating</label>
                                    <div class="mt-1 flex items-center">
                                        <span class="text-yellow-400 text-lg">{{ $tour->rating_stars }}</span>
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">({{ $tour->total_reviews }} reviews)</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- System Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">System Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Slug</label>
                                <p class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100">{{ $tour->slug }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tour->created_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tour->updated_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tour ID</label>
                                <p class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100">#{{ $tour->id }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin-dashboard.tour.tours.edit', $tour) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Tour
                            </a>
                            <a href="{{ route('admin-dashboard.tour.tours.create', ['country_id' => $tour->country_id, 'city_id' => $tour->city_id]) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md hover:bg-gray-50 dark:hover:bg-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Similar Tour
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>