<x-customer-frontend-layout::layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Mobile Header -->
            <div class="lg:hidden mb-6 text-center">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.custom_payment') }}</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ __('messages.custom_payment_description') }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                <!-- Payment Form - Shows first on mobile -->
                <div class="order-1 lg:order-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <form action="{{ route('payment::custom-payment.submit') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Amount Field -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('messages.amount') }} (৳) <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400 sm:text-sm">৳</span>
                            </div>
                            <input type="number" 
                                   name="amount" 
                                   id="amount" 
                                   step="0.01" 
                                   min="1"
                                   value="{{ old('amount') }}"
                                   class="block w-full pl-8 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('amount') border-red-500 @enderror"
                                   placeholder="0.00"
                                   required>
                        </div>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('messages.full_name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                               placeholder="{{ __('messages.enter_full_name') }}"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('messages.email_address') }}
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                               placeholder="{{ __('messages.enter_email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mobile Field -->
                    <div>
                        <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('messages.mobile_number') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               name="mobile" 
                               id="mobile" 
                               value="{{ old('mobile') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('mobile') border-red-500 @enderror"
                               placeholder="{{ __('messages.enter_mobile') }}"
                               required>
                        @error('mobile')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Purpose Field (Optional) -->
                    <div>
                        <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('messages.payment_purpose') }}
                        </label>
                        <textarea name="purpose" 
                                  id="purpose" 
                                  rows="3"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('purpose') border-red-500 @enderror"
                                  placeholder="{{ __('messages.enter_payment_purpose') }}">{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- reCAPTCHA -->
                    @if(env('RECAPTCHA_ENABLED', false))
                    <div>
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        @error('g-recaptcha-response')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        @error('recaptcha')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            {{ __('messages.proceed_to_payment') }}
                        </button>
                    </div>

                    <!-- Security Notice -->
                    <div class="text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            {{ __('messages.secure_payment_notice') }}
                        </p>
                    </div>
                </form>
                </div>

                <!-- Information Section - Shows second on mobile, first on desktop -->
                <div class="order-2 lg:order-1 lg:pr-8">
                    <div class="sticky top-8">
                        <!-- Desktop Header (hidden on mobile) -->
                        <div class="hidden lg:block">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.custom_payment') }}</h1>
                            <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">{{ __('messages.custom_payment_description') }}</p>
                        </div>
                        
                        <!-- Features -->
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('messages.secure_payment_notice') }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">256-bit SSL encryption protects your data</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Instant Processing</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Payments are processed immediately</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Multiple Payment Methods</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Cards, mobile banking & more</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Help Section -->
                        <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-2">{{ __('messages.need_help') }}</h4>
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                {{ __('messages.contact_support') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(env('RECAPTCHA_ENABLED', false))
    @push('scripts')
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endpush
    @endif
</x-customer-frontend-layout::layout>