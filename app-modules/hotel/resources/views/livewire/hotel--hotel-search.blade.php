<?php

use Livewire\Volt\Component;
use Modules\ApiService\Services\HotelApiService;

new class extends Component
{
    public string $destination = '';
    public array $destinationSuggestions = [];
    public bool $showDestinationSuggestions = false;
    public int $destinationCityId = 0;
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

    public function updatedDestination()
    {
        try {
            if (strlen($this->destination) < 2) {
                $this->destinationSuggestions = [];
                $this->showDestinationSuggestions = false;
                return;
            }

            $this->fetchDestinationSuggestions();
        } catch (\Illuminate\Session\TokenMismatchException $e) {
            // Handle session expiration
            session()->flash('error', 'Session expired. Please refresh the page.');
            return redirect()->refresh();
        } catch (\Exception $e) {
            // Handle other errors
            $this->destinationSuggestions = [];
            $this->showDestinationSuggestions = false;
        }
    }

    public function fetchDestinationSuggestions()
    {
        try {
            $cities = \Modules\Location\Models\City::with('country')
                ->active()
                ->search($this->destination)
                ->limit(8)
                ->get()
                ->map(function ($city) {
                    return [
                        'id' => $city->id,
                        'name' => $city->name,
                        'country' => $city->country->name,
                        'display_name' => $city->name . ', ' . $city->country->name,
                        'is_popular' => $city->is_popular
                    ];
                })
                ->toArray();

            $this->destinationSuggestions = $cities;
            $this->showDestinationSuggestions = count($cities) > 0;
        } catch (\Exception $e) {
            $this->destinationSuggestions = [];
            $this->showDestinationSuggestions = false;
        }
    }

    public function selectDestination($cityId, $displayName)
    {
        $this->destinationCityId = $cityId;
        $this->destination = $displayName;
        $this->destinationSuggestions = [];
        $this->showDestinationSuggestions = false;
    }

    public function hideDestinationSuggestions()
    {
        $this->showDestinationSuggestions = false;
    }

    public function showDestinationSuggestions()
    {
        if (count($this->destinationSuggestions) > 0) {
            $this->showDestinationSuggestions = true;
        }
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

<div class="p-8">
    <form wire:submit="search">
        <!-- Main Search Row -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
            
            <!-- Destination Input with Autocomplete -->
            <div class="lg:col-span-1 relative" x-data="{ open: @entangle('showDestinationSuggestions') }">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                    {{ __('messages.destination') }}
                </label>
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="destination"
                        wire:focus="showDestinationSuggestions"
                        wire:blur="hideDestinationSuggestions"
                        class="w-full px-0 py-3 text-lg font-bold text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 focus:border-blue-500 focus:outline-none focus:ring-0 placeholder-gray-400"
                        placeholder="{{ __('messages.enter_destination') }}"
                        required
                        autocomplete="off"
                    >
                    <div class="text-xs text-gray-500 mt-1">
                        @if($destination && str_contains($destination, ','))
                            {{ explode(', ', $destination)[1] ?? 'Bangladesh' }}
                        @else
                            Bangladesh
                        @endif
                    </div>

                    <!-- Suggestions Dropdown -->
                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto"
                        style="display: none;"
                    >
                        @forelse($destinationSuggestions as $city)
                            <div 
                                wire:click="selectDestination({{ $city['id'] }}, '{{ $city['display_name'] }}')"
                                class="px-4 py-3 cursor-pointer hover:bg-gray-50 border-b border-gray-100 last:border-b-0 flex items-center justify-between"
                            >
                                <div class="flex flex-col">
                                    <div class="font-medium text-gray-900">{{ $city['name'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $city['country'] }}</div>
                                </div>
                                @if($city['is_popular'])
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Popular
                                    </span>
                                @endif
                            </div>
                        @empty
                            @if(strlen($destination) >= 2)
                                <div class="px-4 py-3 text-gray-500 text-sm">
                                    No destinations found for "{{ $destination }}"
                                </div>
                            @endif
                        @endforelse
                    </div>

                    <!-- Loading indicator -->
                    <div wire:loading wire:target="fetchDestinationSuggestions" class="absolute right-2 top-3">
                        <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
                @error('destination') 
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Check-in Date -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                    {{ __('messages.checkin_date') }}
                </label>
                <div class="relative">
                    <input 
                        type="date" 
                        wire:model="checkin_date"
                        min="{{ date('Y-m-d') }}"
                        class="w-full px-0 py-3 text-lg font-bold text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 focus:border-blue-500 focus:outline-none focus:ring-0"
                        required
                    >
                    <div class="text-xs text-gray-500 mt-1" wire:ignore>
                        <span x-data="{ date: $wire.checkin_date }" 
                              x-text="date ? new Date(date).toLocaleDateString('en-US', { weekday: 'long' }) : 'Sunday'">
                        </span>
                    </div>
                </div>
                @error('checkin_date') 
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Check-out Date -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                    {{ __('messages.checkout_date') }}
                </label>
                <div class="relative">
                    <input 
                        type="date" 
                        wire:model="checkout_date"
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        class="w-full px-0 py-3 text-lg font-bold text-gray-900 bg-transparent border-0 border-b-2 border-gray-200 focus:border-blue-500 focus:outline-none focus:ring-0"
                        required
                    >
                    <div class="text-xs text-gray-500 mt-1" wire:ignore>
                        <span x-data="{ date: $wire.checkout_date }" 
                              x-text="date ? new Date(date).toLocaleDateString('en-US', { weekday: 'long' }) : 'Monday'">
                        </span>
                    </div>
                </div>
                @error('checkout_date') 
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Rooms & Guests -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                    {{ __('messages.rooms') }} & {{ __('messages.guests') }}
                </label>
                <div class="relative">
                    <div class="flex items-center py-3 border-b-2 border-gray-200">
                        <div class="flex-1">
                            <div class="text-lg font-bold text-gray-900">
                                <span x-data="{ rooms: $wire.rooms, guests: $wire.guests }" 
                                      x-text="`${rooms} Room, ${guests} Guests`">
                                    1 Room, 2 Guests
                                </span>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">2 Adults</div>
                        </div>
                    </div>
                    
                    <!-- Hidden selects for functionality -->
                    <select wire:model="rooms" class="hidden">
                        @for($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <select wire:model="guests" class="hidden">
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                @error('guests') 
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                @enderror
                @error('rooms') 
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
                <span class="ml-2 text-sm text-gray-700">Couples</span>
            </label>
            
            <label class="inline-flex items-center">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Families</span>
            </label>
            
            <label class="inline-flex items-center">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Friends</span>
            </label>
            
            <label class="inline-flex items-center">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Solo</span>
            </label>
        </div>

        <!-- Search Button -->
        <div class="flex justify-center">
            <button 
                type="submit" 
                wire:loading.attr="disabled"
                class="bg-yellow-400 hover:bg-yellow-500 disabled:opacity-50 text-black font-bold py-4 px-12 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-lg min-w-[200px]"
            >
                <span wire:loading.remove>{{ __('messages.search') }}</span>
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
                {{ __('messages.searching_hotels') }}...
            </div>
        </div>
    </div>
</div>