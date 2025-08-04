<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.flight_search') }}</x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ __('messages.search_flights') }}
                        </h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            {{ __('messages.find_best_flights') }}
                        </p>
                    </div>

                    <!-- Flight Search Volt Component -->
                    @volt('flight-search')
                    <div>
                        <form wire:submit="search">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                                <!-- Departure City -->
                                <div>
                                    <label for="departure_city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.departure_city') }}
                                    </label>
                                    <input 
                                        type="text" 
                                        id="departure_city"
                                        wire:model="departure_city"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="{{ __('messages.enter_departure_city') }}"
                                        required
                                    >
                                    @error('departure_city') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <!-- Arrival City -->
                                <div>
                                    <label for="arrival_city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.arrival_city') }}
                                    </label>
                                    <input 
                                        type="text" 
                                        id="arrival_city"
                                        wire:model="arrival_city"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="{{ __('messages.enter_arrival_city') }}"
                                        required
                                    >
                                    @error('arrival_city') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <!-- Departure Date -->
                                <div>
                                    <label for="departure_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.departure_date') }}
                                    </label>
                                    <input 
                                        type="date" 
                                        id="departure_date"
                                        wire:model="departure_date"
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        required
                                    >
                                    @error('departure_date') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <!-- Return Date -->
                                <div>
                                    <label for="return_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.return_date') }}
                                    </label>
                                    <input 
                                        type="date" 
                                        id="return_date"
                                        wire:model="return_date"
                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                    >
                                    @error('return_date') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <!-- Passengers -->
                                <div>
                                    <label for="passengers" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.passengers') }}
                                    </label>
                                    <select 
                                        id="passengers"
                                        wire:model="passengers"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        required
                                    >
                                        @for($i = 1; $i <= 9; $i++)
                                            <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? __('messages.passenger') : __('messages.passengers') }}</option>
                                        @endfor
                                    </select>
                                    @error('passengers') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <!-- Class -->
                                <div>
                                    <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.class') }}
                                    </label>
                                    <select 
                                        id="class"
                                        wire:model="class"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                        required
                                    >
                                        <option value="economy">{{ __('messages.economy') }}</option>
                                        <option value="business">{{ __('messages.business') }}</option>
                                        <option value="first">{{ __('messages.first_class') }}</option>
                                    </select>
                                    @error('class') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>
                            </div>

                            <!-- Search Button -->
                            <div class="flex justify-center">
                                <button 
                                    type="submit" 
                                    wire:loading.attr="disabled"
                                    class="px-8 py-3 bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                                >
                                    <span wire:loading.remove>{{ __('messages.search_flights') }}</span>
                                    <span wire:loading>{{ __('messages.searching') }}...</span>
                                </button>
                            </div>
                        </form>

                        <!-- Loading State -->
                        <div wire:loading class="mt-8 text-center">
                            <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-blue-500 bg-blue-100 transition ease-in-out duration-150">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ __('messages.searching_flights') }}...
                            </div>
                        </div>
                    </div>
                    @endvolt
                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>