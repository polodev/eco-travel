{{-- Hero Section --}}
<section class="relative text-white py-20 hero-gradient">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Better Service Experience</h1>
            <p class="text-xl md:text-2xl mb-8">Best deals on your Travel • Design Your Holiday With Us</p>
            <p class="text-lg mb-8">Explore Beautiful Bangladesh With us • Explore The Adventure Of the World</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('static-site::flight') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-lg font-semibold transition-colors">
                    Book Flights
                </a>
                <a href="{{ route('static-site::holiday-package') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-gray-900 px-8 py-3 rounded-lg font-semibold transition-colors">
                    Holiday Packages
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Services Section --}}
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Our Services</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Eco Travels Bangladesh is committed to provide cheap Air Ticket from all Airlines, with better service experience what matters to you.</p>
        </div>
        
        @php
        $services = [
            [
                'title' => 'Flight Bookings',
                'description' => 'Domestic and International Flight Bookings with cheap air tickets from all airlines',
                'icon' => '✈️',
                'link' => route('static-site::flight')
            ],
            [
                'title' => 'Holiday Packages',
                'description' => 'Amazing holiday packages to Thailand, Indonesia, India, Malaysia and more destinations',
                'icon' => '🏖️',
                'link' => route('static-site::holiday-package')
            ],
            [
                'title' => 'Hotel Booking',
                'description' => 'Premium hotel bookings with best deals and comfortable accommodations',
                'icon' => '🏨',
                'link' => route('static-site::hotel')
            ],
            [
                'title' => 'Hajj & Umrah',
                'description' => 'Complete Hajj and Umrah packages with spiritual journey experience',
                'icon' => '🕌',
                'link' => route('static-site::hajj-package')
            ],
            [
                'title' => 'Travel Insurance',
                'description' => 'Comprehensive travel insurance coverage for your peace of mind',
                'icon' => '🛡️',
                'link' => '#'
            ],
            [
                'title' => '24/7 Support',
                'description' => 'Round the clock customer support for all your travel needs',
                'icon' => '📞',
                'link' => '#'
            ]
        ];
        @endphp

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                <div class="text-4xl mb-4">{{ $service['icon'] }}</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">{{ $service['title'] }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $service['description'] }}</p>
                <a href="{{ $service['link'] }}" class="text-eco-green dark:text-eco-green hover:text-eco-green-dark dark:hover:text-eco-green-dark font-medium">
                    Learn More →
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Popular Routes Section --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Popular Flight Routes</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Best deals on domestic and international flights</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            {{-- Domestic Routes --}}
            <div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Domestic Routes</h3>
                @php
                $domesticRoutes = [
                    ['from' => 'Dhaka', 'to' => 'Cox Bazar', 'price' => '4,400'],
                    ['from' => 'Dhaka', 'to' => 'Chittagong', 'price' => '2,400'],
                    ['from' => 'Dhaka', 'to' => 'Sylhet', 'price' => '2,400'],
                    ['from' => 'Dhaka', 'to' => 'Rajshahi', 'price' => '2,200']
                ];
                @endphp
                
                @foreach($domesticRoutes as $route)
                <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-3">
                    <div class="flex items-center space-x-3">
                        <span class="text-lg">🛫</span>
                        <span class="font-medium text-gray-800 dark:text-white">{{ $route['from'] }} → {{ $route['to'] }}</span>
                    </div>
                    <span class="text-lg font-bold text-eco-green dark:text-eco-green">৳{{ $route['price'] }}</span>
                </div>
                @endforeach
            </div>

            {{-- International Routes --}}
            <div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">International Routes</h3>
                @php
                $internationalRoutes = [
                    ['from' => 'Dhaka', 'to' => 'Kolkata', 'region' => 'India'],
                    ['from' => 'Dhaka', 'to' => 'Mumbai', 'region' => 'India'],
                    ['from' => 'Dhaka', 'to' => 'Bangkok', 'region' => 'Thailand'],
                    ['from' => 'Dhaka', 'to' => 'Dubai', 'region' => 'UAE']
                ];
                @endphp
                
                @foreach($internationalRoutes as $route)
                <div class="flex justify-between items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-3">
                    <div class="flex items-center space-x-3">
                        <span class="text-lg">🌍</span>
                        <div>
                            <span class="font-medium text-gray-800 dark:text-white block">{{ $route['from'] }} → {{ $route['to'] }}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $route['region'] }}</span>
                        </div>
                    </div>
                    <a href="{{ route('static-site::flight') }}" class="text-eco-green dark:text-eco-green hover:text-eco-green-dark dark:hover:text-eco-green-dark font-medium">
                        Book Now
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Quote Section --}}
<section class="py-16 hero-gradient text-white">
    <div class="container mx-auto px-4 text-center">
        <blockquote class="text-2xl md:text-3xl font-light italic mb-6 text-white">
            "Do not follow where the path may lead. Go instead where there is no path and leave a trail"
        </blockquote>
        <cite class="text-lg text-white">– Ralph Waldo Emerson</cite>
    </div>
</section>

{{-- 24/7 Support Section --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <div class="hero-gradient text-white p-12 rounded-2xl shadow-xl">
                <div class="text-6xl mb-6">🎧</div>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">24/7 Support</h2>
                <p class="text-xl md:text-2xl mb-8 opacity-90">Round-the-clock customer support for all your travel needs</p>
                <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" 
                   class="inline-flex items-center bg-white text-emerald-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition-colors text-lg">
                    Learn More
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Contact Section --}}
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Contact Us</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">We're here to help you plan your perfect journey</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 text-center">
            <div class="p-6">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Helpline</h3>
                <p class="text-eco-green dark:text-eco-green text-lg font-medium">+8809647668822</p>
            </div>
            
            <div class="p-6">
                <div class="text-4xl mb-4">✉️</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Email</h3>
                <p class="text-eco-green dark:text-eco-green">info@ecotravelsonline.com.bd</p>
            </div>
            
            <div class="p-6">
                <div class="text-4xl mb-4">🌍</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Global Presence</h3>
                <p class="text-gray-600 dark:text-gray-300">Bangladesh • New Zealand • Australia • India</p>
            </div>
        </div>
    </div>
</section>