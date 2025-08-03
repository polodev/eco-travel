<!-- Footer -->
<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center">
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
                <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 text-sm transition-colors">
                    {{ __('messages.contact_us') }}
                </a>
            </div>
            
            <!-- Company Info -->
            <div class="text-gray-500 dark:text-gray-400 text-sm mb-2">
                <p>{{ __('messages.eco_travel') }} - {{ __('messages.better_service_experience') }}</p>
                <p>{{ __('messages.company_address') }}</p>
            </div>
            
            <!-- Copyright -->
            <div class="text-gray-500 dark:text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} Eco Travels. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>