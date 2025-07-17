<x-customer-frontend-layout::layout>
    <div class="max-w-md mx-auto">
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('messages.register') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ __('messages.enter_details_to_create') }}
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                <!-- Full Name Input -->
                <div class="mb-4">
                    <x-forms.input :label="__('messages.full_name')" name="name" type="text" :placeholder="__('messages.full_name')" />
                </div>

                <!-- Email Input -->
                <div class="mb-4">
                    <x-forms.input :label="__('messages.email')" name="email" type="email" placeholder="your@email.com" />
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <x-forms.password-input :label="__('messages.password')" name="password" placeholder="••••••••" />
                </div>

                <!-- Confirm Password Input -->
                <div class="mb-4">
                    <x-forms.password-input :label="__('messages.confirm_password')" name="password_confirmation" placeholder="••••••••" />
                </div>

                <!-- reCAPTCHA Token -->
                <input type="hidden" name="recaptcha_token" id="recaptchaToken">

                <!-- Register Button -->
                <x-button type="primary" class="w-full">{{ __('messages.create_account') }}</x-button>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('messages.have_account') }}
                    <a href="{{ route('login') }}"
                        class="text-blue-600 dark:text-blue-400 hover:underline font-medium">{{ __('messages.sign_in') }}</a>
                </p>
            </div>
        </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptcha.site_key') }}"></script>
        <script>
            document.getElementById('registerForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                grecaptcha.ready(function() {
                    grecaptcha.execute('{{ config('recaptcha.site_key') }}', {action: 'register'}).then(function(token) {
                        document.getElementById('recaptchaToken').value = token;
                        document.getElementById('registerForm').submit();
                    });
                });
            });
        </script>
    @endpush
</x-customer-frontend-layout::layout>
