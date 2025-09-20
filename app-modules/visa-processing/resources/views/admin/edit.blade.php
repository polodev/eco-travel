<x-admin-dashboard-layout::layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('visa-processing::admin.visa-processings.index') }}" 
                       class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Visa Processing</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $visaProcessing->english_title }}</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('visa-processing::admin.visa-processings.update', $visaProcessing) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Basic Information</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- English Title -->
                        <div>
                            <label for="english_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                English Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="english_title" id="english_title" 
                                   value="{{ old('english_title', $visaProcessing->english_title) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('english_title') border-red-500 @enderror"
                                   placeholder="e.g. Thailand Tourist Visa Requirements" required>
                            @error('english_title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Country & Visa Type -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Country <span class="text-red-500">*</span>
                                </label>
                                <select name="country" id="country" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('country') border-red-500 @enderror" required>
                                    <option value="">Select Country</option>
                                    @foreach(\Modules\VisaProcessing\Models\VisaProcessing::getCountries() as $key => $country)
                                        <option value="{{ $key }}" {{ old('country', $visaProcessing->country) == $key ? 'selected' : '' }}>{{ $country['flag'] }} {{ $country['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="visa_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Visa Type <span class="text-red-500">*</span>
                                </label>
                                <select name="visa_type" id="visa_type" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('visa_type') border-red-500 @enderror" required>
                                    <option value="">Select Visa Type</option>
                                    @foreach(\Modules\VisaProcessing\Models\VisaProcessing::getAvailableVisaTypes() as $key => $label)
                                        <option value="{{ $key }}" {{ old('visa_type', $visaProcessing->visa_type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('visa_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="visa_fees" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Visa Fees (BDT) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="visa_fees" id="visa_fees" step="0.01" min="0"
                                       value="{{ old('visa_fees', $visaProcessing->visa_fees) }}"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('visa_fees') border-red-500 @enderror"
                                       placeholder="5000" required>
                                @error('visa_fees')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="processing_fee" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Processing Fee (BDT)
                                </label>
                                <input type="number" name="processing_fee" id="processing_fee" step="0.01" min="0"
                                       value="{{ old('processing_fee', $visaProcessing->processing_fee) }}"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('processing_fee') border-red-500 @enderror"
                                       placeholder="500">
                                @error('processing_fee')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="difficulty_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Difficulty Level <span class="text-red-500">*</span>
                                </label>
                                <select name="difficulty_level" id="difficulty_level" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('difficulty_level') border-red-500 @enderror" required>
                                    @foreach(\Modules\VisaProcessing\Models\VisaProcessing::getAvailableDifficultyLevels() as $key => $label)
                                        <option value="{{ $key }}" {{ old('difficulty_level', $visaProcessing->difficulty_level) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('difficulty_level')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Processing Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="processing_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Processing Days
                                </label>
                                <input type="number" name="processing_days" id="processing_days" min="1"
                                       value="{{ old('processing_days', $visaProcessing->processing_days) }}"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('processing_days') border-red-500 @enderror"
                                       placeholder="7">
                                @error('processing_days')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="estimated_processing_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Estimated Processing Time (days)
                                </label>
                                <input type="number" name="estimated_processing_time" id="estimated_processing_time" min="1"
                                       value="{{ old('estimated_processing_time', $visaProcessing->estimated_processing_time) }}"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('estimated_processing_time') border-red-500 @enderror"
                                       placeholder="10">
                                @error('estimated_processing_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Options -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('status') border-red-500 @enderror" required>
                                    @foreach(\Modules\VisaProcessing\Models\VisaProcessing::getAvailableStatuses() as $key => $label)
                                        <option value="{{ $key }}" {{ old('status', $visaProcessing->status) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Position
                                </label>
                                <input type="number" name="position" id="position" min="0"
                                       value="{{ old('position', $visaProcessing->position) }}"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('position') border-red-500 @enderror"
                                       placeholder="0">
                                @error('position')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center pt-6">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                                           {{ old('is_featured', $visaProcessing->is_featured) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <label for="is_featured" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Featured
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Published At -->
                        <div>
                            <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Published At
                            </label>
                            <input type="datetime-local" name="published_at" id="published_at"
                                   value="{{ old('published_at', $visaProcessing->published_at ? $visaProcessing->published_at->format('Y-m-d\TH:i') : '') }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('published_at') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave empty to auto-set when status is published</p>
                            @error('published_at')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Translatable Content -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Content (Translatable)</h3>
                    </div>
                    <div class="p-6">
                        <!-- Language Tabs -->
                        <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                            <nav class="-mb-px flex space-x-8">
                                <button type="button" class="lang-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm active"
                                        data-lang="en">
                                    English
                                </button>
                                <button type="button" class="lang-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                                        data-lang="bn">
                                    বাংলা
                                </button>
                            </nav>
                        </div>

                        <!-- English Content -->
                        <div class="lang-content" data-lang="en">
                            <div class="space-y-6">
                                <div>
                                    <label for="title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Title (English) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="title[en]" id="title_en" 
                                           value="{{ old('title.en', $visaProcessing->getTranslation('title', 'en')) }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('title.en') border-red-500 @enderror"
                                           placeholder="Visa requirements title in English" required>
                                    @error('title.en')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="content_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Content (English) <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="content[en]" id="content_en" rows="15"
                                              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('content.en') border-red-500 @enderror"
                                              placeholder="Detailed visa requirements and procedures in English" required>{{ old('content.en', $visaProcessing->getTranslation('content', 'en')) }}</textarea>
                                    @error('content.en')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Bengali Content -->
                        <div class="lang-content hidden" data-lang="bn">
                            <div class="space-y-6">
                                <div>
                                    <label for="title_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Title (Bengali)
                                    </label>
                                    <input type="text" name="title[bn]" id="title_bn" 
                                           value="{{ old('title.bn', $visaProcessing->getTranslation('title', 'bn')) }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('title.bn') border-red-500 @enderror"
                                           placeholder="ভিসার প্রয়োজনীয়তার শিরোনাম বাংলায়">
                                    @error('title.bn')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="content_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Content (Bengali)
                                    </label>
                                    <textarea name="content[bn]" id="content_bn" rows="15"
                                              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('content.bn') border-red-500 @enderror"
                                              placeholder="বিস্তারিত ভিসার প্রয়োজনীয়তা এবং পদ্ধতি বাংলায়">{{ old('content.bn', $visaProcessing->getTranslation('content', 'bn')) }}</textarea>
                                    @error('content.bn')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Meta Data -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">SEO Meta Data (Optional)</h3>
                    </div>
                    <div class="p-6">
                        <!-- Language Tabs for SEO -->
                        <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                            <nav class="-mb-px flex space-x-8">
                                <button type="button" class="seo-lang-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm active"
                                        data-lang="en">
                                    English SEO
                                </button>
                                <button type="button" class="seo-lang-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                                        data-lang="bn">
                                    বাংলা SEO
                                </button>
                            </nav>
                        </div>

                        <!-- English SEO -->
                        <div class="seo-lang-content" data-lang="en">
                            <div class="space-y-4">
                                <div>
                                    <label for="meta_title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meta Title (English)</label>
                                    <input type="text" name="meta_title[en]" id="meta_title_en" 
                                           value="{{ old('meta_title.en', $visaProcessing->getTranslation('meta_title', 'en')) }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           placeholder="SEO optimized title">
                                </div>
                                <div>
                                    <label for="meta_description_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meta Description (English)</label>
                                    <textarea name="meta_description[en]" id="meta_description_en" rows="3"
                                              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                              placeholder="SEO meta description (150-160 characters)">{{ old('meta_description.en', $visaProcessing->getTranslation('meta_description', 'en')) }}</textarea>
                                </div>
                                <div>
                                    <label for="keywords_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Keywords (English)</label>
                                    <input type="text" name="keywords[en]" id="keywords_en" 
                                           value="{{ old('keywords.en', $visaProcessing->getTranslation('keywords', 'en')) }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           placeholder="keyword1, keyword2, keyword3">
                                </div>
                            </div>
                        </div>

                        <!-- Bengali SEO -->
                        <div class="seo-lang-content hidden" data-lang="bn">
                            <div class="space-y-4">
                                <div>
                                    <label for="meta_title_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meta Title (Bengali)</label>
                                    <input type="text" name="meta_title[bn]" id="meta_title_bn" 
                                           value="{{ old('meta_title.bn', $visaProcessing->getTranslation('meta_title', 'bn')) }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           placeholder="SEO অপ্টিমাইজড শিরোনাম">
                                </div>
                                <div>
                                    <label for="meta_description_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meta Description (Bengali)</label>
                                    <textarea name="meta_description[bn]" id="meta_description_bn" rows="3"
                                              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                              placeholder="SEO মেটা বিবরণ (150-160 অক্ষর)">{{ old('meta_description.bn', $visaProcessing->getTranslation('meta_description', 'bn')) }}</textarea>
                                </div>
                                <div>
                                    <label for="keywords_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Keywords (Bengali)</label>
                                    <input type="text" name="keywords[bn]" id="keywords_bn" 
                                           value="{{ old('keywords.bn', $visaProcessing->getTranslation('keywords', 'bn')) }}"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           placeholder="কীওয়ার্ড১, কীওয়ার্ড২, কীওয়ার্ড৩">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('visa-processing::admin.visa-processings.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Visa Processing
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Language tab switching for content
            $('.lang-tab').on('click', function() {
                const lang = $(this).data('lang');
                
                // Update tab styles
                $('.lang-tab').removeClass('border-blue-500 text-blue-600').addClass('border-transparent text-gray-500');
                $(this).removeClass('border-transparent text-gray-500').addClass('border-blue-500 text-blue-600');
                
                // Show/hide content
                $('.lang-content').addClass('hidden');
                $(`.lang-content[data-lang="${lang}"]`).removeClass('hidden');
            });

            // Language tab switching for SEO
            $('.seo-lang-tab').on('click', function() {
                const lang = $(this).data('lang');
                
                // Update tab styles
                $('.seo-lang-tab').removeClass('border-blue-500 text-blue-600').addClass('border-transparent text-gray-500');
                $(this).removeClass('border-transparent text-gray-500').addClass('border-blue-500 text-blue-600');
                
                // Show/hide content
                $('.seo-lang-content').addClass('hidden');
                $(`.seo-lang-content[data-lang="${lang}"]`).removeClass('hidden');
            });

        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>