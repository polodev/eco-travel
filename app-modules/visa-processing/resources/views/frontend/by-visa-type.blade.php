<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ $visaTypeName }} {{ __('messages.visas') }} - {{ __('messages.visa_processing') }}</x-slot>
    <x-slot name="metaDescription">{{ __('messages.browse_visa_type_meta', ['type' => $visaTypeName]) }}</x-slot>

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
                        <a href="{{ route('visa-processing::visa-processings.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                            {{ __('messages.visa_processing') }}
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $visaTypeName }} {{ __('messages.visas') }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                {{ $visaTypeName }} {{ __('messages.visas') }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                {{ __('messages.browse_visa_type_description', ['type' => strtolower($visaTypeName)]) }}
            </p>
        </div>

        @if($visaProcessings->count() > 0)
            <!-- Visa Processings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($visaProcessings as $visa)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-200">
                    <!-- Card Header -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">{{ $visa->country_flag }}</span>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">
                                        {{ $visa->country_name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ ucfirst($visa->visa_type) }} {{ __('messages.visa') }}
                                    </p>
                                </div>
                            </div>
                            @if($visa->is_featured)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                    {{ __('messages.featured') }}
                                </span>
                            @endif
                        </div>

                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 line-clamp-2">
                            {{ $visa->getTranslation('title', app()->getLocale()) }}
                        </h4>

                        <!-- Quick Info -->
                        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">{{ __('messages.processing_time') }}:</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ $visa->processing_days ? $visa->processing_days . ' ' . __('messages.days') : __('messages.tba') }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">{{ __('messages.difficulty') }}:</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ ucfirst($visa->difficulty_level ?? 'N/A') }}
                                </span>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('messages.starting_from') }}</p>
                                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                                        {{ $visa->formatted_price }}
                                    </p>
                                </div>
                                <div class="space-y-2">
                                    <a href="{{ route('visa-processing::visa-processings.show', $visa) }}" 
                                       class="block w-full text-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition duration-200">
                                        {{ __('messages.view_details') }}
                                    </a>
                                    <a href="{{ route('visa-processing::visa-processings.purchase', $visa) }}" 
                                       class="block w-full text-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition duration-200">
                                        {{ __('messages.apply_now') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $visaProcessings->links() }}
            </div>
        @else
            <!-- No Results -->
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                    {{ __('messages.no_visas_found') }}
                </h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">
                    {{ __('messages.no_visa_type_description', ['type' => strtolower($visaTypeName)]) }}
                </p>
                <a href="{{ route('visa-processing::visa-processings.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('messages.browse_all_visas') }}
                </a>
            </div>
        @endif

        <!-- Visa Type Information -->
        <div class="mt-12 bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                {{ __('messages.about_visa_type', ['type' => $visaTypeName]) }}
            </h2>
            <div class="prose prose-gray dark:prose-invert max-w-none">
                @switch($visaType)
                    @case('tourist')
                        <p>{{ __('messages.tourist_visa_description') }}</p>
                        @break
                    @case('business')
                        <p>{{ __('messages.business_visa_description') }}</p>
                        @break
                    @case('medical')
                        <p>{{ __('messages.medical_visa_description') }}</p>
                        @break
                    @case('student')
                        <p>{{ __('messages.student_visa_description') }}</p>
                        @break
                    @case('work')
                        <p>{{ __('messages.work_visa_description') }}</p>
                        @break
                    @default
                        <p>{{ __('messages.general_visa_description', ['type' => $visaTypeName]) }}</p>
                @endswitch
            </div>
        </div>

        <!-- Other Visa Types -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                {{ __('messages.other_visa_types') }}
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $allVisaTypes = \Modules\VisaProcessing\Models\VisaProcessing::getAvailableVisaTypes();
                @endphp
                @foreach($allVisaTypes as $typeKey => $typeName)
                    @if($typeKey !== $visaType)
                        <a href="{{ route('visa-processing::visa-processings.by-visa-type', $typeKey) }}" 
                           class="block p-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-blue-500 dark:hover:border-blue-400 transition duration-200">
                            <span class="font-medium text-gray-900 dark:text-white">{{ $typeName }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>