<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.hajj_packages') }} - {{ __('messages.eco_travel') }}</x-slot>
    <x-slot name="meta_description">{{ __('messages.hajj_package_meta_description') }}</x-slot>

    @if(app()->getLocale() == 'en')
        @include('static-site::hajj-package.hajj-package-content-en')
    @else
        @include('static-site::hajj-package.hajj-package-content-bn')
    @endif
</x-customer-frontend-layout::layout>