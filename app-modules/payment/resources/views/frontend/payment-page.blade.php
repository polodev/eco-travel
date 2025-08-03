<x-customer-frontend-layout::layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.complete_payment') }}</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('messages.payment_page_description') }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">{{ __('messages.payment_details') }}</h2>
                    
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-blue-900 dark:text-blue-100">{{ __('messages.amount_to_pay') }}</span>
                            <span class="text-2xl font-bold text-blue-900 dark:text-blue-100">৳{{ number_format($payment->amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                            {{ __('messages.customer_information') }}
                        </h3>
                        
                        @if($payment->customPayment)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.full_name') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->customPayment->name }}</p>
                                </div>
                                @if($payment->customPayment->email)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.email_address') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->customPayment->email }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.mobile_number') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->customPayment->mobile }}</p>
                                </div>
                                @if($payment->customPayment->purpose)
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.purpose') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->customPayment->purpose }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.reference') }}</label>
                                    <p class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100">{{ $payment->customPayment->reference_number }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.payment_status') }}</label>
                                    <p class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($payment->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                            @elseif($payment->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                            @endif">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.payment_method') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 capitalize">{{ $payment->payment_method }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.payment_id') }}</label>
                                    <p class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100">#{{ $payment->id }}</p>
                                </div>
                                @if($payment->payment_date)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.date_time') }}</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $payment->payment_date->format('M d, Y h:i A') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700 h-fit">
                    @if($payment->status === 'pending')
                        <div class="text-center">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.payment_method') }}</h3>
                            
                            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                <div class="flex items-center justify-center mb-2">
                                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-medium text-green-900 dark:text-green-100">SSL Commerz</h4>
                                <p class="text-sm text-green-700 dark:text-green-300 mt-1">{{ __('messages.ssl_commerz_description') }}</p>
                            </div>

                            <form action="{{ route('payment::payments.process', $payment) }}" method="POST" class="space-y-4">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    {{ __('messages.pay_with_ssl_commerz') }}
                                </button>
                            </form>

                            <div class="mt-6">
                                <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">{{ __('messages.supported_methods') }}</h5>
                                <div class="grid grid-cols-2 gap-2 text-xs text-gray-600 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                                        Cards
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                        Mobile Banking
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                                        Net Banking
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-2 h-2 bg-orange-500 rounded-full mr-2"></span>
                                        Wallets
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <div class="mb-4">
                                @if($payment->status === 'completed')
                                    <svg class="w-16 h-16 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-16 h-16 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                @endif
                            </div>
                            <h3 class="text-lg font-medium {{ $payment->status === 'completed' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} mb-2">
                                {{ $payment->status === 'completed' ? __('messages.payment_successful') : ($payment->status === 'failed' ? __('messages.payment_failed') : __('messages.payment_cancelled')) }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                {{ $payment->status === 'completed' ? __('messages.payment_success_message') : ($payment->status === 'failed' ? __('messages.payment_failed_message') : __('messages.payment_cancelled_message')) }}
                            </p>
                            
                            @if($payment->status !== 'completed')
                                <div class="space-y-2">
                                    <form action="{{ route('payment::payments.process', $payment) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            {{ __('messages.try_again') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-xs text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            {{ __('messages.payment_security_notice') }}
                        </p>
                    </div>
                </div>
            </div>

            @if($payment->status !== 'completed')
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('messages.payment_help_text') }} 
                    <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.contact_customer_care') }}</a>
                </p>
            </div>
            @endif
        </div>
    </div>
</x-customer-frontend-layout::layout>