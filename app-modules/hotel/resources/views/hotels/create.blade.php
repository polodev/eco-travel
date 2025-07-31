<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Create Hotel</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Add a new hotel to the system</p>
                </div>
                <a href="{{ route('admin-dashboard.hotel.hotels.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('admin-dashboard.hotel.hotels.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Hotel Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Hotel Name *
                            </label>
                            <input type="text" 
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter hotel name"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Star Rating -->
                        <div>
                            <label for="star_rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Star Rating *
                            </label>
                            <select id="star_rating"
                                    name="star_rating"
                                    class="select2-single w-full"
                                    required>
                                <option value="">Select star rating</option>
                                @foreach ([1 => '1 Star', 2 => '2 Stars', 3 => '3 Stars', 4 => '4 Stars', 5 => '5 Stars'] as $rating => $label)
                                    <option value="{{ $rating }}" {{ old('star_rating') == $rating ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('star_rating')
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
                                    <option value="{{ $country->id }}" {{ old('country_id', request('country_id')) == $country->id ? 'selected' : '' }}>
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
                                    <option value="{{ $city->id }}" {{ old('city_id', request('city_id')) == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Address *
                            </label>
                            <input type="text" 
                                   id="address"
                                   name="address"
                                   value="{{ old('address') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter full address"
                                   required>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea id="description"
                                      name="description"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Enter hotel description">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Contact Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Phone
                            </label>
                            <input type="text" 
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="+1 234 567 8900">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email
                            </label>
                            <input type="email" 
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="hotel@example.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Website -->
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Website
                            </label>
                            <input type="url" 
                                   id="website"
                                   name="website"
                                   value="{{ old('website') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="https://www.hotel.com">
                            @error('website')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Location & Times -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Location & Times</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Latitude -->
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Latitude
                            </label>
                            <input type="number" 
                                   id="latitude"
                                   name="latitude"
                                   value="{{ old('latitude') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="23.8103"
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
                                   value="{{ old('longitude') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="90.4125"
                                   step="any"
                                   min="-180"
                                   max="180">
                            @error('longitude')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Check-in Time -->
                        <div>
                            <label for="checkin_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Check-in Time
                            </label>
                            <input type="time" 
                                   id="checkin_time"
                                   name="checkin_time"
                                   value="{{ old('checkin_time', '15:00') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('checkin_time')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Check-out Time -->
                        <div>
                            <label for="checkout_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Check-out Time
                            </label>
                            <input type="time" 
                                   id="checkout_time"
                                   name="checkout_time"
                                   value="{{ old('checkout_time', '11:00') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('checkout_time')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Distance Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Distance Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Distance from Airport -->
                        <div>
                            <label for="distance_from_airport" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Distance from Airport (km)
                            </label>
                            <input type="number" 
                                   id="distance_from_airport"
                                   name="distance_from_airport"
                                   value="{{ old('distance_from_airport') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="15.5"
                                   step="0.1"
                                   min="0">
                            @error('distance_from_airport')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Distance from City Center -->
                        <div>
                            <label for="distance_from_city_center" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Distance from City Center (km)
                            </label>
                            <input type="number" 
                                   id="distance_from_city_center"
                                   name="distance_from_city_center"
                                   value="{{ old('distance_from_city_center') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="5.2"
                                   step="0.1"
                                   min="0">
                            @error('distance_from_city_center')
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
                                   value="{{ old('position', 0) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0"
                                   min="0">
                            @error('position')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Lower numbers appear first in lists</p>
                        </div>
                    </div>
                </div>

                <!-- Amenities -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Amenities</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ([
                            'wifi' => 'Free WiFi',
                            'pool' => 'Swimming Pool',
                            'gym' => 'Fitness Center',
                            'spa' => 'Spa',
                            'restaurant' => 'Restaurant',
                            'bar' => 'Bar',
                            'parking' => 'Free Parking',
                            'airport_shuttle' => 'Airport Shuttle',
                            'room_service' => '24hr Room Service',
                            'concierge' => 'Concierge Service',
                            'laundry' => 'Laundry Service',
                            'business_center' => 'Business Center',
                            'conference_room' => 'Conference Room',
                            'pet_friendly' => 'Pet Friendly',
                            'air_conditioning' => 'Air Conditioning'
                        ] as $key => $label)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="amenities[]" 
                                       value="{{ $key }}" 
                                       {{ in_array($key, old('amenities', [])) ? 'checked' : '' }}
                                       class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                    @error('amenities')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Checkboxes -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Status Settings</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', 1) ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                            <p class="ml-2 text-xs text-gray-500 dark:text-gray-400">Hotel will be available for booking</p>
                        </div>

                        <div class="flex items-center">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   value="1" 
                                   {{ old('is_featured') ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-600 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Featured Hotel</span>
                            <p class="ml-2 text-xs text-gray-500 dark:text-gray-400">Display as featured hotel</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin-dashboard.hotel.hotels.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Hotel
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 for all select elements
            $('.select2-single').select2({
                theme: 'default',
                width: '100%',
                placeholder: function() {
                    return $(this).find('option:first').text();
                },
                allowClear: false
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>
