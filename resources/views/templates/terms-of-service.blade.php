<x-customer-frontend-layout::layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                {{ $page->getTranslation('title', app()->getLocale()) }}
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                Last updated: {{ $page->updated_at->format('F d, Y') }}
            </p>
        </div>

        <!-- Content Section -->
        <div class="prose prose-lg max-w-none dark:prose-invert">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 border border-gray-200 dark:border-gray-700">
                <!-- Agreement Introduction -->
                <div class="mb-8 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border-l-4 border-blue-500">
                    <h2 class="text-xl font-semibold text-blue-900 dark:text-blue-100 mb-2">Agreement to Terms</h2>
                    <p class="text-blue-800 dark:text-blue-200">
                        By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement.
                    </p>
                </div>

                <!-- Page Content -->
                <div class="space-y-6">
                    {!! nl2br(e($page->getTranslation('content', app()->getLocale()))) !!}
                </div>

                <!-- Contact Information -->
                <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Contact Information</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <p class="text-gray-700 dark:text-gray-300">
                            If you have any questions about these Terms of Service, please contact us at:
                        </p>
                        <div class="mt-4 space-y-2">
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>Email:</strong> info@ecotravelsonline.com.bd
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>Phone:</strong> +8809647668822
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>Address:</strong> House 3, Road 16, Sector 11, Uttara, Dhaka - 1230, Bangladesh
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>