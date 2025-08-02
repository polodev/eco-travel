<x-customer-frontend-layout::layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ __('messages.complete_payment') }}</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('messages.payment_page_description') }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Payment Information -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">{{ __('messages.payment_details') }}</h2>
                    
                    <!-- Payment Amount -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-6">
                        <div class="text-center">
                            <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">{{ __('messages.amount_to_pay') }}</p>
                            <p class="text-3xl font-bold text-blue-900 dark:text-blue-100">৳{{ number_format($payment->amount, 2) }}</p>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    @if($payment->customPayment)
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('messages.customer_information') }}</h3>
                        <div class="grid grid-cols-1 gap-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('messages.name') }}:</span>
                                <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $payment->customPayment->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('messages.email') }}:</span>
                                <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $payment->customPayment->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('messages.mobile') }}:</span>
                                <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $payment->customPayment->mobile }}</span>
                            </div>
                            @if($payment->customPayment->purpose)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('messages.purpose') }}:</span>
                                <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $payment->customPayment->purpose }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('messages.reference') }}:</span>
                                <span class="text-gray-900 dark:text-gray-100 font-mono text-sm">{{ $payment->customPayment->reference_number }}</span>
                            </div>
                        </div>
                    </div>
                    @elseif($payment->booking)
                    <!-- Booking Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('messages.booking_information') }}</h3>
                        <div class="grid grid-cols-1 gap-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('messages.booking_reference') }}:</span>
                                <span class="text-gray-900 dark:text-gray-100 font-mono text-sm">{{ $payment->booking->booking_reference }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('messages.booking_type') }}:</span>
                                <span class="text-gray-900 dark:text-gray-100 font-medium">{{ ucfirst($payment->booking->booking_type) }}</span>
                            </div>
                            @if($payment->booking->user)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('messages.customer') }}:</span>
                                <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $payment->booking->user->name }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Payment Status -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('messages.payment_status') }}:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">{{ __('messages.payment_method') }}</h2>
                    
                    @if($payment->payment_method === 'sslcommerz')
                        <!-- SSL Commerz Payment -->
                        <div class="space-y-4">
                            <div class="flex items-center p-4 border-2 border-blue-200 dark:border-blue-800 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-blue-900 dark:text-blue-100">SSL Commerz</h3>
                                    <p class="text-sm text-blue-700 dark:text-blue-300">{{ __('messages.ssl_commerz_description') }}</p>
                                </div>
                            </div>

                            <!-- Payment Button (Placeholder) -->
                            <div class="space-y-4">
                                <button type="button" 
                                        onclick="alert('SSL Commerz integration will be implemented in the next phase.')"
                                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    {{ __('messages.pay_with_ssl_commerz') }}
                                </button>

                                <!-- Supported Payment Methods -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.supported_methods') }}:</p>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Visa</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Mastercard</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">bKash</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">Nagad</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">Banking</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Unsupported Payment Method -->
                        <div class="text-center py-8">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('messages.payment_method_not_supported') }}</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('messages.payment_method_not_supported_description', ['method' => ucfirst($payment->payment_method)]) }}
                            </p>
                            <div class="mt-6">
                                <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    {{ __('messages.contact_customer_care') }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Security Notice -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span>{{ __('messages.payment_security_notice') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back to Form -->
            <div class="mt-8 text-center">
                <a href="{{ route('payment::custom-payment.form') }}" 
                   class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('messages.back_to_payment_form') }}
                </a>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>