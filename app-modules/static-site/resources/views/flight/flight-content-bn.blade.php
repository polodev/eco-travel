{{-- Hero Section --}}
<section class="relative bg-gradient-to-r from-sky-600 to-blue-600 dark:from-sky-800 dark:to-blue-800 text-white py-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">ফ্লাইট বুকিং সেবা</h1>
            <p class="text-xl md:text-2xl mb-8">সকল এয়ারলাইন্স থেকে সাশ্রয়ী এয়ার টিকেট উন্নত সেবার অভিজ্ঞতা সহ</p>
            <p class="text-lg mb-8">২৪x৭ গ্রাহক সহায়তা • দেশি ও আন্তর্জাতিক ফ্লাইট</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-lg font-semibold transition-colors">
                    ফ্লাইট খুঁজুন
                </button>
                <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-800 px-8 py-3 rounded-lg font-semibold transition-colors">
                    যোগাযোগ করুন
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Services Overview --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">আমাদের ফ্লাইট সেবাসমূহ</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">সকল এয়ারলাইন্স থেকে সাশ্রয়ী এয়ার টিকেট প্রদান এবং উন্নত সেবার অভিজ্ঞতা দিতে প্রতিশ্রুতিবদ্ধ</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
            $services = [
                [
                    'title' => 'দেশীয় ফ্লাইট',
                    'description' => 'বাংলাদেশের সকল প্রধান শহরে দেশীয় ফ্লাইটের সেরা অফার',
                    'icon' => '🏠',
                    'features' => ['সকল প্রধান শহর', 'সেরা দাম', 'দ্রুত বুকিং', 'তাৎক্ষণিক নিশ্চিতকরণ']
                ],
                [
                    'title' => 'আন্তর্জাতিক ফ্লাইট',
                    'description' => 'চমৎকার অফার সহ আপনার পছন্দের আন্তর্জাতিক গন্তব্যে উড়ান',
                    'icon' => '🌍',
                    'features' => ['বিশ্বব্যাপী গন্তব্য', 'একাধিক এয়ারলাইন্স', 'প্রতিযোগিতামূলক দাম', '২৪/৭ সহায়তা']
                ],
                [
                    'title' => 'বিশেষ সেবা',
                    'description' => 'আপনার যাত্রাকে আরামদায়ক এবং ঝামেলামুক্ত করার অতিরিক্ত সেবা',
                    'icon' => '⭐',
                    'features' => ['গ্রুপ বুকিং', 'সিট নির্বাচন', 'খাবারের পছন্দ', 'ট্রাভেল ইন্স্যুরেন্স']
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">জনপ্রিয় দেশীয় রুট</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">বাংলাদেশের মধ্যে দেশীয় ফ্লাইটের সেরা দাম</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $domesticRoutes = [
                ['from' => 'ঢাকা', 'to' => 'কক্সবাজার', 'price' => '৪,৪০০', 'duration' => '১ঘ ২০মি'],
                ['from' => 'ঢাকা', 'to' => 'চট্টগ্রাম', 'price' => '২,৪০০', 'duration' => '৫০মি'],
                ['from' => 'ঢাকা', 'to' => 'সিলেট', 'price' => '২,৪০০', 'duration' => '৪৫মি'],
                ['from' => 'ঢাকা', 'to' => 'রাজশাহী', 'price' => '২,২০০', 'duration' => '৫৫মি'],
                ['from' => 'ঢাকা', 'to' => 'যশোর', 'price' => '২,২০০', 'duration' => '৫০মি'],
                ['from' => 'ঢাকা', 'to' => 'বরিশাল', 'price' => '২,২০০', 'duration' => '৪৫মি']
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
                        <p class="text-xs text-gray-500 dark:text-gray-400">শুরু হতে</p>
                    </div>
                </div>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium transition-colors">
                    এখনই বুক করুন
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">আন্তর্জাতিক গন্তব্য</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">বিশ্বব্যাপী অসাধারণ গন্তব্যে উড়ান</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $internationalDestinations = [
                ['country' => 'ভারত', 'cities' => ['কলকাতা', 'মুম্বাই', 'চেন্নাই', 'দিল্লি'], 'flag' => '🇮🇳'],
                ['country' => 'থাইল্যান্ড', 'cities' => ['ব্যাংকক'], 'flag' => '🇹🇭'],
                ['country' => 'মালয়েশিয়া', 'cities' => ['কুয়ালালামপুর'], 'flag' => '🇲🇾'],
                ['country' => 'সিঙ্গাপুর', 'cities' => ['সিঙ্গাপুর'], 'flag' => '🇸🇬'],
                ['country' => 'সংযুক্ত আরব আমিরাত', 'cities' => ['দুবাই'], 'flag' => '🇦🇪'],
                ['country' => 'কাতার', 'cities' => ['দোহা'], 'flag' => '🇶🇦'],
                ['country' => 'সৌদি আরব', 'cities' => ['জেদ্দাহ'], 'flag' => '🇸🇦'],
                ['country' => 'ওমান', 'cities' => ['মাসকাট'], 'flag' => '🇴🇲']
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
                    ফ্লাইট দেখুন
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
            <h2 class="text-3xl md:text-4xl font-bold mb-4">কেন ইকো ট্রাভেল বেছে নিবেন?</h2>
            <p class="text-xl">ফ্লাইট বুকিংয়ের জন্য আপনার বিশ্বস্ত সঙ্গী</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $whyChooseUs = [
                [
                    'icon' => '💰',
                    'title' => 'সেরা দাম',
                    'description' => 'প্রতিযোগিতামূলক মূল্যে সকল এয়ারলাইন্স থেকে সাশ্রয়ী এয়ার টিকেট'
                ],
                [
                    'icon' => '⏰',
                    'title' => '২৪/৭ সহায়তা',
                    'description' => 'আপনার সকল প্রয়োজনের জন্য ২৪ ঘন্টা গ্রাহক সহায়তা'
                ],
                [
                    'icon' => '✈️',
                    'title' => 'সকল এয়ারলাইন্স',
                    'description' => 'সকল প্রধান দেশি ও আন্তর্জাতিক এয়ারলাইন্সে অ্যাক্সেস'
                ],
                [
                    'icon' => '🛡️',
                    'title' => 'নিরাপদ বুকিং',
                    'description' => 'তাৎক্ষণিক নিশ্চিতকরণ সহ নিরাপদ এবং সুরক্ষিত বুকিং প্রক্রিয়া'
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">আপনার ফ্লাইট বুক করতে প্রস্তুত?</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">সেরা অফার এবং ব্যক্তিগত সেবার জন্য আমাদের সাথে যোগাযোগ করুন</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">এখনই কল করুন</h3>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-4">+৮৮০৯৬৪৭৬৬৮৮২২</p>
                <p class="text-gray-600 dark:text-gray-300">ফ্লাইট বুকিংয়ের জন্য ২৪/৭ উপলব্ধ</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">✉️</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">ইমেইল করুন</h3>
                <p class="text-xl text-blue-600 dark:text-blue-400 mb-4">info@ecotravelsonline.com.bd</p>
                <p class="text-gray-600 dark:text-gray-300">আপনার ভ্রমণের প্রয়োজনীয়তা আমাদের পাঠান</p>
            </div>
        </div>
    </div>
</section>