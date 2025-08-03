<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.holiday_packages') }} - {{ __('messages.eco_travel') }}</x-slot>
    <x-slot name="meta_description">{{ __('messages.holiday_package_meta_description') }}</x-slot>

    @if(app()->getLocale() == 'en')
        @include('static-site::holiday-package.holiday-package-content-en')
    @else
        @include('static-site::holiday-package.holiday-package-content-bn')
    @endif
</x-customer-frontend-layout::layout>