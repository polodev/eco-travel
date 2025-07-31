<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Create Room Inventory</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Add new room inventory record</p>
                </div>
                <a href="{{ route('admin-dashboard.hotel.room-inventories.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('admin-dashboard.hotel.room-inventories.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Basic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Hotel Room -->
                        <div class="md:col-span-2">
                            <label for="hotel_room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Hotel Room *
                            </label>
                            <select id="hotel_room_id"
                                    name="hotel_room_id"
                                    class="select2-single w-full"
                                    required>
                                <option value="">Select a hotel room</option>
                                @foreach($hotelRooms as $room)
                                    <option value="{{ $room->id }}" {{ old('hotel_room_id', request('hotel_room_id')) == $room->id ? 'selected' : '' }}>
                                        {{ $room->hotel->name }} - {{ $room->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hotel_room_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Date *
                            </label>
                            <input type="date" 
                                   id="date"
                                   name="date"
                                   value="{{ old('date', request('date', now()->toDateString())) }}"
                                   min="{{ now()->toDateString() }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rate Plan -->
                        <div>
                            <label for="rate_plan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Rate Plan *
                            </label>
                            <select id="rate_plan"
                                    name="rate_plan"
                                    class="select2-single w-full"
                                    required>
                                <option value="">Select rate plan</option>
                                @foreach(\Modules\Hotel\Models\RoomInventory::getAvailableRatePlans() as $key => $label)
                                    <option value="{{ $key }}" {{ old('rate_plan') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rate_plan')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Room Availability -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Room Availability</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Total Rooms -->
                        <div>
                            <label for="total_rooms" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Total Rooms *
                            </label>
                            <input type="number" 
                                   id="total_rooms"
                                   name="total_rooms"
                                   value="{{ old('total_rooms', 1) }}"
                                   min="1"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('total_rooms')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Available Rooms -->
                        <div>
                            <label for="available_rooms" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Available Rooms *
                            </label>
                            <input type="number" 
                                   id="available_rooms"
                                   name="available_rooms"
                                   value="{{ old('available_rooms', 1) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('available_rooms')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Booked Rooms -->
                        <div>
                            <label for="booked_rooms" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Booked Rooms
                            </label>
                            <input type="number" 
                                   id="booked_rooms"
                                   name="booked_rooms"
                                   value="{{ old('booked_rooms', 0) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('booked_rooms')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Blocked Rooms -->
                        <div>
                            <label for="blocked_rooms" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Blocked Rooms
                            </label>
                            <input type="number" 
                                   id="blocked_rooms"
                                   name="blocked_rooms"
                                   value="{{ old('blocked_rooms', 0) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('blocked_rooms')
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
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Base Price (৳) *
                            </label>
                            <input type="number" 
                                   id="price"
                                   name="price"
                                   value="{{ old('price') }}"
                                   min="0"
                                   step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0.00"
                                   required>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Discount Percentage -->
                        <div>
                            <label for="discount_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Discount (%)
                            </label>
                            <input type="number" 
                                   id="discount_percentage"
                                   name="discount_percentage"
                                   value="{{ old('discount_percentage', 0) }}"
                                   min="0"
                                   max="100"
                                   step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0.00">
                            @error('discount_percentage')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Final Price -->
                        <div>
                            <label for="final_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Final Price (৳) *
                            </label>
                            <input type="number" 
                                   id="final_price"
                                   name="final_price"
                                   value="{{ old('final_price') }}"
                                   min="0"
                                   step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="0.00"
                                   required>
                            @error('final_price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Stay Requirements -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Stay Requirements</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Minimum Stay -->
                        <div>
                            <label for="minimum_stay" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Minimum Stay (nights)
                            </label>
                            <input type="number" 
                                   id="minimum_stay"
                                   name="minimum_stay"
                                   value="{{ old('minimum_stay', 1) }}"
                                   min="1"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('minimum_stay')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Maximum Stay -->
                        <div>
                            <label for="maximum_stay" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Maximum Stay (nights)
                            </label>
                            <input type="number" 
                                   id="maximum_stay"
                                   name="maximum_stay"
                                   value="{{ old('maximum_stay') }}"
                                   min="1"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('maximum_stay')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Inclusions -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Inclusions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach(\Modules\Hotel\Models\RoomInventory::getAvailableInclusions() as $key => $label)
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="inclusion_{{ $key }}"
                                       name="inclusions[]"
                                       value="{{ $key }}"
                                       {{ in_array($key, old('inclusions', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="inclusion_{{ $key }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('inclusions')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Settings -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Status Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Is Available -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_available"
                                   name="is_available"
                                   value="1"
                                   {{ old('is_available', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_available" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Available for booking
                            </label>
                        </div>

                        <!-- Stop Sell -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="stop_sell"
                                   name="stop_sell"
                                   value="1"
                                   {{ old('stop_sell') ? 'checked' : '' }}
                                   class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            <label for="stop_sell" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Stop Sell (prevent booking)
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Additional Information</h3>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Notes
                        </label>
                        <textarea id="notes"
                                  name="notes"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Optional notes about this inventory record">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin-dashboard.hotel.room-inventories.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Inventory
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

            // Calculate final price automatically
            function calculateFinalPrice() {
                const basePrice = parseFloat($('#price').val()) || 0;
                const discountPercentage = parseFloat($('#discount_percentage').val()) || 0;
                const finalPrice = basePrice - (basePrice * discountPercentage / 100);
                $('#final_price').val(finalPrice.toFixed(2));
            }

            $('#price, #discount_percentage').on('input', calculateFinalPrice);

            // Calculate available rooms automatically
            function calculateAvailableRooms() {
                const totalRooms = parseInt($('#total_rooms').val()) || 0;
                const bookedRooms = parseInt($('#booked_rooms').val()) || 0;
                const blockedRooms = parseInt($('#blocked_rooms').val()) || 0;
                const availableRooms = Math.max(0, totalRooms - bookedRooms - blockedRooms);
                $('#available_rooms').val(availableRooms);
            }

            $('#total_rooms, #booked_rooms, #blocked_rooms').on('input', calculateAvailableRooms);

            // Validate maximum stay is greater than minimum stay
            $('#maximum_stay').on('input', function() {
                const minStay = parseInt($('#minimum_stay').val()) || 1;
                const maxStay = parseInt($(this).val()) || 0;
                
                if (maxStay > 0 && maxStay < minStay) {
                    $(this).val(minStay);
                }
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>