<x-customer-account-layout::layout>
    <!-- Breadcrumbs -->
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('customer-dashboard.index') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('settings.profile') }}"
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
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.update_name_email') }}</p>
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
                            <a href="{{ route('settings.profile') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('messages.cancel') }}
                            </a>
                        </div>

                        <form class="max-w-md mb-10" action="{{ route('settings.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <x-forms.input :label="__('messages.name')" name="name" type="text"
                                    value="{{ old('name', $user->name) }}" />
                            </div>

                            <div class="mb-4">
                                <x-forms.input :label="__('messages.email')" name="email" type="email"
                                    value="{{ old('email', $user->email) }}" />
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.country') }}
                                </label>
                                <select name="country" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                                    <option value="">{{ __('messages.select_country') }}</option>
                                    <option value="Afghanistan" {{ old('country', $user->country) == 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
                                    <option value="Albania" {{ old('country', $user->country) == 'Albania' ? 'selected' : '' }}>Albania</option>
                                    <option value="Algeria" {{ old('country', $user->country) == 'Algeria' ? 'selected' : '' }}>Algeria</option>
                                    <option value="Argentina" {{ old('country', $user->country) == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                                    <option value="Australia" {{ old('country', $user->country) == 'Australia' ? 'selected' : '' }}>Australia</option>
                                    <option value="Austria" {{ old('country', $user->country) == 'Austria' ? 'selected' : '' }}>Austria</option>
                                    <option value="Bangladesh" {{ old('country', $user->country) == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                    <option value="Belgium" {{ old('country', $user->country) == 'Belgium' ? 'selected' : '' }}>Belgium</option>
                                    <option value="Brazil" {{ old('country', $user->country) == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                    <option value="Canada" {{ old('country', $user->country) == 'Canada' ? 'selected' : '' }}>Canada</option>
                                    <option value="China" {{ old('country', $user->country) == 'China' ? 'selected' : '' }}>China</option>
                                    <option value="Denmark" {{ old('country', $user->country) == 'Denmark' ? 'selected' : '' }}>Denmark</option>
                                    <option value="Egypt" {{ old('country', $user->country) == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                                    <option value="Finland" {{ old('country', $user->country) == 'Finland' ? 'selected' : '' }}>Finland</option>
                                    <option value="France" {{ old('country', $user->country) == 'France' ? 'selected' : '' }}>France</option>
                                    <option value="Germany" {{ old('country', $user->country) == 'Germany' ? 'selected' : '' }}>Germany</option>
                                    <option value="Greece" {{ old('country', $user->country) == 'Greece' ? 'selected' : '' }}>Greece</option>
                                    <option value="India" {{ old('country', $user->country) == 'India' ? 'selected' : '' }}>India</option>
                                    <option value="Indonesia" {{ old('country', $user->country) == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                    <option value="Iran" {{ old('country', $user->country) == 'Iran' ? 'selected' : '' }}>Iran</option>
                                    <option value="Iraq" {{ old('country', $user->country) == 'Iraq' ? 'selected' : '' }}>Iraq</option>
                                    <option value="Ireland" {{ old('country', $user->country) == 'Ireland' ? 'selected' : '' }}>Ireland</option>
                                    <option value="Israel" {{ old('country', $user->country) == 'Israel' ? 'selected' : '' }}>Israel</option>
                                    <option value="Italy" {{ old('country', $user->country) == 'Italy' ? 'selected' : '' }}>Italy</option>
                                    <option value="Japan" {{ old('country', $user->country) == 'Japan' ? 'selected' : '' }}>Japan</option>
                                    <option value="Jordan" {{ old('country', $user->country) == 'Jordan' ? 'selected' : '' }}>Jordan</option>
                                    <option value="Kenya" {{ old('country', $user->country) == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                                    <option value="Kuwait" {{ old('country', $user->country) == 'Kuwait' ? 'selected' : '' }}>Kuwait</option>
                                    <option value="Lebanon" {{ old('country', $user->country) == 'Lebanon' ? 'selected' : '' }}>Lebanon</option>
                                    <option value="Malaysia" {{ old('country', $user->country) == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                                    <option value="Mexico" {{ old('country', $user->country) == 'Mexico' ? 'selected' : '' }}>Mexico</option>
                                    <option value="Morocco" {{ old('country', $user->country) == 'Morocco' ? 'selected' : '' }}>Morocco</option>
                                    <option value="Netherlands" {{ old('country', $user->country) == 'Netherlands' ? 'selected' : '' }}>Netherlands</option>
                                    <option value="New Zealand" {{ old('country', $user->country) == 'New Zealand' ? 'selected' : '' }}>New Zealand</option>
                                    <option value="Nigeria" {{ old('country', $user->country) == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                                    <option value="Norway" {{ old('country', $user->country) == 'Norway' ? 'selected' : '' }}>Norway</option>
                                    <option value="Pakistan" {{ old('country', $user->country) == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                    <option value="Philippines" {{ old('country', $user->country) == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                                    <option value="Poland" {{ old('country', $user->country) == 'Poland' ? 'selected' : '' }}>Poland</option>
                                    <option value="Portugal" {{ old('country', $user->country) == 'Portugal' ? 'selected' : '' }}>Portugal</option>
                                    <option value="Qatar" {{ old('country', $user->country) == 'Qatar' ? 'selected' : '' }}>Qatar</option>
                                    <option value="Russia" {{ old('country', $user->country) == 'Russia' ? 'selected' : '' }}>Russia</option>
                                    <option value="Saudi Arabia" {{ old('country', $user->country) == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                                    <option value="Singapore" {{ old('country', $user->country) == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                    <option value="South Africa" {{ old('country', $user->country) == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                    <option value="South Korea" {{ old('country', $user->country) == 'South Korea' ? 'selected' : '' }}>South Korea</option>
                                    <option value="Spain" {{ old('country', $user->country) == 'Spain' ? 'selected' : '' }}>Spain</option>
                                    <option value="Sri Lanka" {{ old('country', $user->country) == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                                    <option value="Sweden" {{ old('country', $user->country) == 'Sweden' ? 'selected' : '' }}>Sweden</option>
                                    <option value="Switzerland" {{ old('country', $user->country) == 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
                                    <option value="Thailand" {{ old('country', $user->country) == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                                    <option value="Turkey" {{ old('country', $user->country) == 'Turkey' ? 'selected' : '' }}>Turkey</option>
                                    <option value="Ukraine" {{ old('country', $user->country) == 'Ukraine' ? 'selected' : '' }}>Ukraine</option>
                                    <option value="United Arab Emirates" {{ old('country', $user->country) == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                                    <option value="United Kingdom" {{ old('country', $user->country) == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="United States" {{ old('country', $user->country) == 'United States' ? 'selected' : '' }}>United States</option>
                                    <option value="Vietnam" {{ old('country', $user->country) == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
                                </select>
                                @error('country')
                                    <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.country_code') }}
                                </label>
                                <select name="country_code" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                                    <option value="">{{ __('messages.select_country_code') }}</option>
                                    <option value="+1" {{ old('country_code', $user->country_code) == '+1' ? 'selected' : '' }}>+1 (US/Canada)</option>
                                    <option value="+44" {{ old('country_code', $user->country_code) == '+44' ? 'selected' : '' }}>+44 (UK)</option>
                                    <option value="+33" {{ old('country_code', $user->country_code) == '+33' ? 'selected' : '' }}>+33 (France)</option>
                                    <option value="+49" {{ old('country_code', $user->country_code) == '+49' ? 'selected' : '' }}>+49 (Germany)</option>
                                    <option value="+39" {{ old('country_code', $user->country_code) == '+39' ? 'selected' : '' }}>+39 (Italy)</option>
                                    <option value="+34" {{ old('country_code', $user->country_code) == '+34' ? 'selected' : '' }}>+34 (Spain)</option>
                                    <option value="+91" {{ old('country_code', $user->country_code) == '+91' ? 'selected' : '' }}>+91 (India)</option>
                                    <option value="+880" {{ old('country_code', $user->country_code) == '+880' ? 'selected' : '' }}>+880 (Bangladesh)</option>
                                    <option value="+92" {{ old('country_code', $user->country_code) == '+92' ? 'selected' : '' }}>+92 (Pakistan)</option>
                                    <option value="+86" {{ old('country_code', $user->country_code) == '+86' ? 'selected' : '' }}>+86 (China)</option>
                                    <option value="+81" {{ old('country_code', $user->country_code) == '+81' ? 'selected' : '' }}>+81 (Japan)</option>
                                    <option value="+82" {{ old('country_code', $user->country_code) == '+82' ? 'selected' : '' }}>+82 (South Korea)</option>
                                    <option value="+61" {{ old('country_code', $user->country_code) == '+61' ? 'selected' : '' }}>+61 (Australia)</option>
                                    <option value="+65" {{ old('country_code', $user->country_code) == '+65' ? 'selected' : '' }}>+65 (Singapore)</option>
                                    <option value="+60" {{ old('country_code', $user->country_code) == '+60' ? 'selected' : '' }}>+60 (Malaysia)</option>
                                    <option value="+66" {{ old('country_code', $user->country_code) == '+66' ? 'selected' : '' }}>+66 (Thailand)</option>
                                    <option value="+84" {{ old('country_code', $user->country_code) == '+84' ? 'selected' : '' }}>+84 (Vietnam)</option>
                                    <option value="+62" {{ old('country_code', $user->country_code) == '+62' ? 'selected' : '' }}>+62 (Indonesia)</option>
                                    <option value="+63" {{ old('country_code', $user->country_code) == '+63' ? 'selected' : '' }}>+63 (Philippines)</option>
                                    <option value="+971" {{ old('country_code', $user->country_code) == '+971' ? 'selected' : '' }}>+971 (UAE)</option>
                                    <option value="+966" {{ old('country_code', $user->country_code) == '+966' ? 'selected' : '' }}>+966 (Saudi Arabia)</option>
                                    <option value="+974" {{ old('country_code', $user->country_code) == '+974' ? 'selected' : '' }}>+974 (Qatar)</option>
                                    <option value="+965" {{ old('country_code', $user->country_code) == '+965' ? 'selected' : '' }}>+965 (Kuwait)</option>
                                    <option value="+90" {{ old('country_code', $user->country_code) == '+90' ? 'selected' : '' }}>+90 (Turkey)</option>
                                    <option value="+98" {{ old('country_code', $user->country_code) == '+98' ? 'selected' : '' }}>+98 (Iran)</option>
                                    <option value="+964" {{ old('country_code', $user->country_code) == '+964' ? 'selected' : '' }}>+964 (Iraq)</option>
                                    <option value="+972" {{ old('country_code', $user->country_code) == '+972' ? 'selected' : '' }}>+972 (Israel)</option>
                                    <option value="+961" {{ old('country_code', $user->country_code) == '+961' ? 'selected' : '' }}>+961 (Lebanon)</option>
                                    <option value="+962" {{ old('country_code', $user->country_code) == '+962' ? 'selected' : '' }}>+962 (Jordan)</option>
                                    <option value="+20" {{ old('country_code', $user->country_code) == '+20' ? 'selected' : '' }}>+20 (Egypt)</option>
                                    <option value="+212" {{ old('country_code', $user->country_code) == '+212' ? 'selected' : '' }}>+212 (Morocco)</option>
                                    <option value="+234" {{ old('country_code', $user->country_code) == '+234' ? 'selected' : '' }}>+234 (Nigeria)</option>
                                    <option value="+254" {{ old('country_code', $user->country_code) == '+254' ? 'selected' : '' }}>+254 (Kenya)</option>
                                    <option value="+27" {{ old('country_code', $user->country_code) == '+27' ? 'selected' : '' }}>+27 (South Africa)</option>
                                </select>
                                @error('country_code')
                                    <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <x-forms.input :label="__('messages.mobile')" name="mobile" type="text"
                                    value="{{ old('mobile', $user->mobile) }}" placeholder="1234567890" />
                                <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('messages.mobile_hint') }}
                                </div>
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
                            <form action="{{ route('settings.profile.destroy') }}" method="POST"
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