<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Create Booking Header -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Create New Booking</h2>
                <a href="{{ route('booking::admin.bookings.index') }}" 
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>
        <!-- Form Content -->
        <div class="p-6">
            <form method="POST" action="{{ route('booking::admin.bookings.store') }}">
                @csrf
                <!-- Booking Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Booking Type -->
                    <div>
                        <label for="booking_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Booking Type</label>
                        <select id="booking_type" name="booking_type" required
                                class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Select a type</option>
                            @foreach(\Modules\Booking\Models\Booking::getAvailableBookingTypes() as $value => $label)
                                <option value="{{ $value }}" {{ old('booking_type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('booking_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Booking Reference -->
                    <div>
                        <label for="booking_reference" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Booking Reference</label>
                        <input type="text" id="booking_reference" name="booking_reference" required
                               class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                               placeholder="Reference"
                               value="{{ old('booking_reference') }}">
                        @error('booking_reference')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Customer Info -->
                <div class="mt-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Customer Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Customer Name</label>
                            <input type="text" id="customer_name" name="customer_name" required
                                   class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                   placeholder="Customer Name"
                                   value="{{ old('customer_name') }}">
                            @error('customer_name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Customer Email</label>
                            <input type="email" id="customer_email" name="customer_email" required
                                   class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                   placeholder="Customer Email"
                                   value="{{ old('customer_email') }}">
                            @error('customer_email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="w-full px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        Create Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-dashboard-layout::layout>
