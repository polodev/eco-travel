<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Payment Details</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">ID: {{ $payment->id }}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('payment::admin.payments.edit', $payment) }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-yellow-700 bg-yellow-100 border border-yellow-300 rounded-md hover:bg-yellow-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Payment
                    </a>
                    <a href="{{ route('payment::admin.payments.index') }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Payment Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Payment Summary -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Payment Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Amount:</span>
                                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $payment->formatted_amount }}</div>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Status:</span>
                                <div class="mt-1">{!! $payment->status_badge !!}</div>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Payment Method:</span>
                                <div class="mt-1">{!! $payment->payment_method_badge !!}</div>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Payment Type:</span>
                                <div class="mt-1">
                                    @if($payment->booking_id)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-900 dark:bg-blue-900 dark:text-blue-100">Booking Payment</span>
                                    @elseif($payment->custom_payment_id)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-900 dark:bg-green-900 dark:text-green-100">Custom Payment</span>
                                    @else
                                        <span class="text-gray-400">Unknown</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Customer Information</h3>
                        @if($payment->booking)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Customer Name:</span>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->booking->user->name ?? 'Guest User' }}</div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Email:</span>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->booking->user->email ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Booking Reference:</span>
                                    <div class="font-mono text-gray-900 dark:text-gray-100">{{ $payment->booking->booking_reference }}</div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Booking Type:</span>
                                    <div class="text-gray-900 dark:text-gray-100">{{ ucfirst($payment->booking->booking_type) }}</div>
                                </div>
                            </div>
                        @elseif($payment->customPayment)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Customer Name:</span>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->customPayment->name }}</div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Email:</span>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->customPayment->email ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Mobile:</span>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->customPayment->mobile }}</div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Purpose:</span>
                                    <div class="text-gray-900 dark:text-gray-100">{{ $payment->customPayment->purpose ?? 'N/A' }}</div>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No customer information available</p>
                        @endif
                    </div>

                    <!-- Transaction Details -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Transaction Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Transaction ID:</span>
                                <div class="font-mono text-gray-900 dark:text-gray-100">{{ $payment->transaction_id ?? 'N/A' }}</div>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Gateway Payment ID:</span>
                                <div class="font-mono text-gray-900 dark:text-gray-100">{{ $payment->gateway_payment_id ?? 'N/A' }}</div>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Gateway Reference:</span>
                                <div class="font-mono text-gray-900 dark:text-gray-100">{{ $payment->gateway_reference ?? 'N/A' }}</div>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Receipt Number:</span>
                                <div class="font-mono text-gray-900 dark:text-gray-100">{{ $payment->receipt_number ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if($payment->notes || $payment->gateway_response)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Additional Information</h3>
                        
                        @if($payment->notes)
                        <div class="mb-4">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Notes:</span>
                            <div class="mt-1 text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $payment->notes }}</div>
                        </div>
                        @endif

                        @if($payment->gateway_response)
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Gateway Response:</span>
                            <div class="mt-1 bg-gray-900 text-green-400 p-3 rounded text-xs font-mono overflow-auto">
                                <pre>{{ json_encode($payment->gateway_response, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Activity Log -->
                    @if($payment->activities->count() > 0)
                        <x-utility::collapsible-card 
                            title="ActivityLog - Payment"
                            :collapsed="true"
                            headerClass="bg-green-500 text-white hover:bg-green-600"
                            cardClass="border border-gray-200 dark:border-gray-600"
                        >
                            <x-utility::activity-log :model="$payment" />
                        </x-utility::collapsible-card>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Payment Status & Dates -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Timeline</h3>
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Created:</span>
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->created_at->format('M j, Y H:i') }}</div>
                            </div>
                            @if($payment->payment_date)
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Payment Date:</span>
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->payment_date->format('M j, Y H:i') }}</div>
                            </div>
                            @endif
                            @if($payment->processed_at)
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Processed:</span>
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->processed_at->format('M j, Y H:i') }}</div>
                            </div>
                            @endif
                            @if($payment->failed_at)
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Failed:</span>
                                <div class="font-medium text-red-600 dark:text-red-400">{{ $payment->failed_at->format('M j, Y H:i') }}</div>
                            </div>
                            @endif
                            @if($payment->refunded_at)
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Refunded:</span>
                                <div class="font-medium text-purple-600 dark:text-purple-400">{{ $payment->refunded_at->format('M j, Y H:i') }}</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('payment::admin.payments.edit', $payment) }}" 
                               class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-yellow-700 bg-yellow-100 border border-yellow-300 rounded-md hover:bg-yellow-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Payment
                            </a>
                            
                            @if($payment->booking)
                            <a href="{{ route('booking::admin.bookings.show', $payment->booking) }}" 
                               class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-blue-700 bg-blue-100 border border-blue-300 rounded-md hover:bg-blue-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Booking
                            </a>
                            @endif

                            @if($payment->customPayment)
                            <a href="{{ route('payment::admin.custom-payments.show', $payment->customPayment) }}" 
                               class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-green-700 bg-green-100 border border-green-300 rounded-md hover:bg-green-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Custom Payment
                            </a>
                            @endif

                            <!-- View Frontend Link -->
                            <a href="{{ route('payment::payments.show', $payment->id) }}" 
                               target="_blank"
                               class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-purple-700 bg-purple-100 border border-purple-300 rounded-md hover:bg-purple-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                View Frontend Page
                            </a>
                        </div>

                        <!-- Payment Link Copy Section -->
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Frontend Payment Link</h4>
                            <div class="flex items-center space-x-2">
                                <input type="text" 
                                       id="payment-link"
                                       value="{{ route('payment::payments.show', $payment->id) }}" 
                                       readonly
                                       class="flex-1 px-2 py-1 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded text-xs text-gray-900 dark:text-gray-100 font-mono">
                                <button type="button"
                                        onclick="copyPaymentLink()"
                                        class="inline-flex items-center p-1.5 border border-gray-300 dark:border-gray-500 rounded bg-white dark:bg-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function copyPaymentLink() {
        const linkInput = document.getElementById('payment-link');
        const copyButton = document.querySelector('button[onclick="copyPaymentLink()"]');
        
        // Select and copy the text
        linkInput.select();
        linkInput.setSelectionRange(0, 99999); // For mobile devices
        
        try {
            document.execCommand('copy');
            
            // Update button appearance temporarily
            const originalHTML = copyButton.innerHTML;
            copyButton.innerHTML = `
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            `;
            copyButton.classList.add('text-green-600', 'border-green-300', 'bg-green-50');
            copyButton.classList.remove('text-gray-700', 'dark:text-gray-300', 'border-gray-300', 'dark:border-gray-500', 'bg-white', 'dark:bg-gray-600');
            
            // Reset button after 2 seconds
            setTimeout(() => {
                copyButton.innerHTML = originalHTML;
                copyButton.classList.remove('text-green-600', 'border-green-300', 'bg-green-50');
                copyButton.classList.add('text-gray-700', 'dark:text-gray-300', 'border-gray-300', 'dark:border-gray-500', 'bg-white', 'dark:bg-gray-600');
            }, 2000);
            
        } catch (err) {
            console.error('Failed to copy text: ', err);
        }
        
        // Deselect the text
        linkInput.blur();
    }
    </script>
    @endpush
</x-admin-dashboard-layout::layout>