<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.eco_travel') }} - {{ __('messages.better_service_experience') }}</x-slot>
    <x-slot name="meta_description">{{ __('messages.homepage_meta_description') }}</x-slot>

    @if(app()->getLocale() == 'en')
        @include('static-site::homepage.homepage-content-en')
    @else
        @include('static-site::homepage.homepage-content-bn')
    @endif
</x-customer-frontend-layout::layout>