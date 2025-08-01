<x-admin-dashboard-layout::layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Tour Booking</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $bookingTour->booking->booking_reference }} - {{ $bookingTour->tour->name ?? 'Unknown Tour' }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('booking::admin.booking-tours.show', $bookingTour) }}" 
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Tour Details
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <form action="{{ route('booking::admin.booking-tours.update', $bookingTour) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Tour Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Tour Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tour_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tour ID</label>
                                <input type="number" name="tour_id" id="tour_id" 
                                       value="{{ old('tour_id', $bookingTour->tour_id) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('tour_id') border-red-500 @enderror">
                                @error('tour_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tour_duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tour Duration (Days)</label>
                                <input type="number" name="tour_duration" id="tour_duration" min="1" max="365"
                                       value="{{ old('tour_duration', $bookingTour->tour_duration) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('tour_duration') border-red-500 @enderror" readonly>
                                @error('tour_duration')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tour_start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tour Start Date</label>
                                <input type="date" name="tour_start_date" id="tour_start_date" 
                                       value="{{ old('tour_start_date', $bookingTour->tour_start_date) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('tour_start_date') border-red-500 @enderror">
                                @error('tour_start_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tour_end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tour End Date</label>
                                <input type="date" name="tour_end_date" id="tour_end_date" 
                                       value="{{ old('tour_end_date', $bookingTour->tour_end_date) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('tour_end_date') border-red-500 @enderror" readonly>
                                @error('tour_end_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="accommodation_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Accommodation Type</label>
                                <select name="accommodation_type" id="accommodation_type" 
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('accommodation_type') border-red-500 @enderror">
                                    <option value="shared" {{ old('accommodation_type', $bookingTour->accommodation_type) == 'shared' ? 'selected' : '' }}>Shared</option>
                                    <option value="single" {{ old('accommodation_type', $bookingTour->accommodation_type) == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="twin" {{ old('accommodation_type', $bookingTour->accommodation_type) == 'twin' ? 'selected' : '' }}>Twin</option>
                                    <option value="double" {{ old('accommodation_type', $bookingTour->accommodation_type) == 'double' ? 'selected' : '' }}>Double</option>
                                </select>
                                @error('accommodation_type')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="booking_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking Status</label>
                                <select name="booking_status" id="booking_status" 
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('booking_status') border-red-500 @enderror">
                                    <option value="pending" {{ old('booking_status', $bookingTour->booking_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ old('booking_status', $bookingTour->booking_status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="in_progress" {{ old('booking_status', $bookingTour->booking_status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ old('booking_status', $bookingTour->booking_status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('booking_status', $bookingTour->booking_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('booking_status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tour_guide" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tour Guide</label>
                                <input type="text" name="tour_guide" id="tour_guide" 
                                       value="{{ old('tour_guide', $bookingTour->tour_guide) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('tour_guide') border-red-500 @enderror">
                                @error('tour_guide')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tour_voucher" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tour Voucher</label>
                                <input type="text" name="tour_voucher" id="tour_voucher" 
                                       value="{{ old('tour_voucher', $bookingTour->tour_voucher) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('tour_voucher') border-red-500 @enderror">
                                @error('tour_voucher')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Participant & Pricing Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Participant & Pricing Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="adults" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adults</label>
                                <input type="number" name="adults" id="adults" min="1" max="20"
                                       value="{{ old('adults', $bookingTour->adults) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('adults') border-red-500 @enderror">
                                @error('adults')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="children" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Children</label>
                                <input type="number" name="children" id="children" min="0" max="20"
                                       value="{{ old('children', $bookingTour->children) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('children') border-red-500 @enderror">
                                @error('children')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="infants" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Infants</label>
                                <input type="number" name="infants" id="infants" min="0" max="20"
                                       value="{{ old('infants', $bookingTour->infants) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('infants') border-red-500 @enderror">
                                @error('infants')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="adult_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adult Price (৳)</label>
                                <input type="number" name="adult_price" id="adult_price" min="0" step="0.01"
                                       value="{{ old('adult_price', $bookingTour->adult_price) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('adult_price') border-red-500 @enderror">
                                @error('adult_price')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="child_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Child Price (৳)</label>
                                <input type="number" name="child_price" id="child_price" min="0" step="0.01"
                                       value="{{ old('child_price', $bookingTour->child_price) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('child_price') border-red-500 @enderror">
                                @error('child_price')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="infant_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Infant Price (৳)</label>
                                <input type="number" name="infant_price" id="infant_price" min="0" step="0.01"
                                       value="{{ old('infant_price', $bookingTour->infant_price) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('infant_price') border-red-500 @enderror">
                                @error('infant_price')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="single_supplement" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Single Supplement (৳)</label>
                                <input type="number" name="single_supplement" id="single_supplement" min="0" step="0.01"
                                       value="{{ old('single_supplement', $bookingTour->single_supplement) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('single_supplement') border-red-500 @enderror">
                                @error('single_supplement')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="total_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Amount (৳)</label>
                                <input type="number" name="total_amount" id="total_amount" min="0" step="0.01"
                                       value="{{ old('total_amount', $bookingTour->total_amount) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('total_amount') border-red-500 @enderror" readonly>
                                @error('total_amount')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="pickup_details" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pickup Details</label>
                            <input type="text" name="pickup_details" id="pickup_details" 
                                   value="{{ old('pickup_details', is_array($bookingTour->pickup_details) ? implode(', ', $bookingTour->pickup_details) : $bookingTour->pickup_details) }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('pickup_details') border-red-500 @enderror">
                            @error('pickup_details')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="special_requests" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special Requests</label>
                            <textarea name="special_requests" id="special_requests" rows="3"
                                      placeholder="Enter any special requests or notes"
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 @error('special_requests') border-red-500 @enderror">{{ old('special_requests', is_array($bookingTour->special_requests) ? implode("\n", $bookingTour->special_requests) : $bookingTour->special_requests) }}</textarea>
                            @error('special_requests')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('booking::admin.booking-tours.show', $bookingTour) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Tour Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Calculate tour duration and end date, then total amount
        function calculateTourDuration() {
            const startDate = document.getElementById('tour_start_date').value;
            const endDate = document.getElementById('tour_end_date').value;
            
            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                const timeDiff = end.getTime() - start.getTime();
                const duration = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; // Include both start and end day
                
                if (duration > 0) {
                    document.getElementById('tour_duration').value = duration;
                }
            }
        }

        function calculateEndDate() {
            const startDate = document.getElementById('tour_start_date').value;
            const duration = parseInt(document.getElementById('tour_duration').value) || 0;
            
            if (startDate && duration > 0) {
                const start = new Date(startDate);
                const end = new Date(start);
                end.setDate(start.getDate() + duration - 1); // Subtract 1 because we include the start day
                
                const endDateString = end.getFullYear() + '-' + 
                    String(end.getMonth() + 1).padStart(2, '0') + '-' + 
                    String(end.getDate()).padStart(2, '0');
                
                document.getElementById('tour_end_date').value = endDateString;
            }
        }

        function calculateTotal() {
            const adults = parseInt(document.getElementById('adults').value) || 0;
            const children = parseInt(document.getElementById('children').value) || 0;
            const infants = parseInt(document.getElementById('infants').value) || 0;
            
            const adultPrice = parseFloat(document.getElementById('adult_price').value) || 0;
            const childPrice = parseFloat(document.getElementById('child_price').value) || 0;
            const infantPrice = parseFloat(document.getElementById('infant_price').value) || 0;
            const singleSupplement = parseFloat(document.getElementById('single_supplement').value) || 0;
            
            const total = (adults * adultPrice) + (children * childPrice) + (infants * infantPrice) + singleSupplement;
            
            document.getElementById('total_amount').value = total.toFixed(2);
        }

        // Add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Date change listeners
            document.getElementById('tour_start_date').addEventListener('change', function() {
                calculateEndDate();
                calculateTourDuration();
            });
            
            document.getElementById('tour_end_date').addEventListener('change', calculateTourDuration);
            
            // Price change listeners
            const priceFields = ['adults', 'children', 'infants', 'adult_price', 'child_price', 'infant_price', 'single_supplement'];
            priceFields.forEach(field => {
                document.getElementById(field).addEventListener('input', calculateTotal);
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>