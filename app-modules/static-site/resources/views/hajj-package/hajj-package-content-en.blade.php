{{-- Hero Section --}}
<section class="relative bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-800 dark:to-teal-800 text-white py-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Hajj & Umrah Packages</h1>
            <p class="text-xl md:text-2xl mb-8">Complete Hajj and Umrah Packages with Spiritual Journey Experience</p>
            <p class="text-lg mb-8">Sacred Journey • Expert Guidance • Comfortable Accommodation</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-lg font-semibold transition-colors">
                    View Hajj Packages
                </button>
                <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-emerald-800 px-8 py-3 rounded-lg font-semibold transition-colors">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Package Types Section --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Our Hajj & Umrah Packages</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Choose from our carefully designed packages for your spiritual journey</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 mb-12">
            @php
            $packageTypes = [
                [
                    'title' => 'Hajj Packages',
                    'description' => 'Complete Hajj packages with all necessary arrangements for your sacred pilgrimage',
                    'icon' => '🕋',
                    'duration' => '15-25 Days',
                    'price_range' => '4,50,000 - 8,00,000',
                    'features' => [
                        'Round-trip airfare from Dhaka',
                        'Accommodation in Makkah & Madinah',
                        'All meals included',
                        'Transportation within Saudi Arabia',
                        'Expert religious guidance',
                        'Group coordination',
                        'Hajj permit and visa processing',
                        'Medical assistance'
                    ],
                    'color' => 'emerald'
                ],
                [
                    'title' => 'Umrah Packages',
                    'description' => 'Spiritual Umrah packages for year-round pilgrimage with comfort and convenience',
                    'icon' => '🌙',
                    'duration' => '7-14 Days',
                    'price_range' => '85,000 - 2,50,000',
                    'features' => [
                        'Round-trip flights',
                        'Hotels near Haram',
                        'Daily breakfast & dinner',
                        'Airport transfers',
                        'Ziyarat (religious site visits)',
                        'Experienced tour guide',
                        'Umrah visa processing',
                        '24/7 customer support'
                    ],
                    'color' => 'teal'
                ]
            ];
            @endphp

            @foreach($packageTypes as $package)
            <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                <div class="text-center mb-6">
                    <div class="text-6xl mb-4">{{ $package['icon'] }}</div>
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-2">{{ $package['title'] }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $package['description'] }}</p>
                    <div class="mb-4">
                        <p class="text-lg font-bold text-{{ $package['color'] }}-600 dark:text-{{ $package['color'] }}-400">৳{{ $package['price_range'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Duration: {{ $package['duration'] }}</p>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-3">Package Includes:</h4>
                    <ul class="space-y-2">
                        @foreach($package['features'] as $feature)
                        <li class="flex items-start space-x-2">
                            <span class="text-green-500 mt-1">✓</span>
                            <span class="text-gray-600 dark:text-gray-300 text-sm">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <button class="w-full bg-{{ $package['color'] }}-600 hover:bg-{{ $package['color'] }}-700 text-white py-3 rounded-lg font-medium transition-colors">
                    View {{ $package['title'] }}
                </button>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Service Categories Section --}}
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Package Categories</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Different categories to suit your preferences and budget</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
            $categories = [
                [
                    'title' => 'Economy Package',
                    'description' => 'Budget-friendly packages with essential services',
                    'icon' => '💰',
                    'features' => [
                        'Standard accommodation',
                        'Shared transportation',
                        'Basic meal plan',
                        'Group guidance',
                        'Essential services'
                    ],
                    'hajj_price' => '4,50,000 - 5,50,000',
                    'umrah_price' => '85,000 - 1,20,000'
                ],
                [
                    'title' => 'Standard Package',
                    'description' => 'Comfortable packages with enhanced services',
                    'icon' => '⭐',
                    'features' => [
                        'Good quality hotels',
                        'Air-conditioned transport',
                        'Full meal plan',
                        'Experienced guide',
                        'Additional services'
                    ],
                    'hajj_price' => '5,50,000 - 6,50,000',
                    'umrah_price' => '1,20,000 - 1,80,000'
                ],
                [
                    'title' => 'Premium Package',
                    'description' => 'Luxury packages with VIP services',
                    'icon' => '👑',
                    'features' => [
                        '4-5 star hotels',
                        'Private transportation',
                        'Premium dining',
                        'Personal assistance',
                        'VIP services'
                    ],
                    'hajj_price' => '6,50,000 - 8,00,000',
                    'umrah_price' => '1,80,000 - 2,50,000'
                ]
            ];
            @endphp

            @foreach($categories as $category)
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                <div class="text-center mb-6">
                    <div class="text-4xl mb-4">{{ $category['icon'] }}</div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $category['title'] }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $category['description'] }}</p>
                </div>
                
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-3">Features:</h4>
                    <ul class="space-y-2">
                        @foreach($category['features'] as $feature)
                        <li class="flex items-center space-x-2">
                            <span class="text-green-500">✓</span>
                            <span class="text-gray-600 dark:text-gray-300 text-sm">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="space-y-3">
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded">
                        <p class="text-sm font-medium text-emerald-700 dark:text-emerald-300">Hajj Package</p>
                        <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400">৳{{ $category['hajj_price'] }}</p>
                    </div>
                    <div class="p-3 bg-teal-50 dark:bg-teal-900/20 rounded">
                        <p class="text-sm font-medium text-teal-700 dark:text-teal-300">Umrah Package</p>
                        <p class="text-lg font-bold text-teal-600 dark:text-teal-400">৳{{ $category['umrah_price'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Important Information Section --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Important Information</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Essential details for your Hajj & Umrah journey</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $importantInfo = [
                [
                    'icon' => '📋',
                    'title' => 'Required Documents',
                    'items' => [
                        'Valid passport (6+ months)',
                        'Vaccination certificates',
                        'Passport-sized photos',
                        'Marriage certificate (if applicable)',
                        'Mahram documents (for women)'
                    ]
                ],
                [
                    'icon' => '💉',
                    'title' => 'Health & Vaccination',
                    'items' => [
                        'COVID-19 vaccination',
                        'Meningitis vaccination',
                        'Yellow fever (if applicable)',
                        'Health insurance',
                        'Medical checkup'
                    ]
                ],
                [
                    'icon' => '🕐',
                    'title' => 'Best Times to Visit',
                    'items' => [
                        'Hajj: Dhul Hijjah month',
                        'Umrah: Year-round',
                        'Ramadan Umrah: Most blessed',
                        'Winter months: Cooler weather',
                        'Avoid summer: Very hot'
                    ]
                ],
                [
                    'icon' => '🎒',
                    'title' => 'What to Pack',
                    'items' => [
                        'Ihram clothing',
                        'Comfortable walking shoes',
                        'Sunscreen & hat',
                        'Personal medications',
                        'Prayer mat & Quran'
                    ]
                ]
            ];
            @endphp

            @foreach($importantInfo as $info)
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                <div class="text-center mb-4">
                    <div class="text-3xl mb-2">{{ $info['icon'] }}</div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $info['title'] }}</h3>
                </div>
                <ul class="space-y-2">
                    @foreach($info['items'] as $item)
                    <li class="flex items-start space-x-2">
                        <span class="text-emerald-500 mt-1">•</span>
                        <span class="text-gray-600 dark:text-gray-300 text-sm">{{ $item }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Why Choose Us Section --}}
