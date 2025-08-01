<x-admin-dashboard-layout::layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Hotel Booking</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $bookingHotel->booking->booking_reference }} - {{ $bookingHotel->hotel->name ?? 'Unknown Hotel' }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('booking::admin.booking-hotels.show', $bookingHotel) }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Hotel Details
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <form action="{{ route('booking::admin.booking-hotels.update', $bookingHotel) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Hotel Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Hotel Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="hotel_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hotel ID</label>
                                <input type="number" name="hotel_id" id="hotel_id" 
                                       value="{{ old('hotel_id', $bookingHotel->hotel_id) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('hotel_id') border-red-500 @enderror">
                                @error('hotel_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="hotel_room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hotel Room ID</label>
                                <input type="number" name="hotel_room_id" id="hotel_room_id" 
                                       value="{{ old('hotel_room_id', $bookingHotel->hotel_room_id) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('hotel_room_id') border-red-500 @enderror">
                                @error('hotel_room_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="checkin_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Check-in Date</label>
                                <input type="date" name="checkin_date" id="checkin_date" 
                                       value="{{ old('checkin_date', $bookingHotel->checkin_date) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('checkin_date') border-red-500 @enderror">
                                @error('checkin_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="checkout_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Check-out Date</label>
                                <input type="date" name="checkout_date" id="checkout_date" 
                                       value="{{ old('checkout_date', $bookingHotel->checkout_date) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('checkout_date') border-red-500 @enderror">
                                @error('checkout_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nights" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number of Nights</label>
                                <input type="number" name="nights" id="nights" min="1" max="365"
                                       value="{{ old('nights', $bookingHotel->nights) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('nights') border-red-500 @enderror" readonly>
                                @error('nights')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="rate_plan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rate Plan</label>
                                <select name="rate_plan" id="rate_plan" 
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('rate_plan') border-red-500 @enderror">
                                    <option value="room_only" {{ old('rate_plan', $bookingHotel->rate_plan) == 'room_only' ? 'selected' : '' }}>Room Only</option>
                                    <option value="breakfast_included" {{ old('rate_plan', $bookingHotel->rate_plan) == 'breakfast_included' ? 'selected' : '' }}>Breakfast Included</option>
                                    <option value="half_board" {{ old('rate_plan', $bookingHotel->rate_plan) == 'half_board' ? 'selected' : '' }}>Half Board</option>
                                    <option value="full_board" {{ old('rate_plan', $bookingHotel->rate_plan) == 'full_board' ? 'selected' : '' }}>Full Board</option>
                                    <option value="all_inclusive" {{ old('rate_plan', $bookingHotel->rate_plan) == 'all_inclusive' ? 'selected' : '' }}>All Inclusive</option>
                                </select>
                                @error('rate_plan')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="booking_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking Status</label>
                            <select name="booking_status" id="booking_status" 
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('booking_status') border-red-500 @enderror">
                                <option value="pending" {{ old('booking_status', $bookingHotel->booking_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('booking_status', $bookingHotel->booking_status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="checked_in" {{ old('booking_status', $bookingHotel->booking_status) == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                                <option value="checked_out" {{ old('booking_status', $bookingHotel->booking_status) == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                                <option value="no_show" {{ old('booking_status', $bookingHotel->booking_status) == 'no_show' ? 'selected' : '' }}>No Show</option>
                                <option value="cancelled" {{ old('booking_status', $bookingHotel->booking_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('booking_status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Guest & Pricing Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Guest & Pricing Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="adults" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adults</label>
                                <input type="number" name="adults" id="adults" min="1" max="20"
                                       value="{{ old('adults', $bookingHotel->adults) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('adults') border-red-500 @enderror">
                                @error('adults')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="children" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Children</label>
                                <input type="number" name="children" id="children" min="0" max="20"
                                       value="{{ old('children', $bookingHotel->children) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('children') border-red-500 @enderror">
                                @error('children')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="infants" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Infants</label>
                                <input type="number" name="infants" id="infants" min="0" max="20"
                                       value="{{ old('infants', $bookingHotel->infants) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('infants') border-red-500 @enderror">
                                @error('infants')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="room_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Room Rate per Night (৳)</label>
                                <input type="number" name="room_rate" id="room_rate" min="0" step="0.01"
                                       value="{{ old('room_rate', $bookingHotel->room_rate) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('room_rate') border-red-500 @enderror">
                                @error('room_rate')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="taxes_fees" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Taxes & Fees (৳)</label>
                                <input type="number" name="taxes_fees" id="taxes_fees" min="0" step="0.01"
                                       value="{{ old('taxes_fees', $bookingHotel->taxes_fees) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('taxes_fees') border-red-500 @enderror">
                                @error('taxes_fees')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="total_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Amount (৳)</label>
                            <input type="number" name="total_amount" id="total_amount" min="0" step="0.01"
                                   value="{{ old('total_amount', $bookingHotel->total_amount) }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('total_amount') border-red-500 @enderror" readonly>
                            @error('total_amount')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="confirmation_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmation Number</label>
                                <input type="text" name="confirmation_number" id="confirmation_number" 
                                       value="{{ old('confirmation_number', $bookingHotel->confirmation_number) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('confirmation_number') border-red-500 @enderror">
                                @error('confirmation_number')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="infants" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Infants</label>
                                <input type="number" name="infants" id="infants" min="0" max="20"
                                       value="{{ old('infants', $bookingHotel->infants) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('infants') border-red-500 @enderror">
                                @error('infants')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="special_requests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special Requests</label>
                            <textarea name="special_requests" id="special_requests" rows="3"
                                      placeholder="Enter any special requests or notes"
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('special_requests') border-red-500 @enderror">{{ old('special_requests', is_array($bookingHotel->special_requests) ? implode("\n", $bookingHotel->special_requests) : $bookingHotel->special_requests) }}</textarea>
                            @error('special_requests')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('booking::admin.booking-hotels.show', $bookingHotel) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Hotel Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Calculate nights and total amount
        function calculateNights() {
            const checkinDate = document.getElementById('checkin_date').value;
            const checkoutDate = document.getElementById('checkout_date').value;
            
            if (checkinDate && checkoutDate) {
                const checkin = new Date(checkinDate);
                const checkout = new Date(checkoutDate);
                const timeDiff = checkout.getTime() - checkin.getTime();
                const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
                
                if (nights > 0) {
                    document.getElementById('nights').value = nights;
                    calculateTotal();
                }
            }
        }

        function calculateTotal() {
            const nights = parseInt(document.getElementById('nights').value) || 0;
            const roomRate = parseFloat(document.getElementById('room_rate').value) || 0;
            const taxesFees = parseFloat(document.getElementById('taxes_fees').value) || 0;
            
            const total = (nights * roomRate) + taxesFees;
            
            document.getElementById('total_amount').value = total.toFixed(2);
        }

        // Add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Date change listeners
            document.getElementById('checkin_date').addEventListener('change', calculateNights);
            document.getElementById('checkout_date').addEventListener('change', calculateNights);
            
            // Price change listeners
            document.getElementById('room_rate').addEventListener('input', calculateTotal);
            document.getElementById('taxes_fees').addEventListener('input', calculateTotal);
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>