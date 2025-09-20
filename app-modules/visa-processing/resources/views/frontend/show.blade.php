<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ $visaProcessing->getTranslation('title', app()->getLocale()) }} - {{ __('messages.visa_processing') }}</x-slot>
    <x-slot name="metaDescription">{{ $visaProcessing->getTranslation('meta_description', app()->getLocale()) ?? $visaProcessing->getTranslation('title', app()->getLocale()) }}</x-slot>
    <x-slot name="keywords">{{ $visaProcessing->getTranslation('keywords', app()->getLocale()) ?? '' }}</x-slot>

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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $visaProcessing->getTranslation('title', app()->getLocale()) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Visa Header -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <span class="text-3xl">{{ $visaProcessing->country_flag }}</span>
                            <div>
                                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
                                    {{ $visaProcessing->getTranslation('title', app()->getLocale()) }}
                                </h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $visaProcessing->country_name }} • {{ ucfirst($visaProcessing->visa_type) }} {{ __('messages.visa') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                {{ $visaProcessing->formatted_total_price }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('messages.total_price') }}
                            </div>
                        </div>
                    </div>

                    <!-- Quick Info -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="text-center">
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $visaProcessing->processing_days ?? 'TBA' }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('messages.processing_days') }}
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $visaProcessing->difficulty_level ? ucfirst($visaProcessing->difficulty_level) : 'N/A' }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('messages.difficulty') }}
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $visaProcessing->formatted_price }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('messages.total_price') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visa Content -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ __('messages.visa_details') }}
                    </h2>
                    <div class="prose prose-gray dark:prose-invert max-w-none">
                        {!! nl2br(e($visaProcessing->getTranslation('content', app()->getLocale()))) !!}
                    </div>
                </div>

                <!-- Required Documents -->
                @if($visaProcessing->required_documents && count($visaProcessing->required_documents) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ __('messages.required_documents') }}
                    </h2>
                    <ul class="space-y-2">
                        @foreach($visaProcessing->required_documents as $document)
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">{{ $document }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Embassy Information -->
                @if($visaProcessing->embassy_info && count($visaProcessing->embassy_info) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ __('messages.embassy_information') }}
                    </h2>
                    <div class="space-y-3">
                        @foreach($visaProcessing->embassy_info as $key => $info)
                        <div>
                            <dt class="font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $key)) }}:</dt>
                            <dd class="text-gray-700 dark:text-gray-300">{{ $info }}</dd>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="mt-8 lg:mt-0">
                <!-- Apply Now Card -->
                <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-lg shadow-lg p-6 text-white mb-6">
                    <h3 class="text-lg font-bold mb-2">{{ __('messages.ready_to_apply') }}</h3>
                    <p class="text-green-50 mb-4 text-sm">
                        {{ __('messages.apply_visa_description') }}
                    </p>
                    <div class="space-y-3">
                        <a href="{{ route('visa-processing::visa-processings.purchase', $visaProcessing) }}" 
                           class="block w-full bg-white text-green-700 text-center py-2 px-4 rounded-lg font-semibold hover:bg-green-50 transition duration-200">
                            {{ __('messages.apply_now') }}
                        </a>
                        <div class="text-center text-green-50 text-sm">
                            {{ __('messages.secure_payment') }}
                        </div>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('messages.need_help') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                        {{ __('messages.contact_support_description') }}
                    </p>
                    <div class="space-y-2">
                        <a href="tel:+8801700000000" class="flex items-center space-x-3 text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <span>+880 1700-000000</span>
                        </a>
                        <a href="mailto:support@rajib.test" class="flex items-center space-x-3 text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            <span>support@rajib.test</span>
                        </a>
                    </div>
                </div>

                <!-- Quick Facts -->
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    <h4 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-2">
                        {{ __('messages.important_note') }}
                    </h4>
                    <p class="text-yellow-700 dark:text-yellow-300 text-sm">
                        {{ __('messages.visa_disclaimer') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Related Visas -->
        @if($relatedVisas->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                {{ __('messages.related_visas') }}
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedVisas as $related)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-200">
                    <div class="p-4">
                        <div class="flex items-center space-x-2 mb-3">
                            <span class="text-lg">{{ $related->country_flag }}</span>
                            <span class="font-medium text-gray-900 dark:text-white text-sm">{{ $related->country_name }}</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                            {{ $related->getTranslation('title', app()->getLocale()) }}
                        </h3>
                        <div class="flex items-center justify-between">
                            <span class="text-green-600 dark:text-green-400 font-semibold">
                                {{ $related->formatted_price }}
                            </span>
                            <a href="{{ route('visa-processing::visa-processings.show', $related) }}" 
                               class="text-blue-600 dark:text-blue-400 text-sm hover:underline">
                                {{ __('messages.view_details') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-customer-frontend-layout::layout>