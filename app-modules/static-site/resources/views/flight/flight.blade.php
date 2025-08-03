<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.flight_booking') }} - {{ __('messages.eco_travel') }}</x-slot>
    <x-slot name="meta_description">{{ __('messages.flight_meta_description') }}</x-slot>

    @if(app()->getLocale() == 'en')
        @include('static-site::flight.flight-content-en')
    @else
        @include('static-site::flight.flight-content-bn')
    @endif
</x-customer-frontend-layout::layout>