<section class="py-16 bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-800 dark:to-teal-800 text-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Why Choose Eco Travel for Hajj & Umrah?</h2>
            <p class="text-xl">Your spiritual journey, our commitment</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $whyChooseUs = [
                [
                    'icon' => '🕌',
                    'title' => 'Expert Knowledge',
                    'description' => 'Years of experience in organizing Hajj & Umrah with deep religious understanding'
                ],
                [
                    'icon' => '🏨',
                    'title' => 'Prime Locations',
                    'description' => 'Hotels near Haram for easy access to Masjid Al-Haram and Masjid An-Nabawi'
                ],
                [
                    'icon' => '👨‍🏫',
                    'title' => 'Religious Guidance',
                    'description' => 'Experienced Islamic scholars and guides to assist throughout your journey'
                ],
                [
                    'icon' => '🛡️',
                    'title' => 'Complete Support',
                    'description' => '24/7 support team, medical assistance, and group coordination services'
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">Ready for Your Sacred Journey?</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">Contact us for detailed information and personalized packages</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">Call Our Hajj Department</h3>
                <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mb-4">+8809647668822</p>
                <p class="text-gray-600 dark:text-gray-300">Speak to our Hajj & Umrah specialists</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">✉️</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">Email Your Inquiry</h3>
                <p class="text-xl text-emerald-600 dark:text-emerald-400 mb-4">info@ecotravelsonline.com.bd</p>
                <p class="text-gray-600 dark:text-gray-300">Get detailed package information</p>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-block">
                Request Package Details
            </a>
        </div>
    </div>
</section>