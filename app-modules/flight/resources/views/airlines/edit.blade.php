<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    @if($airline->hasLogo())
                        <img src="{{ $airline->logo_thumb_url }}" alt="{{ $airline->name }}" class="w-12 h-12 rounded-lg border object-cover">
                    @endif
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit {{ $airline->name }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update airline information</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('flight::admin.airlines.show', $airline->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View
                    </a>
                    <a href="{{ route('flight::admin.airlines.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('flight::admin.airlines.update', $airline->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Airline Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Airline Name *
                        </label>
                        <input type="text" 
                               id="name"
                               name="name"
                               value="{{ old('name', $airline->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter airline name"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Country *
                        </label>
                        <select id="country_id"
                                name="country_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id', $airline->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Airline Code -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Airline Code *
                        </label>
                        <input type="text" 
                               id="code"
                               name="code"
                               value="{{ old('code', $airline->code) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="e.g., AI, 6E, SG"
                               maxlength="3"
                               style="text-transform: uppercase;"
                               required>
                        @error('code')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">2-3 character IATA airline code</p>
                    </div>

                    <!-- ICAO Code -->
                    <div>
                        <label for="icao_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            ICAO Code *
                        </label>
                        <input type="text" 
                               id="icao_code"
                               name="icao_code"
                               value="{{ old('icao_code', $airline->icao_code) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="e.g., AIC, IGO, SEJ"
                               maxlength="4"
                               style="text-transform: uppercase;"
                               required>
                        @error('icao_code')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">4-character ICAO airline code</p>
                    </div>

                    <!-- Logo Upload -->
                    <div class="md:col-span-2">
                        <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Airline Logo
                        </label>
                        
                        @if($airline->hasLogo())
                            <div class="mb-4">
                                <img src="{{ $airline->logo_thumb_url }}" alt="{{ $airline->name }} logo" class="w-24 h-24 rounded-lg border object-cover">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Current logo</p>
                            </div>
                        @endif
                        
                        <input type="file" 
                               id="logo"
                               name="logo"
                               accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('logo')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Upload airline logo (JPEG, PNG, JPG, GIF, SVG - Max: 2MB)</p>
                    </div>

                    <!-- Website URL -->
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Website URL
                        </label>
                        <input type="url" 
                               id="website"
                               name="website"
                               value="{{ old('website', $airline->website) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="https://www.airline.com">
                        @error('website')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Headquarters -->
                    <div>
                        <label for="headquarters" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Headquarters
                        </label>
                        <input type="text" 
                               id="headquarters"
                               name="headquarters"
                               value="{{ old('headquarters', $airline->headquarters) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="City, Country">
                        @error('headquarters')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Founded Year -->
                    <div>
                        <label for="founded" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Founded Year
                        </label>
                        <input type="number" 
                               id="founded"
                               name="founded"
                               value="{{ old('founded', $airline->founded) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="1932"
                               min="1900"
                               max="{{ date('Y') }}">
                        @error('founded')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alliance -->
                    <div>
                        <label for="alliance" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Alliance
                        </label>
                        <select id="alliance"
                                name="alliance"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">No Alliance</option>
                            <option value="star_alliance" {{ old('alliance', $airline->alliance) == 'star_alliance' ? 'selected' : '' }}>Star Alliance</option>
                            <option value="oneworld" {{ old('alliance', $airline->alliance) == 'oneworld' ? 'selected' : '' }}>Oneworld</option>
                            <option value="skyteam" {{ old('alliance', $airline->alliance) == 'skyteam' ? 'selected' : '' }}>SkyTeam</option>
                            <option value="none" {{ old('alliance', $airline->alliance) == 'none' ? 'selected' : '' }}>None</option>
                        </select>
                        @error('alliance')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Position -->
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Display Position
                        </label>
                        <input type="number" 
                               id="position"
                               name="position"
                               value="{{ old('position', $airline->position) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="0"
                               min="0">
                        @error('position')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Lower numbers appear first in lists</p>
                    </div>
                </div>

                <!-- Options -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Options</h3>
                    
                    <div class="space-y-3">
                        <!-- Active Status -->
                        <div>
                            <label class="flex items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', $airline->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                            </label>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Active airlines will be available for flight scheduling</p>
                        </div>

                        <!-- Low Cost Carrier -->
                        <div>
                            <label class="flex items-center">
                                <input type="hidden" name="is_low_cost" value="0">
                                <input type="checkbox" 
                                       name="is_low_cost" 
                                       value="1" 
                                       {{ old('is_low_cost', $airline->is_low_cost) ? 'checked' : '' }}
                                       class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Low Cost Carrier</span>
                            </label>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Mark as budget/low-cost airline</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('flight::admin.airlines.show', $airline->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Update Airline
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-dashboard-layout::layout>