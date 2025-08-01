<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Tour</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update tour information</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('tour::admin.tours.show', $tour) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-md hover:bg-blue-100 dark:hover:bg-blue-800">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View
                    </a>
                    <a href="{{ route('tour::admin.tours.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('tour::admin.tours.update', $tour) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tour Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tour Name *
                            </label>
                            <input type="text" 
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $tour->name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter tour name"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tour Type -->
                        <div>
                            <label for="tour_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tour Type *
                            </label>
                            <select id="tour_type"
                                    name="tour_type"
                                    class="select2-single w-full"
                                    required>
                                <option value="">Select tour type</option>
                                @foreach($tourTypes as $key => $label)
                                    <option value="{{ $key }}" {{ old('tour_type', $tour->tour_type) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tour_type')
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
                                    class="select2-single w-full"
                                    required>
                                <option value="">Select a country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('country_id', $tour->country_id) == $country->id ? 'selected' : '' }}>
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
                                    class="select2-single w-full"
                                    required>
                                <option value="">Select a city</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id', $tour->city_id) == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Difficulty Level -->
                        <div>
                            <label for="difficulty_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Difficulty Level *
                            </label>
                            <select id="difficulty_level"
                                    name="difficulty_level"
                                    class="select2-single w-full"
                                    required>
                                <option value="">Select difficulty level</option>
                                @foreach($difficultyLevels as $key => $label)
                                    <option value="{{ $key }}" {{ old('difficulty_level', $tour->difficulty_level) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('difficulty_level')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Availability Status -->
                        <div>
                            <label for="availability_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Availability Status *
                            </label>
                            <select id="availability_status"
                                    name="availability_status"
                                    class="select2-single w-full"
                                    required>
                                <option value="">Select availability status</option>
                                @foreach($availabilityStatuses as $key => $label)
                                    <option value="{{ $key }}" {{ old('availability_status', $tour->availability_status) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('availability_status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description *
                            </label>
                            <textarea id="description"
                                      name="description"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Brief description of the tour"
                                      required>{{ old('description', $tour->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Duration & Group Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Duration & Group Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Duration Days -->
                        <div>
                            <label for="duration_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Duration (Days) *
                            </label>
                            <input type="number" 
                                   id="duration_days"
                                   name="duration_days"
                                   value="{{ old('duration_days', $tour->duration_days) }}"
                                   min="1"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('duration_days')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duration Nights -->
                        <div>
                            <label for="duration_nights" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Duration (Nights) *
                            </label>
                            <input type="number" 
                                   id="duration_nights"
                                   name="duration_nights"
                                   value="{{ old('duration_nights', $tour->duration_nights) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('duration_nights')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Min Group Size -->
                        <div>
                            <label for="min_group_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Min Group Size *
                            </label>
                            <input type="number" 
                                   id="min_group_size"
                                   name="min_group_size"
                                   value="{{ old('min_group_size', $tour->min_group_size) }}"
                                   min="1"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('min_group_size')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Max Group Size -->
                        <div>
                            <label for="max_group_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Max Group Size *
                            </label>
                            <input type="number" 
                                   id="max_group_size"
                                   name="max_group_size"
                                   value="{{ old('max_group_size', $tour->max_group_size) }}"
                                   min="1"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('max_group_size')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Pricing Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Base Price -->
                        <div>
                            <label for="base_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Base Price (৳) *
                            </label>
                            <input type="number" 
                                   id="base_price"
                                   name="base_price"
                                   value="{{ old('base_price', $tour->base_price) }}"
                                   min="0"
                                   step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0.00"
                                   required>
                            @error('base_price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Child Price -->
                        <div>
                            <label for="child_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Child Price (৳)
                            </label>
                            <input type="number" 
                                   id="child_price"
                                   name="child_price"
                                   value="{{ old('child_price', $tour->child_price) }}"
                                   min="0"
                                   step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0.00">
                            @error('child_price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Single Supplement -->
                        <div>
                            <label for="single_supplement" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Single Supplement (৳)
                            </label>
                            <input type="number" 
                                   id="single_supplement"
                                   name="single_supplement"
                                   value="{{ old('single_supplement', $tour->single_supplement) }}"
                                   min="0"
                                   step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0.00">
                            @error('single_supplement')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Services</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Included Services -->
                        <div>
                            <label for="included_services" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Included Services *
                            </label>
                            <textarea id="included_services"
                                      name="included_services[]"
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="List included services (one per line)"
                                      required>{{ old('included_services') ? implode("\n", old('included_services', [])) : (is_array($tour->included_services) ? implode("\n", $tour->included_services) : '') }}</textarea>
                            @error('included_services')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Excluded Services -->
                        <div>
                            <label for="excluded_services" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Excluded Services
                            </label>
                            <textarea id="excluded_services"
                                      name="excluded_services[]"
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="List excluded services (one per line)">{{ old('excluded_services') ? implode("\n", old('excluded_services', [])) : (is_array($tour->excluded_services) ? implode("\n", $tour->excluded_services) : '') }}</textarea>
                            @error('excluded_services')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status Settings -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Status Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Is Active -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $tour->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_active" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Active (visible to customers)
                            </label>
                        </div>

                        <!-- Is Featured -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_featured"
                                   name="is_featured"
                                   value="1"
                                   {{ old('is_featured', $tour->is_featured) ? 'checked' : '' }}
                                   class="h-4 w-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                            <label for="is_featured" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Featured tour
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('tour::admin.tours.show', $tour) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Tour
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

            // Convert textarea services to arrays on form submit
            $('form').on('submit', function() {
                // Process included services
                var includedServices = $('#included_services').val().split('\n').filter(function(item) {
                    return item.trim() !== '';
                });
                $('#included_services').replaceWith('<input type="hidden" name="included_services" value="' + JSON.stringify(includedServices) + '">');

                // Process excluded services
                var excludedServices = $('#excluded_services').val().split('\n').filter(function(item) {
                    return item.trim() !== '';
                });
                $('#excluded_services').replaceWith('<input type="hidden" name="excluded_services" value="' + JSON.stringify(excludedServices) + '">');
            });

            // Auto-calculate nights based on days
            $('#duration_days').on('input', function() {
                var days = parseInt($(this).val()) || 0;
                if (days > 0) {
                    $('#duration_nights').val(Math.max(0, days - 1));
                }
            });

            // Validate max group size is greater than min group size
            $('#max_group_size').on('input', function() {
                var minSize = parseInt($('#min_group_size').val()) || 1;
                var maxSize = parseInt($(this).val()) || 0;
                
                if (maxSize > 0 && maxSize < minSize) {
                    $(this).val(minSize);
                }
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>