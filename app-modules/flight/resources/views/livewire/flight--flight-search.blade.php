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

<div class="p-8">
    <form wire:submit="search">
        <!-- Main Search Row -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
            
            <!-- Departure City -->
            <div class="lg:col-span-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                    {{ __('messages.departure_city') }}
                </label>
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model="departure_city"
                        class="w-full px-0 py-3 text-lg font-bold text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 focus:border-blue-500 focus:outline-none focus:ring-0 placeholder-gray-400"
                        placeholder="{{ __('messages.enter_departure_city') }}"
                        required
                        autocomplete="off"
                    >
                    <div class="text-xs text-gray-500 mt-1">Bangladesh</div>
                </div>
                @error('departure_city') 
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Arrival City -->
            <div class="lg:col-span-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                    {{ __('messages.arrival_city') }}
                </label>
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model="arrival_city"
                        class="w-full px-0 py-3 text-lg font-bold text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 focus:border-blue-500 focus:outline-none focus:ring-0 placeholder-gray-400"
                        placeholder="{{ __('messages.enter_arrival_city') }}"
                        required
                        autocomplete="off"
                    >
                    <div class="text-xs text-gray-500 mt-1">International</div>
                </div>
                @error('arrival_city') 
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Departure Date -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                    {{ __('messages.departure_date') }}
                </label>
                <div class="relative">
                    <input 
                        type="date" 
                        wire:model="departure_date"
                        min="{{ date('Y-m-d') }}"
                        class="w-full px-0 py-3 text-lg font-bold text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 focus:border-blue-500 focus:outline-none focus:ring-0"
                        required
                    >
                    <div class="text-xs text-gray-500 mt-1" wire:ignore>
                        <span x-data="{ date: $wire.departure_date }" 
                              x-text="date ? new Date(date).toLocaleDateString('en-US', { weekday: 'long' }) : 'Monday'">
                        </span>
                    </div>
                </div>
                @error('departure_date') 
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Return Date & Passengers -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                    {{ __('messages.return_date') }} & {{ __('messages.passengers') }}
                </label>
                <div class="relative">
                    <div class="flex items-center py-3 border-b-2 border-gray-200">
                        <div class="flex-1">
                            <div class="text-lg font-bold text-gray-900">
                                <span x-data="{ return_date: $wire.return_date, passengers: $wire.passengers }" 
                                      x-text="return_date ? new Date(return_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) + ', ' + passengers + ' Passengers' : passengers + ' Passengers'">
                                    1 Passengers
                                </span>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                <span x-data="{ return_date: $wire.return_date }" 
                                      x-text="return_date ? new Date(return_date).toLocaleDateString('en-US', { weekday: 'long' }) : 'One Way'">
                                    One Way
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden inputs for functionality -->
                    <input type="date" wire:model="return_date" class="hidden" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    <select wire:model="passengers" class="hidden">
                        @for($i = 1; $i <= 9; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <select wire:model="class" class="hidden">
                        <option value="economy">Economy</option>
                        <option value="business">Business</option>
                        <option value="first">First Class</option>
                    </select>
                </div>
                @error('return_date') 
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                @enderror
                @error('passengers') 
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                @enderror
                @error('class') 
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                @enderror
            </div>
        </div>

        <!-- Search Options -->
        <div class="flex flex-wrap items-center gap-4 mb-8">
            <span class="text-sm text-gray-600 font-medium">{{ __('messages.search_for') }}</span>
            
            <label class="inline-flex items-center">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Business</span>
            </label>
            
            <label class="inline-flex items-center">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Economy</span>
            </label>
            
            <label class="inline-flex items-center">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">First Class</span>
            </label>
        </div>

        <!-- Search Button -->
        <div class="flex justify-center">
            <button 
                type="submit" 
                wire:loading.attr="disabled"
                class="bg-yellow-400 hover:bg-yellow-500 disabled:opacity-50 text-black font-bold py-4 px-12 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-lg min-w-[200px]"
            >
                <span wire:loading.remove">{{ __('messages.search_flights') }}</span>
                <span wire:loading class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('messages.searching') }}...
                </span>
            </button>
        </div>
    </form>

    <!-- Loading Overlay -->
    <div wire:loading class="absolute inset-0 bg-white bg-opacity-90 rounded-3xl flex items-center justify-center z-50">
        <div class="text-center">
            <div class="inline-flex items-center px-6 py-3 font-semibold leading-6 text-base rounded-xl text-blue-600 bg-blue-50 transition ease-in-out duration-150">
                <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ __('messages.searching_flights') }}...
            </div>
        </div>
    </div>
</div>