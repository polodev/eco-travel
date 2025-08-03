{{-- Hero Section --}}
<section class="relative bg-gradient-to-r from-green-600 to-teal-600 dark:from-green-800 dark:to-teal-800 text-white py-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Hotel Booking Services</h1>
            <p class="text-xl md:text-2xl mb-8">Premium Hotels with Best Deals and Comfortable Accommodations</p>
            <p class="text-lg mb-8">5-Star Hotels • Best Locations • Instant Confirmation</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-lg font-semibold transition-colors">
                    Search Hotels
                </button>
                <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-green-800 px-8 py-3 rounded-lg font-semibold transition-colors">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Featured Hotels Section --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Featured Hotels</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Discover our handpicked selection of premium hotels</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $featuredHotels = [
                [
                    'name' => 'Hotel The Cox Today',
                    'location' => 'Cox-Bazar',
                    'price' => '5,000',
                    'rating' => '5 Star',
                    'guests' => '2 persons',
                    'image' => '/images/static-site/hotel/cox-today.jpg'
                ],
                [
                    'name' => 'Grand Sultan Tea Resorts',
                    'location' => 'Sylhet',
                    'price' => '18,000',
                    'rating' => '5 Star',
                    'guests' => '2 persons',
                    'image' => '/images/static-site/hotel/grand-sultan.jpg'
                ],
                [
                    'name' => 'Ocean Paradise',
                    'location' => 'Cox-Bazar',
                    'price' => '10,000',
                    'rating' => '5 Star',
                    'guests' => '2 persons',
                    'image' => '/images/static-site/hotel/ocean-paradise.jpg'
                ],
                [
                    'name' => 'Sea Pearl Cox Bazar',
                    'location' => 'Inani, Cox Bazar',
                    'price' => '15,000',
                    'rating' => '5 Star',
                    'guests' => '2 persons',
                    'image' => '/images/static-site/hotel/sea-pearl.jpg'
                ]
            ];
            @endphp

            @foreach($featuredHotels as $hotel)
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                <div class="h-48 bg-gradient-to-r from-green-400 to-teal-500 relative">
                    <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="text-4xl mb-2">🏨</div>
                            <p class="text-sm">{{ $hotel['rating'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $hotel['name'] }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-2">📍 {{ $hotel['location'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Min {{ $hotel['guests'] }}</p>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">৳{{ $hotel['price'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">per night</p>
                        </div>
                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Hotel Destinations Section --}}
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Popular Destinations</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Explore amazing hotels in top destinations</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            @php
            $destinations = [
                [
                    'name' => 'Cox-Bazar',
                    'description' => 'Longest natural sea beach in the world',
                    'hotels' => 15,
                    'icon' => '🏖️',
                    'features' => ['Sea Beach', 'Sunset Views', 'Water Sports', 'Local Cuisine']
                ],
                [
                    'name' => 'Sylhet',
                    'description' => 'Land of two leaves and a bud',
                    'hotels' => 8,
                    'icon' => '🍃',
                    'features' => ['Tea Gardens', 'Hills', 'Lakes', 'Natural Beauty']
                ]
            ];
            @endphp

            @foreach($destinations as $destination)
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                <div class="flex items-center mb-6">
                    <div class="text-5xl mr-4">{{ $destination['icon'] }}</div>
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $destination['name'] }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ $destination['description'] }}</p>
                        <p class="text-sm text-green-600 dark:text-green-400">{{ $destination['hotels'] }} hotels available</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    @foreach($destination['features'] as $feature)
                    <div class="flex items-center space-x-2">
                        <span class="text-green-500">✓</span>
                        <span class="text-gray-600 dark:text-gray-300 text-sm">{{ $feature }}</span>
                    </div>
                    @endforeach
                </div>

                <button class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium transition-colors">
                    View Hotels in {{ $destination['name'] }}
                </button>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Hotel Services Section --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Our Hotel Services</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Everything you need for a perfect stay</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
            $services = [
                [
                    'title' => 'Best Price Guarantee',
                    'description' => 'We guarantee the best prices for all hotel bookings',
                    'icon' => '💰',
                    'features' => ['Price Match', 'No Hidden Fees', 'Best Deals', 'Instant Savings']
                ],
                [
                    'title' => 'Premium Locations',
                    'description' => 'Hotels in the best locations with easy access to attractions',
                    'icon' => '📍',
                    'features' => ['Prime Locations', 'City Centers', 'Tourist Areas', 'Easy Access']
                ],
                [
                    'title' => '5-Star Experience',
                    'description' => 'Luxury accommodations with world-class amenities',
                    'icon' => '⭐',
                    'features' => ['Luxury Rooms', 'Premium Amenities', 'Excellent Service', 'Fine Dining']
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

{{-- Why Choose Us --}}
<section class="py-16 bg-gradient-to-r from-green-600 to-teal-600 dark:from-green-800 dark:to-teal-800 text-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Why Choose Our Hotel Booking?</h2>
            <p class="text-xl">Your comfort is our priority</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $whyChooseUs = [
                [
                    'icon' => '🏨',
                    'title' => '5-Star Hotels',
                    'description' => 'Premium accommodations with luxury amenities and services'
                ],
                [
                    'icon' => '💳',
                    'title' => 'Easy Booking',
                    'description' => 'Simple and secure online booking process with instant confirmation'
                ],
                [
                    'icon' => '📞',
                    'title' => '24/7 Support',
                    'description' => 'Round the clock customer support for all your hotel needs'
                ],
                [
                    'icon' => '🛡️',
                    'title' => 'Secure Payment',
                    'description' => 'Safe and secure payment processing with multiple options'
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Ready to Book Your Hotel?</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Contact us for the best hotel deals and personalized service</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">Call Us Now</h3>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mb-4">+8809647668822</p>
                <p class="text-gray-600 dark:text-gray-300">Available 24/7 for hotel bookings</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">✉️</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">Email Us</h3>
                <p class="text-xl text-green-600 dark:text-green-400 mb-4">info@ecotravelsonline.com.bd</p>
                <p class="text-gray-600 dark:text-gray-300">Send us your hotel requirements</p>
            </div>
        </div>
    </div>
</section>