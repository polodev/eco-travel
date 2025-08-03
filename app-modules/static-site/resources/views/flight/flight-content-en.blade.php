{{-- Hero Section --}}
<section class="relative bg-gradient-to-r from-sky-600 to-blue-600 dark:from-sky-800 dark:to-blue-800 text-white py-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Flight Booking Services</h1>
            <p class="text-xl md:text-2xl mb-8">Cheap Air Tickets from All Airlines with Better Service Experience</p>
            <p class="text-lg mb-8">24x7 Customer Support • Domestic & International Flights</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-lg font-semibold transition-colors">
                    Search Flights
                </button>
                <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-800 px-8 py-3 rounded-lg font-semibold transition-colors">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Services Overview --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Our Flight Services</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Committed to provide cheap Air Ticket from all Airlines with better service experience</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
            $services = [
                [
                    'title' => 'Domestic Flights',
                    'description' => 'Best deals on domestic flights to all major cities in Bangladesh',
                    'icon' => '🏠',
                    'features' => ['All Major Cities', 'Best Prices', 'Quick Booking', 'Instant Confirmation']
                ],
                [
                    'title' => 'International Flights',
                    'description' => 'Fly to your favorite international destinations with great deals',
                    'icon' => '🌍',
                    'features' => ['Global Destinations', 'Multiple Airlines', 'Competitive Prices', '24/7 Support']
                ],
                [
                    'title' => 'Special Services',
                    'description' => 'Additional services to make your journey comfortable and hassle-free',
                    'icon' => '⭐',
                    'features' => ['Group Booking', 'Seat Selection', 'Meal Preferences', 'Travel Insurance']
                ]
            ];
            @endphp

            @foreach($services as $service)
            <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-lg hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-4">{{ $service['icon'] }}</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">{{ $service['title'] }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6">{{ $service['description'] }}</p>
                <ul class="space-y-2">
                    @foreach($service['features'] as $feature)
                    <li class="flex items-center space-x-2">
                        <span class="text-green-500">✓</span>
                        <span class="text-gray-600 dark:text-gray-300">{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Domestic Flight Routes --}}
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Popular Domestic Routes</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Best prices for domestic flights within Bangladesh</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $domesticRoutes = [
                ['from' => 'Dhaka', 'to' => 'Cox Bazar', 'price' => '4,400', 'duration' => '1h 20m'],
                ['from' => 'Dhaka', 'to' => 'Chittagong', 'price' => '2,400', 'duration' => '50m'],
                ['from' => 'Dhaka', 'to' => 'Sylhet', 'price' => '2,400', 'duration' => '45m'],
                ['from' => 'Dhaka', 'to' => 'Rajshahi', 'price' => '2,200', 'duration' => '55m'],
                ['from' => 'Dhaka', 'to' => 'Jashore', 'price' => '2,200', 'duration' => '50m'],
                ['from' => 'Dhaka', 'to' => 'Barisal', 'price' => '2,200', 'duration' => '45m']
            ];
            @endphp

            @foreach($domesticRoutes as $route)
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <span class="text-2xl">🛫</span>
                        <div>
                            <h3 class="font-semibold text-gray-800 dark:text-white">{{ $route['from'] }} → {{ $route['to'] }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $route['duration'] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">৳{{ $route['price'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Starting from</p>
                    </div>
                </div>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium transition-colors">
                    Book Now
                </button>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- International Destinations --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">International Destinations</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Fly to amazing destinations worldwide</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $internationalDestinations = [
                ['country' => 'India', 'cities' => ['Kolkata', 'Mumbai', 'Chennai', 'Delhi'], 'flag' => '🇮🇳'],
                ['country' => 'Thailand', 'cities' => ['Bangkok'], 'flag' => '🇹🇭'],
                ['country' => 'Malaysia', 'cities' => ['Kuala Lumpur'], 'flag' => '🇲🇾'],
                ['country' => 'Singapore', 'cities' => ['Singapore'], 'flag' => '🇸🇬'],
                ['country' => 'UAE', 'cities' => ['Dubai'], 'flag' => '🇦🇪'],
                ['country' => 'Qatar', 'cities' => ['Doha'], 'flag' => '🇶🇦'],
                ['country' => 'Saudi Arabia', 'cities' => ['Jeddah'], 'flag' => '🇸🇦'],
                ['country' => 'Oman', 'cities' => ['Muscat'], 'flag' => '🇴🇲']
            ];
            @endphp

            @foreach($internationalDestinations as $destination)
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg text-center hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-3">{{ $destination['flag'] }}</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">{{ $destination['country'] }}</h3>
                <div class="space-y-1 mb-4">
                    @foreach($destination['cities'] as $city)
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $city }}</p>
                    @endforeach
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    View Flights
                </button>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Why Choose Us --}}
<section class="py-16 bg-gradient-to-r from-blue-600 to-sky-600 dark:from-blue-800 dark:to-sky-800 text-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Why Choose Eco Travel?</h2>
            <p class="text-xl">Your trusted partner for flight bookings</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $whyChooseUs = [
                [
                    'icon' => '💰',
                    'title' => 'Best Prices',
                    'description' => 'Cheap air tickets from all airlines with competitive pricing'
                ],
                [
                    'icon' => '⏰',
                    'title' => '24/7 Support',
                    'description' => 'Round the clock customer support for all your needs'
                ],
                [
                    'icon' => '✈️',
                    'title' => 'All Airlines',
                    'description' => 'Access to all major domestic and international airlines'
                ],
                [
                    'icon' => '🛡️',
                    'title' => 'Secure Booking',
                    'description' => 'Safe and secure booking process with instant confirmation'
                ]
            ];
            @endphp

            @foreach($whyChooseUs as $reason)
            <div class="text-center">
                <div class="text-4xl mb-4">{{ $reason['icon'] }}</div>
                <h3 class="text-xl font-semibold mb-3">{{ $reason['title'] }}</h3>
                <p class="text-sm opacity-90">{{ $reason['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Contact Section --}}
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Ready to Book Your Flight?</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Contact us for the best deals and personalized service</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">Call Us Now</h3>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-4">+8809647668822</p>
                <p class="text-gray-600 dark:text-gray-300">Available 24/7 for flight bookings</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">✉️</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">Email Us</h3>
                <p class="text-xl text-blue-600 dark:text-blue-400 mb-4">info@ecotravelsonline.com.bd</p>
                <p class="text-gray-600 dark:text-gray-300">Send us your travel requirements</p>
            </div>
        </div>
    </div>
</section>