<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div>
                        <div class="flex items-center space-x-2 mb-2">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $customPayment->name }}</h2>
                            {!! $customPayment->status_badge !!}
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $customPayment->purpose ?? 'General Payment' }}</p>
                        @if($customPayment->reference_number)
                            <p class="text-xs text-gray-500 dark:text-gray-400">Reference: {{ $customPayment->reference_number }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('payment::admin.custom-payments.edit', $customPayment) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('payment::admin.custom-payments.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Customer Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Customer Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Full Name</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $customPayment->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email Address</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $customPayment->email ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Mobile Number</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $customPayment->mobile }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">IP Address</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $customPayment->ip_address ?? 'Not recorded' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Payment Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Purpose</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $customPayment->purpose ?? 'General Payment' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Reference Number</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100 font-mono">{{ $customPayment->reference_number ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Payment Method</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $customPayment->payment_method ? \Modules\Payment\Models\Payment::getAvailablePaymentMethods()[$customPayment->payment_method] ?? $customPayment->payment_method : 'Not specified' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</label>
                                <div class="mt-1">{!! $customPayment->status_badge !!}</div>
                            </div>
                        </div>
                        
                        @if($customPayment->description)
                        <div class="mt-4">
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customPayment->description }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Payment Records Volt Component -->
                    <livewire:payment--payments-of-custom-payment :customPayment="$customPayment" />

                    @if($customPayment->admin_notes)
                    <!-- Admin Notes -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Admin Notes</h3>
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $customPayment->admin_notes }}</p>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Payment Summary -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Payment Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Total Amount</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $customPayment->formatted_amount }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Amount Paid</span>
                                <span class="text-sm font-medium text-green-600 dark:text-green-400">{{ $customPayment->formatted_total_paid }}</span>
                            </div>
                            <div class="flex justify-between items-center border-t border-gray-200 dark:border-gray-600 pt-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Remaining</span>
                                <span class="text-sm font-medium {{ $customPayment->remaining_amount > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                    {{ $customPayment->formatted_remaining_amount }}
                                </span>
                            </div>
                        </div>

                        <!-- Payment Status Badge -->
                        <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-600">
                            <div class="text-center">
                                @if($customPayment->isFullyPaid())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Fully Paid
                                    </span>
                                @elseif($customPayment->isPartiallyPaid())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        Partially Paid
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        Unpaid
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Timeline</h3>
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Created:</span>
                                <span class="text-gray-900 dark:text-gray-100 ml-2">{{ $customPayment->created_at->format('M j, Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Last Updated:</span>
                                <span class="text-gray-900 dark:text-gray-100 ml-2">{{ $customPayment->updated_at->format('M j, Y H:i') }}</span>
                            </div>
                            @if($customPayment->processedBy)
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Processed By:</span>
                                <span class="text-gray-900 dark:text-gray-100 ml-2">{{ $customPayment->processedBy->name }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Log - Full Width -->
            @if($customPayment->activities->count() > 0)
                <div class="mt-6">
                    <x-utility::collapsible-card 
                        title="ActivityLog - Custom Payment"
                        :collapsed="true"
                        headerClass="bg-green-500 text-white hover:bg-green-600"
                        cardClass="border border-gray-200 dark:border-gray-600"
                    >
                        <x-utility::activity-log :model="$customPayment" />
                    </x-utility::collapsible-card>
                </div>
            @endif
        </div>
    </div>
</x-admin-dashboard-layout::layout>