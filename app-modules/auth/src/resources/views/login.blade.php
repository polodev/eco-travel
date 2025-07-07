<x-customer-frontend-layout::layout :title="__('messages.login')">
    <!-- Login Card -->
    <div class="max-w-md mx-auto">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('messages.login') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.sign_in_to_account') }}</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Input -->
                <div class="mb-4">
                    <x-forms.input :label="__('messages.email')" name="email" type="email" placeholder="your@email.com" />
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <x-forms.password-input :label="__('messages.password')" name="password" placeholder="••••••••" />
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-xs text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.forgot_password') }}</a>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="mb-6">
                    <x-forms.checkbox :label="__('messages.remember_me')" name="remember" />
                </div>

                <!-- Login Button -->
                <x-button type="primary" class="w-full">{{ __('messages.sign_in') }}</x-button>
            </form>

            @if (Route::has('register'))
                <!-- Register Link -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('messages.dont_have_account') }}
                        <a href="{{ route('register') }}"
                            class="text-blue-600 dark:text-blue-400 hover:underline font-medium">{{ __('messages.sign_up') }}</a>
                    </p>
                </div>
            @endif
        </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>
