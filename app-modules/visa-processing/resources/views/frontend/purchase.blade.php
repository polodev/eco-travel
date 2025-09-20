<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.apply_for') }} {{ $visaProcessing->getTranslation('title', app()->getLocale()) }}</x-slot>
    <x-slot name="metaDescription">{{ __('messages.apply_visa_meta_description', ['visa' => $visaProcessing->getTranslation('title', app()->getLocale())]) }}</x-slot>

    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L9 3.414V19a1 1 0 0 0 2 0V3.414l6.293 6.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        {{ __('messages.home') }}
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ route('visa-processing::visa-processings.show', $visaProcessing) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                            {{ $visaProcessing->getTranslation('title', app()->getLocale()) }}
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ __('messages.apply_now') }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Application Form -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ __('messages.visa_application_form') }}
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ __('messages.fill_form_carefully') }}
                        </p>
                    </div>

                    <!-- Visa Info Header -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">{{ $visaProcessing->country_flag }}</span>
                            <div>
                                <h2 class="font-semibold text-gray-900 dark:text-white">
                                    {{ $visaProcessing->getTranslation('title', app()->getLocale()) }}
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $visaProcessing->country_name }} • {{ ucfirst($visaProcessing->visa_type) }} {{ __('messages.visa') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                            <div class="flex">
                                <svg class="w-5 h-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                        {{ __('messages.form_errors') }}
                                    </h3>
                                    <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Application Form -->
                    <form method="POST" action="{{ route('visa-processing::visa-processings.purchase.submit', $visaProcessing) }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf

                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                {{ __('messages.personal_information') }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.full_name') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.email') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.mobile_number') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label for="passport_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.passport_number') }}
                                    </label>
                                    <input type="text" id="passport_number" name="passport_number" value="{{ old('passport_number') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="travel_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.intended_travel_date') }}
                                    </label>
                                    <input type="date" id="travel_date" name="travel_date" value="{{ old('travel_date') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>
                        </div>

                        <!-- Document Upload -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                {{ __('messages.required_documents') }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                                {{ __('messages.upload_documents_instruction') }}
                            </p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Bank Statement -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.bank_statement') }} 
                                        <span class="text-green-600">{{ __('messages.recommended') }}</span>
                                    </label>
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-blue-400 transition-colors">
                                        <input type="file" name="bank_statement" id="bank_statement" 
                                               accept=".pdf,.jpg,.jpeg,.png,.webp" class="hidden"
                                               onchange="handleFileSelect(this, 'bank_statement_preview')">
                                        <label for="bank_statement" class="cursor-pointer">
                                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.click_to_upload') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500">PDF, JPG, PNG, WEBP (Max 5MB)</p>
                                        </label>
                                        <div id="bank_statement_preview" class="mt-2 hidden">
                                            <span class="text-sm text-green-600 dark:text-green-400"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Passport -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.passport_copy') }} 
                                        <span class="text-green-600">{{ __('messages.recommended') }}</span>
                                    </label>
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-blue-400 transition-colors">
                                        <input type="file" name="passport" id="passport" 
                                               accept=".pdf,.jpg,.jpeg,.png,.webp" class="hidden"
                                               onchange="handleFileSelect(this, 'passport_preview')">
                                        <label for="passport" class="cursor-pointer">
                                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.click_to_upload') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500">PDF, JPG, PNG, WEBP (Max 5MB)</p>
                                        </label>
                                        <div id="passport_preview" class="mt-2 hidden">
                                            <span class="text-sm text-green-600 dark:text-green-400"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- National ID Card -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.national_id_card') }} 
                                        <span class="text-green-600">{{ __('messages.recommended') }}</span>
                                    </label>
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-blue-400 transition-colors">
                                        <input type="file" name="nid_card" id="nid_card" 
                                               accept=".pdf,.jpg,.jpeg,.png,.webp" class="hidden"
                                               onchange="handleFileSelect(this, 'nid_card_preview')">
                                        <label for="nid_card" class="cursor-pointer">
                                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.click_to_upload') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500">PDF, JPG, PNG, WEBP (Max 5MB)</p>
                                        </label>
                                        <div id="nid_card_preview" class="mt-2 hidden">
                                            <span class="text-sm text-green-600 dark:text-green-400"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Trade License -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.trade_license') }} 
                                        <span class="text-gray-500">{{ __('messages.optional') }}</span>
                                    </label>
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-blue-400 transition-colors">
                                        <input type="file" name="trade_licence" id="trade_licence" 
                                               accept=".pdf,.jpg,.jpeg,.png,.webp" class="hidden"
                                               onchange="handleFileSelect(this, 'trade_licence_preview')">
                                        <label for="trade_licence" class="cursor-pointer">
                                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.click_to_upload') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500">PDF, JPG, PNG, WEBP (Max 5MB)</p>
                                        </label>
                                        <div id="trade_licence_preview" class="mt-2 hidden">
                                            <span class="text-sm text-green-600 dark:text-green-400"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- TIN Certificate -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.tin_certificate') }} 
                                        <span class="text-gray-500">{{ __('messages.optional') }}</span>
                                    </label>
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-blue-400 transition-colors">
                                        <input type="file" name="tin_certificate" id="tin_certificate" 
                                               accept=".pdf,.jpg,.jpeg,.png,.webp" class="hidden"
                                               onchange="handleFileSelect(this, 'tin_certificate_preview')">
                                        <label for="tin_certificate" class="cursor-pointer">
                                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.click_to_upload') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500">PDF, JPG, PNG, WEBP (Max 5MB)</p>
                                        </label>
                                        <div id="tin_certificate_preview" class="mt-2 hidden">
                                            <span class="text-sm text-green-600 dark:text-green-400"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- NOC -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.noc_certificate') }} 
                                        <span class="text-gray-500">{{ __('messages.optional') }}</span>
                                    </label>
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-blue-400 transition-colors">
                                        <input type="file" name="noc" id="noc" 
                                               accept=".pdf,.jpg,.jpeg,.png,.webp" class="hidden"
                                               onchange="handleFileSelect(this, 'noc_preview')">
                                        <label for="noc" class="cursor-pointer">
                                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.click_to_upload') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500">PDF, JPG, PNG, WEBP (Max 5MB)</p>
                                        </label>
                                        <div id="noc_preview" class="mt-2 hidden">
                                            <span class="text-sm text-green-600 dark:text-green-400"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                {{ __('messages.additional_information') }}
                            </h3>
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('messages.special_notes') }}
                                </label>
                                <textarea id="notes" name="notes" rows="4" 
                                          placeholder="{{ __('messages.special_notes_placeholder') }}"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <!-- Hidden Payment Method (SSL only for now) -->
                        <input type="hidden" name="payment_method" value="sslcommerz">

                        <!-- reCAPTCHA -->
                        @if(env('RECAPTCHA_ENABLED', false))
                        <div>
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        </div>
                        @endif

                        <!-- Terms and Submit -->
                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="space-y-4">
                                <label class="flex items-start space-x-3">
                                    <input type="checkbox" required class="mt-1 rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ __('messages.terms_agreement') }}
                                        <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">
                                            {{ __('messages.terms_conditions') }}
                                        </a>
                                    </span>
                                </label>
                                <button type="submit" 
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                                    {{ __('messages.proceed_to_payment') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="mt-8 lg:mt-0">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 sticky top-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                        {{ __('messages.order_summary') }}
                    </h3>
                    
                    <!-- Visa Details -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4">
                        <div class="flex items-center space-x-3 mb-3">
                            <span class="text-xl">{{ $visaProcessing->country_flag }}</span>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white text-sm">
                                    {{ $visaProcessing->getTranslation('title', app()->getLocale()) }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ ucfirst($visaProcessing->visa_type) }} {{ __('messages.visa') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('messages.total_price') }}</span>
                            <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $visaProcessing->formatted_price }}</span>
                        </div>
                    </div>

                    <!-- Payment Gateway Charges Info -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                        <h4 class="font-medium text-gray-900 dark:text-white mb-2 text-sm">
                            {{ __('messages.payment_gateway_charges') }}
                        </h4>
                        <div class="space-y-1 text-xs text-gray-600 dark:text-gray-400">
                            <div>{{ __('messages.card_payment') }}: {{ $gatewayCharges['sslcommerz_regular'] }}%</div>
                            <div>{{ __('messages.premium_card') }}: {{ $gatewayCharges['sslcommerz_premium'] }}%</div>
                            <div>{{ __('messages.mobile_banking') }}: {{ $gatewayCharges['bkash'] }}%</div>
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3">
                        <div class="flex items-start space-x-2">
                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-xs text-green-700 dark:text-green-300">
                                <div class="font-medium mb-1">{{ __('messages.secure_payment') }}</div>
                                <div>{{ __('messages.ssl_secured_description') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(env('RECAPTCHA_ENABLED', false))
    @push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endpush
    @endif

    @push('scripts')
    <script>
        function handleFileSelect(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            if (file) {
                // Check file size
                if (file.size > maxSize) {
                    alert('File size must be less than 5MB');
                    input.value = '';
                    preview.classList.add('hidden');
                    return;
                }
                
                // Check file type
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Only PDF, JPG, PNG, and WEBP files are allowed');
                    input.value = '';
                    preview.classList.add('hidden');
                    return;
                }
                
                // Show file name
                preview.classList.remove('hidden');
                preview.querySelector('span').textContent = `✓ ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
            } else {
                preview.classList.add('hidden');
            }
        }
        
        // File drop functionality
        document.addEventListener('DOMContentLoaded', function() {
            const uploadAreas = document.querySelectorAll('.border-dashed');
            
            uploadAreas.forEach(area => {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    area.addEventListener(eventName, preventDefaults, false);
                });
                
                ['dragenter', 'dragover'].forEach(eventName => {
                    area.addEventListener(eventName, highlight, false);
                });
                
                ['dragleave', 'drop'].forEach(eventName => {
                    area.addEventListener(eventName, unhighlight, false);
                });
                
                area.addEventListener('drop', handleDrop, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            function highlight(e) {
                e.currentTarget.classList.add('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
            }
            
            function unhighlight(e) {
                e.currentTarget.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/20');
            }
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                const input = e.currentTarget.querySelector('input[type="file"]');
                
                if (files.length > 0) {
                    input.files = files;
                    const previewId = input.getAttribute('onchange').match(/handleFileSelect\(this, '(.+?)'\)/)[1];
                    handleFileSelect(input, previewId);
                }
            }
        });
    </script>
    @endpush
</x-customer-frontend-layout::layout>