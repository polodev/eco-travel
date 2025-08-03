<!-- Mobile Navigation Menu -->
<div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-gray-200 dark:border-gray-700 py-4">
    <div class="space-y-2">
        <a href="{{ route('static-site::homepage') }}" class="block px-4 py-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
            {{ __('messages.home') }}
        </a>
        <a href="{{ route('static-site::about') }}" class="block px-4 py-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
            {{ __('messages.about') }}
        </a>
        
        <!-- Mobile Services Dropdown -->
        <div x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                <span>{{ __('messages.services') }}</span>
                <svg class="w-4 h-4" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-transition class="pl-6 pb-2 space-y-1">
                <a href="{{ route('static-site::flight') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">{{ __('messages.flights') }}</a>
                <a href="{{ route('static-site::hotel') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">{{ __('messages.hotels') }}</a>
                <a href="{{ route('static-site::holiday-package') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">{{ __('messages.holiday_packages') }}</a>
                <a href="{{ route('static-site::hajj-package') }}" class="block px-4 py-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">{{ __('messages.hajj_packages') }}</a>
            </div>
        </div>
        
        <a href="{{ route('payment::custom-payment.form') }}" class="block px-4 py-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
            {{ __('messages.payment') }}
        </a>
        
        <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="block px-4 py-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
            {{ __('messages.contact') }}
        </a>
    </div>
</div>