<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Airport</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update airport information</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('location::admin.airports.show', $airport->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View
                    </a>
                    <a href="{{ route('location::admin.airports.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('location::admin.airports.update', $airport->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Airport Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Airport Name *
                        </label>
                        <input type="text" 
                               id="name"
                               name="name"
                               value="{{ old('name', $airport->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter airport name"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- IATA Code -->
                    <div>
                        <label for="iata_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            IATA Code *
                        </label>
                        <input type="text" 
                               id="iata_code"
                               name="iata_code"
                               value="{{ old('iata_code', $airport->iata_code) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="e.g., DAC, JFK, LHR"
                               maxlength="3"
                               style="text-transform: uppercase;"
                               required>
                        @error('iata_code')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Country *
                        </label>
                        <select id="country_id"
                                name="country_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 select2"
                                required>
                            <option value="">Select a country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id', $airport->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            City *
                        </label>
                        <select id="city_id"
                                name="city_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 select2"
                                required>
                            <option value="">Select a city</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id', $airport->city_id) == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Latitude -->
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Latitude
                        </label>
                        <input type="number" 
                               id="latitude"
                               name="latitude"
                               value="{{ old('latitude', $airport->latitude) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="e.g., 23.8433"
                               step="any"
                               min="-90"
                               max="90">
                        @error('latitude')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Longitude -->
                    <div>
                        <label for="longitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Longitude
                        </label>
                        <input type="number" 
                               id="longitude"
                               name="longitude"
                               value="{{ old('longitude', $airport->longitude) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="e.g., 90.3978"
                               step="any"
                               min="-180"
                               max="180">
                        @error('longitude')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Position -->
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Display Position
                        </label>
                        <input type="number" 
                               id="position"
                               name="position"
                               value="{{ old('position', $airport->position) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="0"
                               min="0">
                        @error('position')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Lower numbers appear first in lists</p>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', $airport->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Active airports will be available for selection</p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('location::admin.airports.show', $airport->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Update Airport
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Select2 Custom Styling for Dark Theme -->
    <style>
        .select2-container--bootstrap4 .select2-selection--single {
            background-color: rgb(55, 65, 81) !important;
            border: 1px solid rgb(75, 85, 99) !important;
            color: rgb(243, 244, 246) !important;
            height: 42px !important;
            position: relative !important;
            overflow: hidden !important;
        }
        
        .dark .select2-container--bootstrap4 .select2-selection--single {
            background-color: rgb(55, 65, 81) !important;
            border: 1px solid rgb(75, 85, 99) !important;
            color: rgb(243, 244, 246) !important;
            height: 42px !important;
            position: relative !important;
            overflow: hidden !important;
        }
        
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            color: rgb(243, 244, 246) !important;
            line-height: 42px !important;
            padding-left: 12px !important;
            padding-right: 30px !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }
        
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__placeholder {
            color: rgb(156, 163, 175) !important;
            line-height: 42px !important;
            padding-left: 12px !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
        }
        
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
            height: 42px !important;
            right: 12px !important;
            top: 0 !important;
            position: absolute !important;
        }
        
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__clear {
            color: rgb(156, 163, 175) !important;
            font-size: 18px !important;
            height: 42px !important;
            line-height: 42px !important;
            right: 30px !important;
            top: 0 !important;
            position: absolute !important;
        }
        
        .select2-dropdown {
            background-color: rgb(55, 65, 81) !important;
            border: 1px solid rgb(75, 85, 99) !important;
            z-index: 9999 !important;
            position: absolute !important;
        }
        
        .select2-container--bootstrap4 .select2-results__option {
            color: rgb(243, 244, 246) !important;
            background-color: rgb(55, 65, 81) !important;
        }
        
        .select2-container--bootstrap4 .select2-results__option--highlighted {
            background-color: rgb(59, 130, 246) !important;
            color: white !important;
        }
        
        .select2-container--bootstrap4 .select2-results__option[aria-selected="true"] {
            background-color: rgb(37, 99, 235) !important;
            color: white !important;
        }
        
        .select2-search--dropdown .select2-search__field {
            background-color: rgb(55, 65, 81) !important;
            border: 1px solid rgb(75, 85, 99) !important;
            color: rgb(243, 244, 246) !important;
        }
        
        .select2-container--bootstrap4.select2-container--focus .select2-selection--single {
            border-color: rgb(59, 130, 246) !important;
            box-shadow: 0 0 0 2px rgb(59 130 246 / 0.5) !important;
        }
        
        .select2-selection__clear {
            color: rgb(156, 163, 175) !important;
        }
        
        .select2-selection__clear:hover {
            color: rgb(243, 244, 246) !important;
        }
        
        /* Fix dropdown positioning */
        .select2-container--open .select2-dropdown {
            top: 100% !important;
            left: 0 !important;
        }
    </style>

    <!-- Select2 Initialization -->
    <script>
        $(document).ready(function() {
            // Initialize Select2 for country and city dropdowns
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: function() {
                    return $(this).find('option:first').text() || 'Select an option';
                },
                allowClear: true,
                escapeMarkup: function(markup) {
                    return markup;
                },
                templateResult: function(data) {
                    return data.text;
                },
                templateSelection: function(data) {
                    return data.text;
                }
            });

            // Handle country change to filter cities
            $('#country_id').on('change', function() {
                var countryId = $(this).val();
                var citySelect = $('#city_id');
                
                if (countryId) {
                    // Clear current city selection
                    citySelect.val(null).trigger('change');
                    
                    // Filter cities based on selected country
                    citySelect.find('option').each(function() {
                        var option = $(this);
                        if (option.val() === '') {
                            option.show();
                            return;
                        }
                        
                        // You can implement AJAX call here to fetch cities by country
                        // For now, we'll show all cities
                        option.show();
                    });
                } else {
                    citySelect.val(null).trigger('change');
                }
            });
        });
    </script>
</x-admin-dashboard-layout::layout>

