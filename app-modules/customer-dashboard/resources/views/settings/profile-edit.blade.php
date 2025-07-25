<x-customer-account-layout::layout>
    <!-- Breadcrumbs -->
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('accounts.index') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('accounts.settings.profile') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.profile') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('messages.edit') }}</span>
    </div>

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('messages.edit_profile') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.update_name_only') }}</p>
    </div>

    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar Navigation -->
            @include('customer-dashboard::settings.partials.navigation')

            <!-- Profile Content -->
            <div class="flex-1">
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                    <div class="p-6">
                        <!-- Profile Form -->
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                                {{ __('messages.profile_information') }}
                            </h2>
                            <a href="{{ route('accounts.settings.profile') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('messages.cancel') }}
                            </a>
                        </div>

                        <form class="max-w-md mb-10" action="{{ route('accounts.settings.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <x-forms.input :label="__('messages.name')" name="name" type="text"
                                    value="{{ old('name', $user->name) }}" />
                            </div>





                            <div>
                                <x-button type="primary">{{ __('messages.save') }}</x-button>
                            </div>
                        </form>

                        <!-- Delete Account Section -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-1">
                                {{ __('messages.delete_account') }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                {{ __('messages.delete_account_resources') }}
                            </p>
                            <form action="{{ route('accounts.settings.profile.destroy') }}" method="POST"
                                onsubmit="return confirm('{{ __('messages.are_you_sure_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <x-button type="danger">{{ __('messages.delete_account') }}</x-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-account-layout::layout>