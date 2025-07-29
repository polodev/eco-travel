<x-customer-frontend-layout::layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                {{ $page->getTranslation('title', app()->getLocale()) }}
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                Effective date: {{ $page->published_at ? $page->published_at->format('F d, Y') : $page->created_at->format('F d, Y') }}
            </p>
        </div>

        <!-- Content Section -->
        <div class="prose prose-lg max-w-none dark:prose-invert">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 border border-gray-200 dark:border-gray-700">
                <!-- Privacy Notice -->
                <div class="mb-8 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border-l-4 border-green-500">
                    <h2 class="text-xl font-semibold text-green-900 dark:text-green-100 mb-2">Your Privacy Matters</h2>
                    <p class="text-green-800 dark:text-green-200">
                        We are committed to protecting your privacy and ensuring the security of your personal information.
                    </p>
                </div>

                <!-- Information Collection Section -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Information We Collect
                    </h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                            <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Personal Information</h4>
                            <ul class="text-blue-800 dark:text-blue-200 text-sm space-y-1">
                                <li>• Name and contact details</li>
                                <li>• Email addresses</li>
                                <li>• Phone numbers</li>
                                <li>• Billing information</li>
                            </ul>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                            <h4 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">Usage Information</h4>
                            <ul class="text-purple-800 dark:text-purple-200 text-sm space-y-1">
                                <li>• Website interactions</li>
                                <li>• IP addresses</li>
                                <li>• Browser information</li>
                                <li>• Device data</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                <div class="space-y-6">
                    {!! nl2br(e($page->getTranslation('content', app()->getLocale()))) !!}
                </div>

                <!-- Data Rights Section -->
                <div class="mt-8 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Your Rights
                    </h3>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">Access</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">View your data</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-800 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"></path>
                                </svg>
                            </div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">Correct</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Update your data</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-red-100 dark:bg-red-800 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"></path>
                                </svg>
                            </div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100">Delete</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Remove your data</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Privacy Contact</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <p class="text-gray-700 dark:text-gray-300 mb-4">
                            If you have questions about this Privacy Policy or our data practices, contact our Data Protection Officer:
                        </p>
                        <div class="space-y-2">
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>Email:</strong> privacy@yourcompany.com
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>Phone:</strong> +1 (555) 123-4567
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>Address:</strong> 123 Privacy St, Data City, DC 12345
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>