<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.hotels') }} - {{ __('messages.eco_travel') }}</x-slot>
    <x-slot name="meta_description">{{ __('messages.hotel_meta_description') }}</x-slot>

    @if(app()->getLocale() == 'en')
        @include('static-site::hotel.hotel-content-en')
    @else
        @include('static-site::hotel.hotel-content-bn')
    @endif
</x-customer-frontend-layout::layout>