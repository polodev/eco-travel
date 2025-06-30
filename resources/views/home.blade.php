<x-customer-frontend-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
        <div class="px-6 py-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white mb-6">
                    {{ __('messages.welcome') }}
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                    Welcome to our multilingual website. Choose your preferred language:
                </p>
                
                <!-- Language Switcher -->
                <div class="flex justify-center space-x-4 mb-8">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" 
                           class="px-4 py-2 rounded-md text-sm font-medium {{ LaravelLocalization::getCurrentLocale() == $localeCode ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
                
                <div class="space-y-4">
                    <p class="text-gray-600 dark:text-gray-400">Current Language: <strong>{{ app()->getLocale() }}</strong></p>
                    <p class="text-gray-600 dark:text-gray-400">Current URL: <strong>{{ url()->current() }}</strong></p>
                    
                    <div class="mt-8 space-y-2">
                        <p class="text-gray-600 dark:text-gray-400">Translation Examples:</p>
                        <ul class="space-y-1 text-sm">
                            <li>{{ __('messages.home') }}</li>
                            <li>{{ __('messages.about') }}</li>
                            <li>{{ __('messages.contact') }}</li>
                            <li>{{ __('messages.services') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>