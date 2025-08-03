{{-- Hero Section --}}
<section class="relative bg-gradient-to-r from-green-600 to-teal-600 dark:from-green-800 dark:to-teal-800 text-white py-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">হোটেল বুকিং সেবা</h1>
            <p class="text-xl md:text-2xl mb-8">সেরা অফার এবং আরামদায়ক থাকার ব্যবস্থা সহ প্রিমিয়াম হোটেল</p>
            <p class="text-lg mb-8">৫-স্টার হোটেল • সেরা অবস্থান • তাৎক্ষণিক নিশ্চিতকরণ</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-lg font-semibold transition-colors">
                    হোটেল খুঁজুন
                </button>
                <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-green-800 px-8 py-3 rounded-lg font-semibold transition-colors">
                    যোগাযোগ করুন
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Featured Hotels Section --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">বিশেষ হোটেলসমূহ</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">আমাদের নির্বাচিত প্রিমিয়াম হোটেলগুলি আবিষ্কার করুন</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $featuredHotels = [
                [
                    'name' => 'হোটেল দ্য কক্স টুডে',
                    'location' => 'কক্সবাজার',
                    'price' => '৫,০০০',
                    'rating' => '৫ স্টার',
                    'guests' => '২ জন',
                    'image' => '/images/static-site/hotel/cox-today.jpg'
                ],
                [
                    'name' => 'গ্র্যান্ড সুলতান টি রিসোর্ট',
                    'location' => 'সিলেট',
                    'price' => '১৮,০০০',
                    'rating' => '৫ স্টার',
                    'guests' => '২ জন',
                    'image' => '/images/static-site/hotel/grand-sultan.jpg'
                ],
                [
                    'name' => 'ওশান প্যারাডাইস',
                    'location' => 'কক্সবাজার',
                    'price' => '১০,০০০',
                    'rating' => '৫ স্টার',
                    'guests' => '২ জন',
                    'image' => '/images/static-site/hotel/ocean-paradise.jpg'
                ],
                [
                    'name' => 'সি পার্ল কক্সবাজার',
                    'location' => 'ইনানী, কক্সবাজার',
                    'price' => '১৫,০০০',
                    'rating' => '৫ স্টার',
                    'guests' => '২ জন',  
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
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">সর্বনিম্ন {{ $hotel['guests'] }}</p>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">৳{{ $hotel['price'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">প্রতি রাত</p>
                        </div>
                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            এখনই বুক করুন
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">জনপ্রিয় গন্তব্যসমূহ</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">শীর্ষ গন্তব্যে অসাধারণ হোটেল অন্বেষণ করুন</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            @php
            $destinations = [
                [
                    'name' => 'কক্সবাজার',
                    'description' => 'বিশ্বের দীর্ঘতম প্রাকৃতিক সমুদ্র সৈকত',
                    'hotels' => 15,
                    'icon' => '🏖️',
                    'features' => ['সমুদ্র সৈকত', 'সূর্যাস্তের দৃশ্য', 'জল ক্রীড়া', 'স্থানীয় খাবার']
                ],
                [
                    'name' => 'সিলেট',
                    'description' => 'দুই পাতা এক কুঁড়ির দেশ',
                    'hotels' => 8,
                    'icon' => '🍃',
                    'features' => ['চা বাগান', 'পাহাড়', 'হ্রদ', 'প্রাকৃতিক সৌন্দর্য']
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
                        <p class="text-sm text-green-600 dark:text-green-400">{{ $destination['hotels'] }}টি হোটেল উপলব্ধ</p>
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
                    {{ $destination['name'] }}-এ হোটেল দেখুন
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">আমাদের হোটেল সেবাসমূহ</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">নিখুঁত থাকার জন্য আপনার প্রয়োজনীয় সবকিছু</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
            $services = [
                [
                    'title' => 'সেরা দামের গ্যারান্টি',
                    'description' => 'সকল হোটেল বুকিংয়ের জন্য আমরা সেরা দামের গ্যারান্টি দিই',
                    'icon' => '💰',
                    'features' => ['দাম মিলান', 'কোন লুকানো ফি নেই', 'সেরা অফার', 'তাৎক্ষণিক সাশ্রয়']
                ],
                [
                    'title' => 'প্রিমিয়াম অবস্থান',
                    'description' => 'আকর্ষণীয় স্থানগুলিতে সহজ প্রবেশাধিকার সহ সেরা অবস্থানে হোটেল',
                    'icon' => '📍',
                    'features' => ['প্রধান অবস্থান', 'শহরের কেন্দ্র', 'পর্যটন এলাকা', 'সহজ প্রবেশ']
                ],
                [
                    'title' => '৫-স্টার অভিজ্ঞতা',
                    'description' => 'বিশ্বমানের সুবিধা সহ বিলাসবহুল আবাসন',
                    'icon' => '⭐',
                    'features' => ['বিলাসবহুল রুম', 'প্রিমিয়াম সুবিধা', 'চমৎকার সেবা', 'উন্নত খাবার']
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
            <h2 class="text-3xl md:text-4xl font-bold mb-4">কেন আমাদের হোটেল বুকিং বেছে নিবেন?</h2>
            <p class="text-xl">আপনার আরাম আমাদের অগ্রাধিকার</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $whyChooseUs = [
                [
                    'icon' => '🏨',
                    'title' => '৫-স্টার হোটেল',
                    'description' => 'বিলাসবহুল সুবিধা এবং সেবা সহ প্রিমিয়াম আবাসন'
                ],
                [
                    'icon' => '💳',
                    'title' => 'সহজ বুকিং',
                    'description' => 'তাৎক্ষণিক নিশ্চিতকরণ সহ সহজ এবং নিরাপদ অনলাইন বুকিং প্রক্রিয়া'
                ],
                [
                    'icon' => '📞',
                    'title' => '২৪/৭ সহায়তা',
                    'description' => 'আপনার সকল হোটেল প্রয়োজনের জন্য ২ৄ ঘন্টা গ্রাহক সহায়তা'
                ],
                [
                    'icon' => '🛡️',
                    'title' => 'নিরাপদ পেমেন্ট',
                    'description' => 'একাধিক বিকল্প সহ নিরাপদ এবং সুরক্ষিত পেমেন্ট প্রক্রিয়াজাতকরণ'
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">আপনার হোটেল বুক করতে প্রস্তুত?</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">সেরা হোটেল অফার এবং ব্যক্তিগত সেবার জন্য আমাদের সাথে যোগাযোগ করুন</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">এখনই কল করুন</h3>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mb-4">+৮৮০৯৬৪৭৬৬৮৮২২</p>
                <p class="text-gray-600 dark:text-gray-300">হোটেল বুকিংয়ের জন্য ২৪/৭ উপলব্ধ</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">✉️</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">ইমেইল করুন</h3>
                <p class="text-xl text-green-600 dark:text-green-400 mb-4">info@ecotravelsonline.com.bd</p>
                <p class="text-gray-600 dark:text-gray-300">আপনার হোটেলের প্রয়োজনীয়তা আমাদের পাঠান</p>
            </div>
        </div>
    </div>
</section>