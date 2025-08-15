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
                    <!-- Payment Records Summary -->
                    @if($customPayment->payments->count() > 0)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">Payment Records</h3>
                        <div class="space-y-2">
                            @foreach($customPayment->payments as $payment)
                            <div class="p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                <!-- Row 1: Payment info + View icon -->
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-2 text-sm">
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $payment->formatted_amount }}</span>
                                        <span class="text-gray-500 dark:text-gray-400">•</span>
                                        {!! $payment->payment_method_badge !!}
                                        <span class="text-gray-500 dark:text-gray-400">•</span>
                                        {!! $payment->status_badge !!}
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <!-- Edit Payment Link -->
                                        <a href="{{ route('payment::admin.payments.edit', $payment->id) }}" 
                                           class="inline-flex items-center p-1 text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300"
                                           title="Edit payment">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <!-- View Payment Link -->
                                        <a href="{{ route('payment::admin.payments.show', $payment->id) }}" 
                                           class="inline-flex items-center p-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                                           title="View payment details">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Row 2: Copy payment link -->
                                <div class="flex items-center space-x-2">
                                    <input type="text" 
                                           id="payment-link-{{ $payment->id }}"
                                           value="{{ route('payment::payments.show', $payment->id) }}" 
                                           readonly
                                           class="flex-1 px-2 py-1 bg-gray-100 dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded text-xs text-gray-900 dark:text-gray-100 font-mono">
                                    <button type="button"
                                            onclick="copyPaymentLink({{ $payment->id }})"
                                            class="inline-flex items-center px-2 py-1 border border-gray-300 dark:border-gray-500 rounded bg-white dark:bg-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-500 transition-colors"
                                            title="Copy payment link">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        Copy
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

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
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100 font-mono">CP-{{ $customPayment->id }}</p>
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

                    <!-- Payment Attachments -->
                    @php
                        $paymentsWithAttachments = $customPayment->payments()->whereHas('media', function($query) {
                            $query->where('collection_name', 'payment_attachment');
                        })->with('media')->get();
                    @endphp
                    
                    @if($paymentsWithAttachments->count() > 0)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Payment Attachments</h3>
                        
                        <div class="space-y-4">
                            @foreach($paymentsWithAttachments as $payment)
                                @foreach($payment->getMedia('payment_attachment') as $attachment)
                                    @php
                                        $isImage = in_array($attachment->mime_type, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp']);
                                    @endphp
                                    
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                        <div class="mb-2">
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Payment ID: #{{ $payment->id }}</span>
                                            @if($payment->bank_name)
                                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">Bank: {{ $payment->bank_name }}</span>
                                            @endif
                                        </div>
                                        
                                        @if($isImage)
                                            <!-- Image Preview -->
                                            <div class="space-y-3">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-2">
                                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $attachment->name }}</span>
                                                    </div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $attachment->human_readable_size }}</span>
                                                </div>
                                                
                                                <!-- Image Display -->
                                                <div class="mt-3">
                                                    <img src="{{ $attachment->getUrl() }}" 
                                                         alt="{{ $attachment->name }}"
                                                         class="max-w-full h-auto max-h-64 mx-auto rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm cursor-pointer"
                                                         onclick="openImageModal('{{ $attachment->getUrl() }}', '{{ $attachment->name }}')">
                                                </div>
                                                
                                                <!-- Download Link -->
                                                <div class="flex justify-center mt-3">
                                                    <a href="{{ $attachment->getUrl() }}" 
                                                       download="{{ $attachment->name }}"
                                                       class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                        Download
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Document/PDF Download -->
                                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-600">
                                                <div class="flex items-center space-x-3">
                                                    <div class="p-2 bg-red-100 dark:bg-red-900/20 rounded-lg">
                                                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $attachment->name }}</h4>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ strtoupper(pathinfo($attachment->name, PATHINFO_EXTENSION)) }} • {{ $attachment->human_readable_size }}</p>
                                                    </div>
                                                </div>
                                                <a href="{{ $attachment->getUrl() }}" 
                                                   download="{{ $attachment->name }}"
                                                   class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    Download
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    @endif

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

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain">
        </div>
    </div>

    @push('scripts')
    <script>
    function copyPaymentLink(paymentId) {
        const linkInput = document.getElementById('payment-link-' + paymentId);
        const copyButton = document.querySelector('button[onclick="copyPaymentLink(' + paymentId + ')"]');
        
        // Select and copy the text
        linkInput.select();
        linkInput.setSelectionRange(0, 99999); // For mobile devices
        
        try {
            document.execCommand('copy');
            
            // Update button appearance temporarily
            const originalHTML = copyButton.innerHTML;
            copyButton.innerHTML = `
                <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    function openImageModal(imageUrl, imageName) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        
        modalImage.src = imageUrl;
        modalImage.alt = imageName;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside the image
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>