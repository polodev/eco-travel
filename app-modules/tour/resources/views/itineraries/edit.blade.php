<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Tour Itinerary</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update day-by-day itinerary details</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin-dashboard.tour.itineraries.show', $itinerary) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-md hover:bg-blue-100 dark:hover:bg-blue-800">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View
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
            <form action="{{ route('admin-dashboard.tour.itineraries.update', $itinerary) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tour Selection -->
                        <div>
                            <label for="tour_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tour *
                            </label>
                            <select id="tour_id"
                                    name="tour_id"
                                    class="select2-single w-full"
                                    required>
                                <option value="">Select a tour</option>
                                @foreach($tours as $tour)
                                    <option value="{{ $tour->id }}" {{ old('tour_id', $itinerary->tour_id) == $tour->id ? 'selected' : '' }}>
                                        {{ $tour->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tour_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Day Number -->
                        <div>
                            <label for="day_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Day Number *
                            </label>
                            <input type="number" 
                                   id="day_number"
                                   name="day_number"
                                   value="{{ old('day_number', $itinerary->day_number) }}"
                                   min="1"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('day_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Day Title -->
                        <div>
                            <label for="day_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Day Title *
                            </label>
                            <input type="text" 
                                   id="day_title"
                                   name="day_title"
                                   value="{{ old('day_title', $itinerary->day_title) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., Arrival & City Tour"
                                   required>
                            @error('day_title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Location
                            </label>
                            <input type="text" 
                                   id="location"
                                   name="location"
                                   value="{{ old('location', $itinerary->location) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., Dhaka City">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="day_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Day Description *
                            </label>
                            <textarea id="day_description"
                                      name="day_description"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Brief description of the day's activities"
                                      required>{{ old('day_description', $itinerary->day_description) }}</textarea>
                            @error('day_description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Time & Duration Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Time & Duration</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Start Time -->
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Start Time
                            </label>
                            <input type="time" 
                                   id="start_time"
                                   name="start_time"
                                   value="{{ old('start_time', $itinerary->start_time ? $itinerary->start_time->format('H:i') : '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('start_time')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Time -->
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                End Time
                            </label>
                            <input type="time" 
                                   id="end_time"
                                   name="end_time"
                                   value="{{ old('end_time', $itinerary->end_time ? $itinerary->end_time->format('H:i') : '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('end_time')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estimated Duration -->
                        <div>
                            <label for="estimated_duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Duration (minutes)
                            </label>
                            <input type="number" 
                                   id="estimated_duration"
                                   name="estimated_duration"
                                   value="{{ old('estimated_duration', $itinerary->estimated_duration) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., 480">
                            @error('estimated_duration')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estimated Distance -->
                        <div>
                            <label for="estimated_distance" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Distance (km)
                            </label>
                            <input type="number" 
                                   id="estimated_distance"
                                   name="estimated_distance"
                                   value="{{ old('estimated_distance', $itinerary->estimated_distance) }}"
                                   min="0"
                                   step="0.1"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., 25.5">
                            @error('estimated_distance')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Activities -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Activities</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Activities -->
                        <div>
                            <label for="activities" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Activities *
                            </label>
                            <textarea id="activities"
                                      name="activities"
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="List activities (one per line)"
                                      required>{{ old('activities') ? implode("\n", old('activities', [])) : (is_array($itinerary->activities) ? implode("\n", $itinerary->activities) : '') }}</textarea>
                            @error('activities')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Optional Activities -->
                        <div>
                            <label for="optional_activities" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Optional Activities
                            </label>
                            <textarea id="optional_activities"
                                      name="optional_activities"
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="List optional activities (one per line)">{{ old('optional_activities') ? implode("\n", old('optional_activities', [])) : (is_array($itinerary->optional_activities) ? implode("\n", $itinerary->optional_activities) : '') }}</textarea>
                            @error('optional_activities')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Transportation -->
                        <div>
                            <label for="transportation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Transportation
                            </label>
                            <textarea id="transportation"
                                      name="transportation"
                                      rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Transportation methods (one per line)">{{ old('transportation') ? implode("\n", old('transportation', [])) : (is_array($itinerary->transportation) ? implode("\n", $itinerary->transportation) : '') }}</textarea>
                            @error('transportation')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Meals Included -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Meals Included
                            </label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="breakfast" name="meals_included[]" value="breakfast" 
                                           {{ in_array('breakfast', old('meals_included', $itinerary->meals_included ?? [])) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="breakfast" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Breakfast</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="lunch" name="meals_included[]" value="lunch"
                                           {{ in_array('lunch', old('meals_included', $itinerary->meals_included ?? [])) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="lunch" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Lunch</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="dinner" name="meals_included[]" value="dinner"
                                           {{ in_array('dinner', old('meals_included', $itinerary->meals_included ?? [])) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="dinner" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Dinner</label>
                                </div>
                            </div>
                        </div>

                        <!-- Meal Options -->
                        <div class="md:col-span-2">
                            <label for="meal_options" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Meal Options
                            </label>
                            <textarea id="meal_options"
                                      name="meal_options"
                                      rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Available meal options (one per line)">{{ old('meal_options') ? implode("\n", old('meal_options', [])) : (is_array($itinerary->meal_options) ? implode("\n", $itinerary->meal_options) : '') }}</textarea>
                            @error('meal_options')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Accommodation Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Accommodation</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Accommodation -->
                        <div>
                            <label for="accommodation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Hotel/Accommodation
                            </label>
                            <input type="text" 
                                   id="accommodation"
                                   name="accommodation"
                                   value="{{ old('accommodation', $itinerary->accommodation) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., Hotel Supreme">
                            @error('accommodation')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Accommodation Type -->
                        <div>
                            <label for="accommodation_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Accommodation Type
                            </label>
                            <select id="accommodation_type"
                                    name="accommodation_type"
                                    class="select2-single w-full">
                                <option value="">Select type</option>
                                @foreach($accommodationTypes as $key => $label)
                                    <option value="{{ $key }}" {{ old('accommodation_type', $itinerary->accommodation_type) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('accommodation_type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Accommodation Rating -->
                        <div>
                            <label for="accommodation_rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Star Rating
                            </label>
                            <select id="accommodation_rating"
                                    name="accommodation_rating"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select rating</option>
                                <option value="1" {{ old('accommodation_rating', $itinerary->accommodation_rating) == '1' ? 'selected' : '' }}>1 Star</option>
                                <option value="2" {{ old('accommodation_rating', $itinerary->accommodation_rating) == '2' ? 'selected' : '' }}>2 Stars</option>
                                <option value="3" {{ old('accommodation_rating', $itinerary->accommodation_rating) == '3' ? 'selected' : '' }}>3 Stars</option>
                                <option value="4" {{ old('accommodation_rating', $itinerary->accommodation_rating) == '4' ? 'selected' : '' }}>4 Stars</option>
                                <option value="5" {{ old('accommodation_rating', $itinerary->accommodation_rating) == '5' ? 'selected' : '' }}>5 Stars</option>
                            </select>
                            @error('accommodation_rating')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Settings -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Additional Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Is Rest Day -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_rest_day"
                                   name="is_rest_day"
                                   value="1"
                                   {{ old('is_rest_day', $itinerary->is_rest_day) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_rest_day" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Rest Day (no major activities)
                            </label>
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sort Order
                            </label>
                            <input type="number" 
                                   id="sort_order"
                                   name="sort_order"
                                   value="{{ old('sort_order', $itinerary->sort_order) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Leave empty to use day number">
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Special Notes -->
                        <div class="md:col-span-2">
                            <label for="special_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Special Notes
                            </label>
                            <textarea id="special_notes"
                                      name="special_notes"
                                      rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Any special notes or instructions for this day">{{ old('special_notes', $itinerary->special_notes) }}</textarea>
                            @error('special_notes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin-dashboard.tour.itineraries.show', $itinerary) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Itinerary
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2-single').select2({
                theme: 'default',
                width: '100%',
                placeholder: function() {
                    return $(this).find('option:first').text();
                }
            });

            // Convert textarea content to arrays on form submit
            $('form').on('submit', function() {
                // Process activities
                var activities = $('#activities').val().split('\n').filter(function(item) {
                    return item.trim() !== '';
                });
                $('#activities').replaceWith('<input type="hidden" name="activities" value="' + JSON.stringify(activities) + '">');

                // Process optional activities
                var optionalActivities = $('#optional_activities').val().split('\n').filter(function(item) {
                    return item.trim() !== '';
                });
                if (optionalActivities.length > 0) {
                    $('#optional_activities').replaceWith('<input type="hidden" name="optional_activities" value="' + JSON.stringify(optionalActivities) + '">');
                }

                // Process transportation
                var transportation = $('#transportation').val().split('\n').filter(function(item) {
                    return item.trim() !== '';
                });
                if (transportation.length > 0) {
                    $('#transportation').replaceWith('<input type="hidden" name="transportation" value="' + JSON.stringify(transportation) + '">');
                }

                // Process meal options
                var mealOptions = $('#meal_options').val().split('\n').filter(function(item) {
                    return item.trim() !== '';
                });
                if (mealOptions.length > 0) {
                    $('#meal_options').replaceWith('<input type="hidden" name="meal_options" value="' + JSON.stringify(mealOptions) + '">');
                }
            });

            // Auto-calculate duration from time range
            $('#start_time, #end_time').on('change', function() {
                var startTime = $('#start_time').val();
                var endTime = $('#end_time').val();
                
                if (startTime && endTime) {
                    var start = new Date('1970-01-01T' + startTime + ':00');
                    var end = new Date('1970-01-01T' + endTime + ':00');
                    
                    if (end > start) {
                        var diffMs = end - start;
                        var diffMins = Math.round(diffMs / 60000);
                        $('#estimated_duration').val(diffMins);
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>