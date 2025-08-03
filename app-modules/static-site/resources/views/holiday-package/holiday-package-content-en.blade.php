{{-- Hero Section --}}
<section class="relative bg-gradient-to-r from-purple-600 to-pink-600 dark:from-purple-800 dark:to-pink-800 text-white py-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Holiday Packages</h1>
            <p class="text-xl md:text-2xl mb-8">Explore Amazing Destinations with Exciting Deals All Over the Year</p>
            <p class="text-lg mb-8">Thailand • Indonesia • India • Malaysia • Maldives • And More!</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-lg font-semibold transition-colors">
                    Explore Packages
                </button>
                <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-purple-800 px-8 py-3 rounded-lg font-semibold transition-colors">
                    Get Custom Quote
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Popular Destinations Section --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Popular Destinations</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Discover breathtaking destinations around the world</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $destinations = [
                [
                    'name' => 'Thailand',
                    'packages' => 4,
                    'price_from' => '20,000',
                    'duration' => '5-7 Days',
                    'highlights' => ['Bangkok', 'Pattaya', 'Phuket'],
                    'flag' => '🇹🇭'
                ],
                [
                    'name' => 'Indonesia',
                    'packages' => 4,
                    'price_from' => '25,000',
                    'duration' => '6-8 Days',
                    'highlights' => ['Bali', 'Nusa Penida', 'Jakarta'],
                    'flag' => '🇮🇩'
                ],
                [
                    'name' => 'India',
                    'packages' => 4,
                    'price_from' => '15,000',
                    'duration' => '4-6 Days',
                    'highlights' => ['Delhi', 'Agra', 'Kashmir'],
                    'flag' => '🇮🇳'
                ],
                [
                    'name' => 'Malaysia',
                    'packages' => 4,
                    'price_from' => '30,000',
                    'duration' => '5-7 Days',
                    'highlights' => ['Kuala Lumpur', 'Penang', 'Langkawi'],
                    'flag' => '🇲🇾'
                ],
                [
                    'name' => 'Maldives',
                    'packages' => 4,
                    'price_from' => '80,000',
                    'duration' => '4-6 Days',
                    'highlights' => ['Water Villas', 'Beach Resorts', 'Coral Reefs'],
                    'flag' => '🇲🇻'
                ],
                [
                    'name' => 'Nepal',
                    'packages' => 4,
                    'price_from' => '18,000',
                    'duration' => '5-7 Days',
                    'highlights' => ['Kathmandu', 'Pokhara', 'Chitwan'],
                    'flag' => '🇳🇵'
                ],
                [
                    'name' => 'Japan',
                    'packages' => 4,
                    'price_from' => '1,50,000',
                    'duration' => '7-10 Days',
                    'highlights' => ['Tokyo', 'Hiroshima', 'Kyoto'],
                    'flag' => '🇯🇵'
                ],
                [
                    'name' => 'Turkey',
                    'packages' => 4,
                    'price_from' => '1,20,000',
                    'duration' => '8-10 Days',
                    'highlights' => ['Istanbul', 'Cappadocia', 'Antalya'],
                    'flag' => '🇹🇷'
                ]
            ];
            @endphp

            @foreach($destinations as $destination)
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                <div class="h-48 bg-gradient-to-r from-purple-400 to-pink-500 relative">
                    <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                        <div class="text-white text-center">
                            <div class="text-6xl mb-2">{{ $destination['flag'] }}</div>
                            <p class="text-lg font-semibold">{{ $destination['name'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $destination['name'] }}</h3>
                    <div class="text-sm text-gray-600 dark:text-gray-300 mb-3">
                        <p>{{ $destination['packages'] }} packages available</p>
                        <p>Duration: {{ $destination['duration'] }}</p>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Highlights:</h4>
                        <div class="flex flex-wrap gap-1">
                            @foreach($destination['highlights'] as $highlight)
                            <span class="text-xs bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-2 py-1 rounded">{{ $highlight }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-lg font-bold text-purple-600 dark:text-purple-400">৳{{ $destination['price_from'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">starting from</p>
                        </div>
                        <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            View Packages
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Package Types Section --}}
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Package Types</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Choose from our carefully crafted holiday packages</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
            $packageTypes = [
                [
                    'title' => 'Budget Packages',
                    'description' => 'Affordable packages without compromising on experience',
                    'icon' => '💰',
                    'price_range' => '15,000 - 50,000',
                    'features' => ['Standard Hotels', '3-5 Days', 'Group Tours', 'Basic Meals'],
                    'destinations' => ['India', 'Nepal', 'Thailand']
                ],
                [
                    'title' => 'Premium Packages',
                    'description' => 'Luxury experiences with premium accommodations',
                    'icon' => '⭐',
                    'price_range' => '80,000 - 2,00,000',
                    'features' => ['5-Star Hotels', '7-10 Days', 'Private Tours', 'Fine Dining'],
                    'destinations' => ['Maldives', 'Japan', 'Europe']
                ],
                [
                    'title' => 'Family Packages',
                    'description' => 'Perfect packages designed for family vacations',
                    'icon' => '👨‍👩‍👧‍👦',
                    'price_range' => '25,000 - 1,50,000',
                    'features' => ['Family Rooms', '5-8 Days', 'Kid-Friendly', 'All Meals'],
                    'destinations' => ['Malaysia', 'Indonesia', 'Turkey']
                ]
            ];
            @endphp

            @foreach($packageTypes as $type)
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                <div class="text-4xl mb-4">{{ $type['icon'] }}</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">{{ $type['title'] }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $type['description'] }}</p>
                <div class="mb-6">
                    <p class="text-lg font-bold text-purple-600 dark:text-purple-400 mb-2">৳{{ $type['price_range'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">per person</p>
                </div>
                
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-3">Package Includes:</h4>
                    <ul class="space-y-2">
                        @foreach($type['features'] as $feature)
                        <li class="flex items-center space-x-2">
                            <span class="text-green-500">✓</span>
                            <span class="text-gray-600 dark:text-gray-300 text-sm">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Popular Destinations:</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($type['destinations'] as $dest)
                        <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded">{{ $dest }}</span>
                        @endforeach
                    </div>
                </div>

                <button class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg font-medium transition-colors">
                    Explore {{ $type['title'] }}
                </button>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Special Features Section --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Why Choose Our Holiday Packages?</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Experience hassle-free holidays with our comprehensive packages</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $features = [
                [
                    'icon' => '✈️',
                    'title' => 'All-Inclusive',
                    'description' => 'Flights, hotels, meals, and transfers included in one package'
                ],
                [
                    'icon' => '🗺️',
                    'title' => 'Expert Guides',
                    'description' => 'Local expert guides to show you the best of each destination'
                ],
                [
                    'icon' => '🏨',
                    'title' => 'Quality Hotels',
                    'description' => 'Handpicked 3-5 star hotels with excellent ratings and amenities'
                ],
                [
                    'icon' => '🛡️',
                    'title' => 'Travel Insurance',
                    'description' => 'Comprehensive travel insurance coverage for peace of mind'
                ],
                [
                    'icon' => '📞',
                    'title' => '24/7 Support',
                    'description' => 'Round the clock customer support during your entire journey'
                ],
                [
                    'icon' => '💳',
                    'title' => 'Easy Payment',
                    'description' => 'Flexible payment options with easy installment plans'
                ],
                [
                    'icon' => '🎯',
                    'title' => 'Customizable',
                    'description' => 'Customize packages according to your preferences and budget'
                ],
                [
                    'icon' => '⭐',
                    'title' => 'Best Deals',
                    'description' => 'Exclusive deals and discounts for early bookings and groups'
                ]
            ];
            @endphp

            @foreach($features as $feature)
            <div class="text-center p-6">
                <div class="text-4xl mb-4">{{ $feature['icon'] }}</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">{{ $feature['title'] }}</h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $feature['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Call to Action Section --}}
<section class="py-16 bg-gradient-to-r from-purple-600 to-pink-600 dark:from-purple-800 dark:to-pink-800 text-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready for Your Dream Holiday?</h2>
            <p class="text-xl mb-8">Contact us today to plan your perfect getaway</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-lg text-center">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-2xl font-semibold mb-3">Call Our Experts</h3>
                <p class="text-3xl font-bold mb-4">+8809647668822</p>
                <p class="text-sm opacity-90">Speak to our travel consultants for personalized packages</p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-lg text-center">
                <div class="text-4xl mb-4">✉️</div>
                <h3 class="text-2xl font-semibold mb-3">Email Your Requirements</h3>
                <p class="text-xl mb-4">info@ecotravelsonline.com.bd</p>
                <p class="text-sm opacity-90">Send us your travel preferences for custom quotes</p>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="bg-white text-purple-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition-colors inline-block">
                Get Custom Package Quote
            </a>
        </div>
    </div>
</section>