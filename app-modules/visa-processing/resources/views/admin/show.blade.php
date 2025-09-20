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
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $visaProcessing->english_title }}</h1>
                        <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                            <span>{{ $visaProcessing->country_flag }} {{ $visaProcessing->country_name }}</span>
                            <span>•</span>
                            <span>{{ ucfirst($visaProcessing->visa_type) }} Visa</span>
                            <span>•</span>
                            <span>{{ $visaProcessing->formatted_total_price }}</span>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('visa-processing::admin.visa-processings.edit', $visaProcessing) }}" 
                           class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                        <a href="{{ route('visa-processing::visa-processings.show', $visaProcessing) }}" 
                           target="_blank"
                           class="inline-flex items-center px-3 py-2 bg-purple-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-purple-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            View in Frontend
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Basic Information</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Country</label>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-2xl">{{ $visaProcessing->country_flag }}</span>
                                        <span class="text-lg font-medium text-gray-900 dark:text-white">{{ $visaProcessing->country_name }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">({{ $visaProcessing->country_code }})</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Visa Type</label>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                        {{ ucfirst($visaProcessing->visa_type) }} Visa
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                    <div>{!! $visaProcessing->status_badge !!}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Difficulty Level</label>
                                    <div>{!! $visaProcessing->difficulty_badge !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Details -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Pricing</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Base Price</label>
                                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $visaProcessing->formatted_price }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Processing Fee</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">৳ {{ number_format($visaProcessing->processing_fee, 0) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Price</label>
                                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $visaProcessing->formatted_total_price }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Content</h3>
                                <div class="flex space-x-2">
                                    <button type="button" class="content-lang-btn px-3 py-1 text-sm font-medium rounded-md bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-200 active" data-lang="en">English</button>
                                    <button type="button" class="content-lang-btn px-3 py-1 text-sm font-medium rounded-md bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300" data-lang="bn">বাংলা</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- English Content -->
                        <div class="content-lang-panel p-6" data-lang="en">
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Title (English)</h4>
                                    <p class="text-gray-700 dark:text-gray-300">{{ $visaProcessing->getTranslation('title', 'en') ?: 'Not provided' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Content (English)</h4>
                                    <div class="prose dark:prose-invert max-w-none">
                                        @if($visaProcessing->getTranslation('content', 'en'))
                                            {!! nl2br(e($visaProcessing->getTranslation('content', 'en'))) !!}
                                        @else
                                            <p class="text-gray-500 italic">No English content provided</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bengali Content -->
                        <div class="content-lang-panel p-6 hidden" data-lang="bn">
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Title (Bengali)</h4>
                                    <p class="text-gray-700 dark:text-gray-300">{{ $visaProcessing->getTranslation('title', 'bn') ?: 'প্রদান করা হয়নি' }}</p>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Content (Bengali)</h4>
                                    <div class="prose dark:prose-invert max-w-none">
                                        @if($visaProcessing->getTranslation('content', 'bn'))
                                            {!! nl2br(e($visaProcessing->getTranslation('content', 'bn'))) !!}
                                        @else
                                            <p class="text-gray-500 italic">কোন বাংলা কন্টেন্ট প্রদান করা হয়নি</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Information -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">SEO Information</h3>
                                <div class="flex space-x-2">
                                    <button type="button" class="seo-lang-btn px-3 py-1 text-sm font-medium rounded-md bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-200 active" data-lang="en">English</button>
                                    <button type="button" class="seo-lang-btn px-3 py-1 text-sm font-medium rounded-md bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300" data-lang="bn">বাংলা</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- English SEO -->
                        <div class="seo-lang-panel p-6" data-lang="en">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Meta Title</label>
                                    <p class="text-gray-900 dark:text-white">{{ $visaProcessing->getTranslation('meta_title', 'en') ?: 'Not set' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Meta Description</label>
                                    <p class="text-gray-900 dark:text-white">{{ $visaProcessing->getTranslation('meta_description', 'en') ?: 'Not set' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Keywords</label>
                                    <p class="text-gray-900 dark:text-white">{{ $visaProcessing->getTranslation('keywords', 'en') ?: 'Not set' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Bengali SEO -->
                        <div class="seo-lang-panel p-6 hidden" data-lang="bn">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Meta Title</label>
                                    <p class="text-gray-900 dark:text-white">{{ $visaProcessing->getTranslation('meta_title', 'bn') ?: 'সেট করা হয়নি' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Meta Description</label>
                                    <p class="text-gray-900 dark:text-white">{{ $visaProcessing->getTranslation('meta_description', 'bn') ?: 'সেট করা হয়নি' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Keywords</label>
                                    <p class="text-gray-900 dark:text-white">{{ $visaProcessing->getTranslation('keywords', 'bn') ?: 'সেট করা হয়নি' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Stats -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Details</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Slug:</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $visaProcessing->slug }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Position:</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $visaProcessing->position }}</span>
                            </div>
                            @if($visaProcessing->processing_days)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Processing Days:</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $visaProcessing->processing_days }} days</span>
                                </div>
                            @endif
                            @if($visaProcessing->estimated_processing_time)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Est. Processing:</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $visaProcessing->estimated_processing_time }} days</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Featured:</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    @if($visaProcessing->is_featured)
                                        <span class="text-green-600 dark:text-green-400">Yes</span>
                                    @else
                                        <span class="text-gray-500">No</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Created:</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $visaProcessing->created_at->format('M d, Y') }}</span>
                            </div>
                            @if($visaProcessing->published_at)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Published:</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $visaProcessing->published_at->format('M d, Y g:i A') }}</span>
                                </div>
                            @endif
                            @if($visaProcessing->user)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Author:</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $visaProcessing->user->name }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Stats -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Payment Statistics</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            @php
                                $totalPayments = $visaProcessing->payments()->count();
                                $completedPayments = $visaProcessing->payments()->where('status', 'completed')->count();
                                $pendingPayments = $visaProcessing->payments()->where('status', 'pending')->count();
                                $totalRevenue = $visaProcessing->payments()->where('status', 'completed')->sum('amount');
                            @endphp
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Total Orders:</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $totalPayments }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Completed:</span>
                                <span class="text-sm font-medium text-green-600 dark:text-green-400">{{ $completedPayments }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Pending:</span>
                                <span class="text-sm font-medium text-yellow-600 dark:text-yellow-400">{{ $pendingPayments }}</span>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 dark:border-gray-600 pt-4">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Total Revenue:</span>
                                <span class="text-sm font-bold text-green-600 dark:text-green-400">৳ {{ number_format($totalRevenue, 0) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Quick Actions</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('visa-processing::admin.visa-processings.edit', $visaProcessing) }}" 
                               class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Visa Processing
                            </a>
                            
                            @if($visaProcessing->isLive())
                                <a href="{{ route('visa-processing::visa-processings.show', $visaProcessing->slug) }}" 
                                   target="_blank"
                                   class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    View on Website
                                </a>
                            @endif

                            <button onclick="deleteRecord({{ $visaProcessing->id }})" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Content language switching
            $('.content-lang-btn').on('click', function() {
                const lang = $(this).data('lang');
                
                // Update button styles
                $('.content-lang-btn').removeClass('bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-200').addClass('bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300');
                $(this).removeClass('bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300').addClass('bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-200');
                
                // Show/hide content panels
                $('.content-lang-panel').addClass('hidden');
                $(`.content-lang-panel[data-lang="${lang}"]`).removeClass('hidden');
            });

            // SEO language switching
            $('.seo-lang-btn').on('click', function() {
                const lang = $(this).data('lang');
                
                // Update button styles
                $('.seo-lang-btn').removeClass('bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-200').addClass('bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300');
                $(this).removeClass('bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300').addClass('bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-200');
                
                // Show/hide SEO panels
                $('.seo-lang-panel').addClass('hidden');
                $(`.seo-lang-panel[data-lang="${lang}"]`).removeClass('hidden');
            });

            // Delete function
            window.deleteRecord = function(id) {
                if (confirm('Are you sure you want to delete this visa processing? This action cannot be undone.')) {
                    $.ajax({
                        url: `/admin-dashboard/visa-processings/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                window.location.href = '{{ route("visa-processing::admin.visa-processings.index") }}';
                            } else {
                                alert(response.message || 'Failed to delete visa processing.');
                            }
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            alert(response?.message || 'An error occurred while deleting the visa processing.');
                        }
                    });
                }
            };
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>