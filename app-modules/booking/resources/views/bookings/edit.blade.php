<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Booking</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Reference: {{ $booking->booking_reference }}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin-dashboard.booking.bookings.show', $booking) }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="p-6">
            <form method="POST" action="{{ route('admin-dashboard.booking.bookings.update', $booking) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Booking Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Booking Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @foreach(\Modules\Booking\Models\Booking::getAvailableStatuses() as $value => $label)
                                <option value="{{ $value }}" {{ $booking->status === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Status -->
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Payment Status <span class="text-red-500">*</span>
                        </label>
                        <select id="payment_status" name="payment_status" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="pending" {{ $booking->isFullyPaid() ? '' : ($booking->isPartiallyPaid() ? '' : 'selected') }}>Pending</option>
                            <option value="partial" {{ $booking->isPartiallyPaid() ? 'selected' : '' }}>Partial</option>
                            <option value="paid" {{ $booking->isFullyPaid() ? 'selected' : '' }}>Paid</option>
                            <option value="refunded">Refunded</option>
                        </select>
                        @error('payment_status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Admin Notes
                    </label>
                    <textarea id="notes" name="notes" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Add any admin notes or comments about this booking...">{{ old('notes', $booking->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Booking Information (Read Only) -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Current Booking Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Reference:</span>
                            <span class="ml-2 font-mono text-gray-900 dark:text-gray-100">{{ $booking->booking_reference }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Type:</span>
                            <span class="ml-2 text-gray-900 dark:text-gray-100">{{ \Modules\Booking\Models\Booking::getAvailableBookingTypes()[$booking->booking_type] ?? $booking->booking_type }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Customer:</span>
                            <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $booking->customer_name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Total Amount:</span>
                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">৳{{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Net Receivable:</span>
                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">{{ $booking->formatted_net_receivable_amount }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Paid Amount:</span>
                            <span class="ml-2 font-medium text-green-600 dark:text-green-400">{{ $booking->formatted_total_paid }}</span>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin-dashboard.booking.bookings.show', $booking) }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Update Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-dashboard-layout::layout>