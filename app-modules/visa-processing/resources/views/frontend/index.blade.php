<x-customer-frontend-layout::layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('messages.visa_processing_services') }}
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    {{ __('messages.visa_processing_description') }}
                </p>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                <form method="GET" action="{{ route('visa-processing::visa-processings.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.search') }}
                            </label>
                            <input type="text" name="search" id="search" 
                                   value="{{ request('search') }}"
                                   placeholder="{{ __('messages.search_visa_services') }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Country Filter -->
                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.country') }}
                            </label>
                            <select name="country" id="country" 
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">{{ __('messages.all_countries') }}</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->country_code }}" {{ request('country') == $country->country_code ? 'selected' : '' }}>
                                        {{ $country->country_flag }} {{ $country->country_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Visa Type Filter -->
                        <div>
                            <label for="visa_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.visa_type') }}
                            </label>
                            <select name="visa_type" id="visa_type" 
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">{{ __('messages.all_visa_types') }}</option>
                                @foreach($visaTypes as $key => $label)
                                    <option value="{{ $key }}" {{ request('visa_type') == $key ? 'selected' : '' }}>
                                        {{ __('messages.visa_type_' . $key) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Sort -->
                        <div>
                            <label for="sort_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.sort_by_price') }}
                            </label>
                            <select name="sort_price" id="sort_price" 
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">{{ __('messages.default') }}</option>
                                <option value="low" {{ request('sort_price') == 'low' ? 'selected' : '' }}>{{ __('messages.price_low_to_high') }}</option>
                                <option value="high" {{ request('sort_price') == 'high' ? 'selected' : '' }}>{{ __('messages.price_high_to_low') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('messages.showing_results', ['total' => $visaProcessings->total()]) }}
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('visa-processing::visa-processings.index') }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                                {{ __('messages.clear_filters') }}
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                {{ __('messages.apply_filters') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Visa Processing Grid -->
            @if($visaProcessings->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($visaProcessings as $visaProcessing)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <!-- Header -->
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-3xl">{{ $visaProcessing->country_flag }}</span>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                                {{ $visaProcessing->country_name }}
                                            </h3>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                                {{ ucfirst($visaProcessing->visa_type) }} Visa
                                            </span>
                                        </div>
                                    </div>
                                    @if($visaProcessing->is_featured)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                            {{ __('messages.featured') }}
                                        </span>
                                    @endif
                                </div>

                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ $visaProcessing->getTranslation('title', app()->getLocale()) }}
                                </h4>

                                <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        @if($visaProcessing->estimated_processing_time)
                                            {{ $visaProcessing->estimated_processing_time }} {{ __('messages.days') }}
                                        @else
                                            {{ __('messages.varies') }}
                                        @endif
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ ucfirst($visaProcessing->difficulty_level) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Content Preview -->
                            <div class="p-6">
                                <div class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($visaProcessing->getTranslation('content', app()->getLocale())), 120) }}
                                </div>

                                <!-- Pricing -->
                                <div class="mb-6">
                                    <div class="text-center">
                                        <span class="text-2xl font-bold text-green-600 dark:text-green-400">
                                            {{ $visaProcessing->formatted_price }}
                                        </span>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ __('messages.total_price') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex space-x-3">
                                    <a href="{{ route('visa-processing::visa-processings.show', $visaProcessing->slug) }}" 
                                       class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-md transition-colors">
                                        {{ __('messages.view_details') }}
                                    </a>
                                    <a href="{{ route('visa-processing::visa-processings.purchase', $visaProcessing->slug) }}" 
                                       class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                                        {{ __('messages.order_now') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $visaProcessings->withQueryString()->links() }}
                </div>
            @else
                <!-- No Results -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.no_visa_services_found') }}</h3>
                    <p class="mt-1 text-gray-500 dark:text-gray-400">{{ __('messages.try_adjusting_filters') }}</p>
                    <div class="mt-6">
                        <a href="{{ route('visa-processing::visa-processings.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent text-sm font-medium rounded-md text-white hover:bg-blue-700">
                            {{ __('messages.view_all_services') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto-submit form on filter change
        $(document).ready(function() {
            $('#country, #visa_type, #sort_price').on('change', function() {
                $(this).closest('form').submit();
            });
        });
    </script>
    @endpush
</x-customer-frontend-layout::layout>