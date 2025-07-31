<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div>
                        <div class="flex items-center space-x-2 mb-2">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Day {{ $itinerary->day_number }}: {{ $itinerary->day_title }}</h2>
                            {!! $itinerary->day_type_badge !!}
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $itinerary->tour->name }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin-dashboard.tour.itineraries.edit', $itinerary) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('admin-dashboard.tour.itineraries.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
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
                <!-- Main Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Day Number</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">Day {{ $itinerary->day_number }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Day Type</label>
                                <div class="mt-1">{!! $itinerary->day_type_badge !!}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Location</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $itinerary->location ?? 'Not specified' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Duration</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $itinerary->formatted_duration }}</p>
                            </div>
                            @if($itinerary->estimated_distance)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Distance</label>
                                    <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $itinerary->formatted_distance }}</p>
                                </div>
                            @endif
                            @if($itinerary->start_time || $itinerary->end_time)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Time Schedule</label>
                                    <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        @if($itinerary->start_time)
                                            {{ $itinerary->start_time->format('g:i A') }}
                                        @endif
                                        @if($itinerary->start_time && $itinerary->end_time)
                                            -
                                        @endif
                                        @if($itinerary->end_time)
                                            {{ $itinerary->end_time->format('g:i A') }}
                                        @endif
                                    </p>
                                </div>
                            @endif
                            @if($itinerary->day_description)
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $itinerary->day_description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Activities -->
                    @if($itinerary->activities && count($itinerary->activities) > 0)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Activities</h3>
                            <ul class="space-y-2">
                                @foreach($itinerary->formatted_activities as $activity)
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 mt-0.5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ $activity }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Optional Activities -->
                    @if($itinerary->optional_activities && count($itinerary->optional_activities) > 0)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Optional Activities</h3>
                            <ul class="space-y-2">
                                @foreach($itinerary->formatted_optional_activities as $activity)
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 mt-0.5 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm text-gray-900 dark:text-gray-100">{{ $activity }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Transportation -->
                    @if($itinerary->transportation && count($itinerary->transportation) > 0)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Transportation</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($itinerary->transportation as $transport)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        {{ $transport }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Special Notes -->
                    @if($itinerary->special_notes)
                        <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-100 mb-2">Special Notes</h3>
                            <p class="text-sm text-yellow-700 dark:text-yellow-200">{{ $itinerary->special_notes }}</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar Information -->
                <div class="space-y-6">
                    <!-- Meals Information -->
                    @if($itinerary->meals_included && count($itinerary->meals_included) > 0)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Meals Included</h3>
                            <div class="space-y-2">
                                @foreach($itinerary->meals_included as $meal)
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm text-gray-900 dark:text-gray-100 capitalize">{{ $meal }}</span>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($itinerary->meal_options && count($itinerary->meal_options) > 0)
                                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                    <h4 class="text-sm font-medium text-gray-800 dark:text-gray-100 mb-2">Meal Options</h4>
                                    <div class="space-y-1">
                                        @foreach($itinerary->meal_options as $option)
                                            <div class="text-xs text-gray-600 dark:text-gray-400">• {{ $option }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Accommodation Information -->
                    @if($itinerary->accommodation)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Accommodation</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hotel/Stay</label>
                                    <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $itinerary->accommodation }}</p>
                                </div>
                                @if($itinerary->accommodation_type)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($itinerary->accommodation_type) }}</p>
                                    </div>
                                @endif
                                @if($itinerary->accommodation_rating)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Rating</label>
                                        <div class="mt-1 flex items-center">
                                            <span class="text-yellow-400 text-sm">{{ str_repeat('★', $itinerary->accommodation_rating) }}</span>
                                            <span class="text-gray-300 text-sm">{{ str_repeat('☆', 5 - $itinerary->accommodation_rating) }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Tour Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Tour Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tour Name</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $itinerary->tour->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Duration</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $itinerary->tour->formatted_duration }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sort Order</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $itinerary->sort_order ?? $itinerary->day_number }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin-dashboard.tour.itineraries.edit', $itinerary) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Itinerary
                            </a>
                            <a href="{{ route('admin-dashboard.tour.tours.show', $itinerary->tour) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md hover:bg-gray-50 dark:hover:bg-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Full Tour
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>