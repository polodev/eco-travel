<?php

use Livewire\Volt\Component;
use Modules\ApiService\Services\HotelApiService;

new class extends Component
{
    public string $destination = '';
    public string $checkin_date = '';
    public string $checkout_date = '';
    public int $guests = 2;
    public int $rooms = 1;
    public string $star_rating = '';
    
    public function mount()
    {
        $this->checkin_date = date('Y-m-d');
        $this->checkout_date = date('Y-m-d', strtotime('+1 day'));
    }

    public function search()
    {
        $this->validate([
            'destination' => 'required|string|max:100',
            'checkin_date' => 'required|date|after_or_equal:today',
            'checkout_date' => 'required|date|after:checkin_date',
            'guests' => 'required|integer|min:1|max:8',
            'rooms' => 'required|integer|min:1|max:4',
            'star_rating' => 'nullable|integer|min:1|max:5'
        ]);

        $searchParams = [
            'destination' => $this->destination,
            'checkin_date' => $this->checkin_date,
            'checkout_date' => $this->checkout_date,
            'guests' => $this->guests,
            'rooms' => $this->rooms,
            'star_rating' => $this->star_rating ?: null,
        ];

        // Use the API service to search hotels
        $hotelApiService = \Modules\ApiService\ApiServiceManager::hotel();
        $results = $hotelApiService->searchHotels($searchParams);

        if (isset($results['error'])) {
            session()->flash('error', $results['error']);
            return;
        }

        // Redirect to results page with search parameters
        return redirect()->route('hotel::dynamic.search', [
            'destination' => $this->destination,
            'checkin_date' => $this->checkin_date,
            'checkout_date' => $this->checkout_date,
            'guests' => $this->guests,
            'rooms' => $this->rooms,
            'star_rating' => $this->star_rating,
        ]);
    }
}; ?>