<x-admin-dashboard-layout::layout>
    <x-slot name="title">Update Application #{{ $visaApplication->application_number }}</x-slot>
    
    <div class="container mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Update Application #{{ $visaApplication->application_number }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Change application status and add administrative notes
                </p>
            </div>
            <a href="{{ route('visa-processing::admin.visa-applications.show', $visaApplication) }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                Back to Application
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Update Application Status</h3>
                    
                    @if ($errors->any())
                        <div class="bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                            <div class="flex">
                                <svg class="w-5 h-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                        There were errors with your submission
                                    </h3>
                                    <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('visa-processing::admin.visa-applications.update', $visaApplication) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Current Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Current Status
                            </label>
                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                {!! $visaApplication->status_badge !!}
                            </div>
                        </div>

                        <!-- New Status -->
                        <div>
                            <label for="application_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                New Status <span class="text-red-500">*</span>
                            </label>
                            <select name="application_status" id="application_status" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                @foreach($availableStatuses as $value => $label)
                                    <option value="{{ $value }}" {{ old('application_status', $visaApplication->application_status) === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Admin Notes -->
                        <div>
                            <label for="admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Administrative Notes
                            </label>
                            <textarea name="admin_notes" id="admin_notes" rows="8" 
                                      placeholder="Add notes about this application, status changes, or requirements..."
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">{{ old('admin_notes', $visaApplication->admin_notes) }}</textarea>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                These notes are for internal use and will not be visible to the applicant.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('visa-processing::admin.visa-applications.show', $visaApplication) }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition duration-200">
                                Update Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Application Summary -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Application Summary</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Application Number</span>
                            <p class="font-mono text-sm font-medium text-gray-900 dark:text-white">{{ $visaApplication->application_number }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Applicant</span>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $visaApplication->applicant_name }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $visaApplication->email }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Visa Type</span>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="text-lg">{{ $visaApplication->visaProcessing->country_flag }}</span>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $visaApplication->visaProcessing->country_name }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ ucfirst($visaApplication->visaProcessing->visa_type) }} Visa</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Submitted</span>
                            <p class="text-sm text-gray-900 dark:text-white">{{ $visaApplication->submission_date->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Documents Uploaded</span>
                            <p class="text-sm text-gray-900 dark:text-white">{{ $visaApplication->uploaded_documents_count }}/{{ $visaApplication->total_documents_count }}</p>
                        </div>
                    </div>
                </div>

                <!-- Status Descriptions -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Status Descriptions</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="font-medium text-yellow-600">Pending:</span>
                            <span class="text-gray-600 dark:text-gray-400">Application submitted, awaiting review</span>
                        </div>
                        <div>
                            <span class="font-medium text-blue-600">Under Review:</span>
                            <span class="text-gray-600 dark:text-gray-400">Application is being processed</span>
                        </div>
                        <div>
                            <span class="font-medium text-purple-600">Documents Requested:</span>
                            <span class="text-gray-600 dark:text-gray-400">Additional documents needed</span>
                        </div>
                        <div>
                            <span class="font-medium text-green-600">Approved:</span>
                            <span class="text-gray-600 dark:text-gray-400">Application approved, processing</span>
                        </div>
                        <div>
                            <span class="font-medium text-red-600">Rejected:</span>
                            <span class="text-gray-600 dark:text-gray-400">Application declined</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-600">Completed:</span>
                            <span class="text-gray-600 dark:text-gray-400">Visa processing completed</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Status -->
                @if($visaApplication->payment)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Payment Status</h3>
                    <div class="space-y-2">
                        <div>{!! $visaApplication->payment->status_badge !!}</div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $visaApplication->payment->formatted_amount }}</p>
                        <a href="{{ route('payment::admin.payments.show', $visaApplication->payment) }}" 
                           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium">
                            View Payment Details →
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>