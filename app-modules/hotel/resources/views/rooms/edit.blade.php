<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Hotel Room</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update room information - {{ $room->name }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin-dashboard.hotel.rooms.show', $room) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View
                    </a>
                    <a href="{{ route('admin-dashboard.hotel.rooms.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('admin-dashboard.hotel.rooms.update', $room) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Hotel -->
                        <div>
                            <label for="hotel_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Hotel *
                            </label>
                            <select id="hotel_id"
                                    name="hotel_id"
                                    class="select2-single w-full"
                                    required>
                                <option value="">Select a hotel</option>
                                @foreach($hotels as $hotel)
                                    <option value="{{ $hotel->id }}" {{ old('hotel_id', $room->hotel_id) == $hotel->id ? 'selected' : '' }}>
                                        {{ $hotel->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hotel_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Room Type -->
                        <div>
                            <label for="room_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Room Type *
                            </label>
                            <select id="room_type"
                                    name="room_type"
                                    class="select2-single w-full"
                                    required>
                                <option value="">Select room type</option>
                                @foreach(\Modules\Hotel\Models\HotelRoom::getAvailableRoomTypes() as $key => $label)
                                    <option value="{{ $key }}" {{ old('room_type', $room->room_type) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('room_type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Room Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Room Name *
                            </label>
                            <input type="text" 
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $room->name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter room name (e.g., Deluxe Ocean View Suite)"
                                   required>
                            @error('name')
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
                                      placeholder="Enter room description">{{ old('description', $room->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Occupancy & Bed Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Occupancy & Bed Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Max Occupancy -->
                        <div>
                            <label for="max_occupancy" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Max Occupancy *
                            </label>
                            <input type="number" 
                                   id="max_occupancy"
                                   name="max_occupancy"
                                   value="{{ old('max_occupancy', $room->max_occupancy) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   min="1"
                                   max="20"
                                   required>
                            @error('max_occupancy')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Max Adults -->
                        <div>
                            <label for="max_adults" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Max Adults *
                            </label>
                            <input type="number" 
                                   id="max_adults"
                                   name="max_adults"
                                   value="{{ old('max_adults', $room->max_adults) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   min="1"
                                   max="15"
                                   required>
                            @error('max_adults')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Max Children -->
                        <div>
                            <label for="max_children" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Max Children *
                            </label>
                            <input type="number" 
                                   id="max_children"
                                   name="max_children"
                                   value="{{ old('max_children', $room->max_children) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   min="0"
                                   max="10"
                                   required>
                            @error('max_children')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Room Size -->
                        <div>
                            <label for="room_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Room Size (m²)
                            </label>
                            <input type="number" 
                                   id="room_size"
                                   name="room_size"
                                   value="{{ old('room_size', $room->room_size) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="35.5"
                                   step="0.1"
                                   min="0"
                                   max="500">
                            @error('room_size')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bed Type -->
                        <div>
                            <label for="bed_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Bed Type *
                            </label>
                            <select id="bed_type"
                                    name="bed_type"
                                    class="select2-single w-full"
                                    required>
                                <option value="">Select bed type</option>
                                @foreach(\Modules\Hotel\Models\HotelRoom::getAvailableBedTypes() as $key => $label)
                                    <option value="{{ $key }}" {{ old('bed_type', $room->bed_type) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bed_type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bed Count -->
                        <div>
                            <label for="bed_count" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Bed Count *
                            </label>
                            <input type="number" 
                                   id="bed_count"
                                   name="bed_count"
                                   value="{{ old('bed_count', $room->bed_count) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   min="1"
                                   max="5"
                                   required>
                            @error('bed_count')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing & Inventory -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Pricing & Inventory</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Base Price -->
                        <div>
                            <label for="base_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Base Price (৳) *
                            </label>
                            <input type="number" 
                                   id="base_price"
                                   name="base_price"
                                   value="{{ old('base_price', $room->base_price) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="5000"
                                   step="0.01"
                                   min="0"
                                   required>
                            @error('base_price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Rooms -->
                        <div>
                            <label for="total_rooms" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Total Rooms *
                            </label>
                            <input type="number" 
                                   id="total_rooms"
                                   name="total_rooms"
                                   value="{{ old('total_rooms', $room->total_rooms) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   min="1"
                                   max="100"
                                   required>
                            @error('total_rooms')
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
                                   value="{{ old('position', $room->position) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   min="0">
                            @error('position')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Lower numbers appear first in lists</p>
                        </div>
                    </div>
                </div>

                <!-- Room Amenities -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Room Amenities</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach (\Modules\Hotel\Models\HotelRoom::getAvailableAmenities() as $key => $label)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="amenities[]" 
                                       value="{{ $key }}" 
                                       {{ in_array($key, old('amenities', $room->amenities ?? [])) ? 'checked' : '' }}
                                       class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                    @error('amenities')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Settings -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Status Settings</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', $room->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                            <p class="ml-2 text-xs text-gray-500 dark:text-gray-400">Room will be available for booking</p>
                        </div>

                        <div class="flex items-center">
                            <input type="hidden" name="is_refundable" value="0">
                            <input type="checkbox" 
                                   name="is_refundable" 
                                   value="1" 
                                   {{ old('is_refundable', $room->is_refundable) ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-600 text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Refundable</span>
                            <p class="ml-2 text-xs text-gray-500 dark:text-gray-400">Booking can be cancelled with refund</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin-dashboard.hotel.rooms.show', $room) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Update Room
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