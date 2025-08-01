<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Payment</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">ID: {{ $payment->id }}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('payment::admin.payments.show', $payment) }}" 
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
            <form method="POST" action="{{ route('payment::admin.payments.update', $payment) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Payment Association (Read Only) -->
                    <div class="lg:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Payment Association</h3>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            @if($payment->booking)
                                <div class="flex items-center space-x-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-900 dark:bg-blue-900 dark:text-blue-100">Booking Payment</span>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->booking->booking_reference }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $payment->booking->user->name ?? 'Guest User' }}</div>
                                    </div>
                                </div>
                            @elseif($payment->customPayment)
                                <div class="flex items-center space-x-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-900 dark:bg-green-900 dark:text-green-100">Custom Payment</span>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->customPayment->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $payment->customPayment->purpose ?? 'General Payment' }}</div>
                                    </div>
                                </div>
                            @else
                                <div class="text-gray-500 dark:text-gray-400">No associated booking or custom payment</div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Amount <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="amount" name="amount" step="0.01" min="0.01" required
                               value="{{ old('amount', $payment->amount) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="0.00">
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @foreach(\Modules\Payment\Models\Payment::getAvailableStatuses() as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $payment->status) === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Payment Method
                        </label>
                        <select id="payment_method" name="payment_method"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Select Method --</option>
                            @foreach(\Modules\Payment\Models\Payment::getAvailablePaymentMethods() as $value => $label)
                                <option value="{{ $value }}" {{ old('payment_method', $payment->payment_method) === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="payment_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Payment Date
                        </label>
                        <input type="datetime-local" id="payment_date" name="payment_date"
                               value="{{ old('payment_date', $payment->payment_date ? $payment->payment_date->format('Y-m-d\TH:i') : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('payment_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Transaction Details -->
                    <div>
                        <label for="transaction_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Transaction ID
                        </label>
                        <input type="text" id="transaction_id" name="transaction_id"
                               value="{{ old('transaction_id', $payment->transaction_id) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter transaction ID">
                        @error('transaction_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gateway_payment_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Gateway Payment ID
                        </label>
                        <input type="text" id="gateway_payment_id" name="gateway_payment_id"
                               value="{{ old('gateway_payment_id', $payment->gateway_payment_id) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Gateway payment ID">
                        @error('gateway_payment_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gateway_reference" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Gateway Reference
                        </label>
                        <input type="text" id="gateway_reference" name="gateway_reference"
                               value="{{ old('gateway_reference', $payment->gateway_reference) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Gateway reference number">
                        @error('gateway_reference')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="receipt_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Receipt Number
                        </label>
                        <input type="text" id="receipt_number" name="receipt_number"
                               value="{{ old('receipt_number', $payment->receipt_number) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Receipt/invoice number">
                        @error('receipt_number')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Notes
                    </label>
                    <textarea id="notes" name="notes" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Add any notes about this payment...">{{ old('notes', $payment->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Information (Read Only) -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Current Payment Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Original Amount:</span>
                            <span class="ml-2 font-medium text-gray-900 dark:text-gray-100">{{ $payment->formatted_amount }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Current Status:</span>
                            <span class="ml-2">{!! $payment->status_badge !!}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Created:</span>
                            <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $payment->created_at->format('M j, Y H:i') }}</span>
                        </div>
                        @if($payment->processed_at)
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Processed:</span>
                            <span class="ml-2 text-gray-900 dark:text-gray-100">{{ $payment->processed_at->format('M j, Y H:i') }}</span>
                        </div>
                        @endif
                        @if($payment->failed_at)
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Failed:</span>
                            <span class="ml-2 text-red-600 dark:text-red-400">{{ $payment->failed_at->format('M j, Y H:i') }}</span>
                        </div>
                        @endif
                        @if($payment->refunded_at)
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Refunded:</span>
                            <span class="ml-2 text-purple-600 dark:text-purple-400">{{ $payment->refunded_at->format('M j, Y H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('payment::admin.payments.show', $payment) }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Update Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-dashboard-layout::layout>