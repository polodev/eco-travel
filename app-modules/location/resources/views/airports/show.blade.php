<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">

        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $airport->name }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {{ $airport->city->name }}, {{ $airport->country->name }}
                </p>
            </div>

            <div class="flex space-x-3">
                <a href="{{ route('location::admin.airports.edit', $airport) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700">
                    Edit
                </a>
                <a href="{{ route('location::admin.airports.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Airport Details -->
            <div class="md:col-span-2">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Airport Details</h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">IATA Code</dt>
                            <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100 bg-gray-200 dark:bg-gray-600 px-2 py-1 rounded">{{ $airport->iata_code }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ICAO Code</dt>
                            <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100 bg-gray-200 dark:bg-gray-600 px-2 py-1 rounded">{{ $airport->icao_code }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{!! $airport->type_badge !!}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{!! $airport->status_badge !!}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Location Details -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Location</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Coordinates</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $airport->latitude }}, {{ $airport->longitude }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Timezone</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $airport->timezone }}</dd>
                    </div>
                </dl>
            </div>
        </div>

    </div>
</x-admin-dashboard-layout::layout>
