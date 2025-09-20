<x-admin-dashboard-layout::layout>
    <x-slot name="title">Visa Application #{{ $visaApplication->application_number }}</x-slot>
    
    <div class="container mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Application #{{ $visaApplication->application_number }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Submitted on {{ $visaApplication->submission_date->format('F d, Y \a\t H:i') }}
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('visa-processing::admin.visa-applications.edit', $visaApplication) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                    Update Status
                </a>
                <a href="{{ route('visa-processing::admin.visa-applications.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Application Status -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Application Status</h3>
                    <div class="flex items-center justify-between">
                        <div>
                            {!! $visaApplication->status_badge !!}
                        </div>
                        @if($visaApplication->reviewed_by && $visaApplication->reviewer)
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Reviewed by {{ $visaApplication->reviewer->name }} 
                            {{ $visaApplication->reviewed_at->diffForHumans() }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Applicant Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Applicant Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                            <p class="text-gray-900 dark:text-white">{{ $visaApplication->applicant_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <p class="text-gray-900 dark:text-white">{{ $visaApplication->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mobile</label>
                            <p class="text-gray-900 dark:text-white">{{ $visaApplication->mobile }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Passport Number</label>
                            <p class="text-gray-900 dark:text-white">{{ $visaApplication->passport_number ?: 'Not provided' }}</p>
                        </div>
                        @if($visaApplication->travel_date)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Intended Travel Date</label>
                            <p class="text-gray-900 dark:text-white">{{ $visaApplication->travel_date->format('F d, Y') }}</p>
                        </div>
                        @endif
                    </div>
                    
                    @if($visaApplication->customer_notes)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer Notes</label>
                        <p class="text-gray-900 dark:text-white mt-1">{{ $visaApplication->customer_notes }}</p>
                    </div>
                    @endif
                </div>

                <!-- Visa Processing Details -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Visa Processing Details</h3>
                    <div class="flex items-start space-x-4">
                        <span class="text-3xl">{{ $visaApplication->visaProcessing->country_flag }}</span>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 dark:text-white">
                                {{ $visaApplication->visaProcessing->getTranslation('title', 'en') }}
                            </h4>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ $visaApplication->visaProcessing->country_name }} • 
                                {{ ucfirst($visaApplication->visaProcessing->visa_type) }} Visa
                            </p>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Processing Days</span>
                                    <p class="font-medium">{{ $visaApplication->visaProcessing->processing_days ?? 'TBA' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Total Price</span>
                                    <p class="font-medium text-green-600">{{ $visaApplication->visaProcessing->formatted_price }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Uploaded Documents -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Uploaded Documents 
                        <span class="text-sm font-normal text-gray-600 dark:text-gray-400">
                            ({{ $visaApplication->uploaded_documents_count }}/{{ $visaApplication->total_documents_count }})
                        </span>
                    </h3>
                    <div class="space-y-4">
                        @foreach($documents as $type => $document)
                        <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-600 rounded-lg">
                            <div class="flex items-center space-x-3">
                                @if($document['uploaded'])
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                                <span class="font-medium text-gray-900 dark:text-white">{{ $document['label'] }}</span>
                            </div>
                            @if($document['uploaded'])
                            <div class="flex space-x-2">
                                <a href="{{ $document['download_url'] }}" 
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">
                                    Download
                                </a>
                                @if(in_array($document['media']->mime_type, ['image/jpeg', 'image/png', 'image/jpg']))
                                <button onclick="viewDocument('{{ $document['url'] }}', '{{ $document['label'] }}')" 
                                        class="text-green-600 hover:text-green-800 dark:text-green-400 text-sm font-medium">
                                    View
                                </button>
                                @endif
                            </div>
                            @else
                            <span class="text-sm text-gray-500 dark:text-gray-400">Not uploaded</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Admin Notes -->
                @if($visaApplication->admin_notes)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Admin Notes</h3>
                    <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $visaApplication->admin_notes }}</p>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Payment Information -->
                @if($visaApplication->payment)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Payment Information</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Status</span>
                            <div class="mt-1">{!! $visaApplication->payment->status_badge !!}</div>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Amount</span>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $visaApplication->payment->formatted_amount }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Payment Method</span>
                            <div class="mt-1">{!! $visaApplication->payment->payment_method_badge !!}</div>
                        </div>
                        @if($visaApplication->payment->transaction_id)
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Transaction ID</span>
                            <p class="font-mono text-sm text-gray-900 dark:text-white">{{ $visaApplication->payment->transaction_id }}</p>
                        </div>
                        @endif
                        <div class="pt-3">
                            <a href="{{ route('payment::admin.payments.show', $visaApplication->payment) }}" 
                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">
                                View Payment Details →
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Application Timeline -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Timeline</h3>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Application Submitted</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $visaApplication->submission_date->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        @if($visaApplication->reviewed_at)
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Application Reviewed</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $visaApplication->reviewed_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                        @if($visaApplication->completion_date)
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-gray-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Application Completed</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $visaApplication->completion_date->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('visa-processing::admin.visa-applications.edit', $visaApplication) }}" 
                           class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                            Update Status
                        </a>
                        <a href="mailto:{{ $visaApplication->email }}" 
                           class="block w-full text-center bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                            Email Applicant
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Document View Modal -->
    <div id="document-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg max-w-4xl max-h-[90vh] w-full flex flex-col">
            <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700">
                <h3 id="document-title" class="text-lg font-semibold text-gray-900 dark:text-white"></h3>
                <button onclick="closeDocumentModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="flex-1 overflow-hidden">
                <img id="document-image" src="" alt="" class="w-full h-full object-contain">
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function viewDocument(url, title) {
            document.getElementById('document-title').textContent = title;
            document.getElementById('document-image').src = url;
            document.getElementById('document-modal').classList.remove('hidden');
        }

        function closeDocumentModal() {
            document.getElementById('document-modal').classList.add('hidden');
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDocumentModal();
            }
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>