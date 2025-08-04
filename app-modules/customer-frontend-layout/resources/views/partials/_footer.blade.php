<!-- Footer -->
<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('messages.eco_travel') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                    {{ __('messages.better_service_experience') }}
                </p>
                <div class="text-gray-600 dark:text-gray-400 text-sm space-y-2">
                    <p class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <a href="mailto:info@ecotravelsonline.com.bd" class="hover:text-emerald-600 dark:hover:text-emerald-400">info@ecotravelsonline.com.bd</a>
                    </p>
                    <p class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <a href="tel:+8809647668822" class="hover:text-emerald-600 dark:hover:text-emerald-400">+8809647668822</a>
                    </p>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('messages.quick_links') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('static-site::homepage') }}" class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">{{ __('messages.home') }}</a></li>
                    <li><a href="{{ route('static-site::about') }}" class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">{{ __('messages.about') }}</a></li>
                    <li><a href="{{ route('static-site::flight') }}" class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">{{ __('messages.flights') }}</a></li>
                    <li><a href="{{ route('static-site::hotel') }}" class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">{{ __('messages.hotels') }}</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">{{ __('messages.contact_us') }}</a></li>
                </ul>
            </div>

            <!-- Bangladesh Office -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('messages.bangladesh_office') }}</h3>
                <div class="text-gray-600 dark:text-gray-400 text-sm space-y-2">
                    <p class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ __('messages.bangladesh_address') }}
                    </p>
                    <p class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <a href="tel:01600366415" class="hover:text-emerald-600 dark:hover:text-emerald-400">01600366415</a>
                    </p>
                </div>
            </div>

            <!-- International Offices -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('messages.international_offices') }}</h3>
                <div class="text-gray-600 dark:text-gray-400 text-sm space-y-3">
                    <div>
                        <p class="font-medium text-gray-700 dark:text-gray-300">{{ __('messages.new_zealand_office') }}</p>
                        <p class="text-xs">{{ __('messages.new_zealand_address') }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-700 dark:text-gray-300">{{ __('messages.australia_office') }}</p>
                        <p class="text-xs">{{ __('messages.australia_address') }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-700 dark:text-gray-300">{{ __('messages.india_office') }}</p>
                        <p class="text-xs">{{ __('messages.india_address') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
            <!-- Payment Channel -->
            <div class="text-center mb-6">
                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">{{ __('messages.secure_payment_powered_by') }}</h4>
                <div class="flex justify-center">
                    <img src="{{ asset('images/sslcommerz.png') }}" 
                         alt="SSLCommerz - Secure Payment Gateway" 
                         class="h-12 w-auto opacity-80 hover:opacity-100 transition-opacity">
                </div>
            </div>

            <!-- Legal Links -->
            <div class="flex flex-wrap justify-center items-center gap-4 md:gap-6 mb-4">
                <a href="{{ LaravelLocalization::localizeUrl('/pages/terms-of-service') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 text-sm transition-colors">
                    {{ __('messages.terms_of_service') }}
                </a>
                <span class="text-gray-400 dark:text-gray-600">•</span>
                <a href="{{ LaravelLocalization::localizeUrl('/pages/privacy-policy') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 text-sm transition-colors">
                    {{ __('messages.privacy_policy') }}
                </a>
                <span class="text-gray-400 dark:text-gray-600">•</span>
                <a href="{{ route('payment::custom-payment.form') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 text-sm transition-colors">
                    {{ __('messages.payment') }}
                </a>
            </div>
            
            <!-- Copyright -->
            <div class="text-center text-gray-500 dark:text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} Eco Travels. All rights reserved.</p>
                <p class="mt-1">{{ __('messages.open_24_7') }}</p>
            </div>
        </div>
    </div>
</footer>