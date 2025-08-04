<?php

use Livewire\Volt\Component;
use Modules\ApiService\Services\FlightApiService;

new class extends Component
{
    public string $departure_city = '';
    public string $arrival_city = '';
    public string $departure_date = '';
    public string $return_date = '';
    public int $passengers = 1;
    public string $class = 'economy';
    
    public function mount()
    {
        $this->departure_date = date('Y-m-d');
    }

    public function search()
    {
        $this->validate([
            'departure_city' => 'required|string|max:100',
            'arrival_city' => 'required|string|max:100',
            'departure_date' => 'required|date|after_or_equal:today',
            'return_date' => 'nullable|date|after:departure_date',
            'passengers' => 'required|integer|min:1|max:9',
            'class' => 'required|in:economy,business,first'
        ]);

        $searchParams = [
            'departure_city' => $this->departure_city,
            'arrival_city' => $this->arrival_city,
            'departure_date' => $this->departure_date,
            'return_date' => $this->return_date,
            'passengers' => $this->passengers,
            'class' => $this->class,
            'trip_type' => $this->return_date ? 'roundtrip' : 'oneway'
        ];

        // Use the API service to search flights
        $flightApiService = \Modules\ApiService\ApiServiceManager::flight();
        $results = $flightApiService->searchFlights($searchParams);

        if (isset($results['error'])) {
            session()->flash('error', $results['error']);
            return;
        }

        // Redirect to results page with search parameters
        return redirect()->route('flight::dynamic.search', [
            'departure_city' => $this->departure_city,
            'arrival_city' => $this->arrival_city,
            'departure_date' => $this->departure_date,
            'return_date' => $this->return_date,
            'passengers' => $this->passengers,
            'class' => $this->class,
        ]);
    }
}; ?>