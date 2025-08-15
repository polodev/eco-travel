{{-- Hero Section --}}
<section class="relative text-white py-20 hero-gradient">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">উন্নত সার্ভিসের অভিজ্ঞতা</h1>
            <p class="text-xl md:text-2xl mb-8">আপনার ভ্রমণে সেরা অফার • আমাদের সাথে আপনার ছুটির দিন ডিজাইন করুন</p>
            <p class="text-lg mb-8">আমাদের সাথে সুন্দর বাংলাদেশ আবিষ্কার করুন • বিশ্বের অ্যাডভেঞ্চার আবিষ্কার করুন</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('static-site::flight') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-lg font-semibold transition-colors">
                    ফ্লাইট বুক করুন
                </a>
                <a href="{{ route('static-site::holiday-package') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-gray-900 px-8 py-3 rounded-lg font-semibold transition-colors">
                    হলিডে প্যাকেজ
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Services Section --}}
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">আমাদের সার্ভিসসমূহ</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">ইকো ট্রাভেলস বাংলাদেশ সকল এয়ারলাইন্স থেকে সাশ্রয়ী এয়ার টিকেট প্রদান এবং উন্নত সার্ভিসের অভিজ্ঞতা দিতে প্রতিশ্রুতিবদ্ধ।</p>
        </div>
        
        @php
        $services = [
            [
                'title' => 'ফ্লাইট বুকিং',
                'description' => 'দেশি ও আন্তর্জাতিক ফ্লাইট বুকিং সাশ্রয়ী দামে সকল এয়ারলাইন্স থেকে',
                'icon' => '✈️',
                'link' => route('static-site::flight')
            ],
            [
                'title' => 'হলিডে প্যাকেজ',
                'description' => 'থাইল্যান্ড, ইন্দোনেশিয়া, ভারত, মালয়েশিয়া এবং আরও গন্তব্যে অসাধারণ হলিডে প্যাকেজ',
                'icon' => '🏖️',
                'link' => route('static-site::holiday-package')
            ],
            [
                'title' => 'হোটেল বুকিং',
                'description' => 'সেরা দামে প্রিমিয়াম হোটেল বুকিং এবং আরামদায়ক থাকার ব্যবস্থা',
                'icon' => '🏨',
                'link' => route('static-site::hotel')
            ],
            [
                'title' => 'হজ ও উমরাহ',
                'description' => 'আধ্যাত্মিক যাত্রার অভিজ্ঞতা সহ সম্পূর্ণ হজ ও উমরাহ প্যাকেজ',
                'icon' => '🕌',
                'link' => route('static-site::hajj-package')
            ],
            [
                'title' => 'ট্রাভেল ইন্স্যুরেন্স',
                'description' => 'আপনার মানসিক শান্তির জন্য ব্যাপক ট্রাভেল ইন্স্যুরেন্স কভারেজ',
                'icon' => '🛡️',
                'link' => '#'
            ],
            [
                'title' => '২৪/৭ সহায়তা',
                'description' => 'আপনার সকল ভ্রমণ প্রয়োজনের জন্য ২৪ ঘন্টা গ্রাহক সহায়তা',
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
                    আরও জানুন →
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">জনপ্রিয় ফ্লাইট রুট</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">দেশি ও আন্তর্জাতিক ফ্লাইটে সেরা অফার</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            {{-- Domestic Routes --}}
            <div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">দেশীয় রুট</h3>
                @php
                $domesticRoutes = [
                    ['from' => 'ঢাকা', 'to' => 'কক্সবাজার', 'price' => '৪,৪০০'],
                    ['from' => 'ঢাকা', 'to' => 'চট্টগ্রাম', 'price' => '২,৪০০'],
                    ['from' => 'ঢাকা', 'to' => 'সিলেট', 'price' => '২,৪০০'],
                    ['from' => 'ঢাকা', 'to' => 'রাজশাহী', 'price' => '২,২০০']
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
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">আন্তর্জাতিক রুট</h3>
                @php
                $internationalRoutes = [
                    ['from' => 'ঢাকা', 'to' => 'কলকাতা', 'region' => 'ভারত'],
                    ['from' => 'ঢাকা', 'to' => 'মুম্বাই', 'region' => 'ভারত'],
                    ['from' => 'ঢাকা', 'to' => 'ব্যাংকক', 'region' => 'থাইল্যান্ড'],
                    ['from' => 'ঢাকা', 'to' => 'দুবাই', 'region' => 'সংযুক্ত আরব আমিরাত']
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
                        এখনই বুক করুন
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Quote Section --}}
<section class="py-16 bg-gradient-to-r from-eco-green to-eco-green-dark dark:from-eco-green-dark dark:to-eco-green text-white">
    <div class="container mx-auto px-4 text-center">
        <blockquote class="text-2xl md:text-3xl font-light italic mb-6">
            "যেখানে পথ যেতে পারে সেই পথ অনুসরণ করো না। বরং যেখানে কোনো পথ নেই সেখানে গিয়ে একটি পথ রেখে এসো"
        </blockquote>
        <cite class="text-lg">– রালফ ওয়ালডো এমারসন</cite>
    </div>
</section>

{{-- 24/7 Support Section --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <div class="bg-gradient-to-r from-eco-green to-eco-green-dark dark:from-eco-green-dark dark:to-eco-green text-white p-12 rounded-2xl shadow-xl">
                <div class="text-6xl mb-6">🎧</div>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">২৪/৭ সহায়তা</h2>
                <p class="text-xl md:text-2xl mb-8 opacity-90">আপনার সকল ভ্রমণ প্রয়োজনের জন্য ২৪ ঘন্টা গ্রাহক সহায়তা</p>
                <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" 
                   class="inline-flex items-center bg-white text-emerald-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition-colors text-lg">
                    আরও জানুন
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">যোগাযোগ করুন</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">আপনার নিখুঁত যাত্রা পরিকল্পনা করতে আমরা এখানে আছি</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 text-center">
            <div class="p-6">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">হেল্পলাইন</h3>
                <p class="text-eco-green dark:text-eco-green text-lg font-medium">+৮৮০৯৬৪৭৬৬৮৮২২</p>
            </div>
            
            <div class="p-6">
                <div class="text-4xl mb-4">✉️</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">ইমেইল</h3>
                <p class="text-eco-green dark:text-eco-green">info@ecotravelsonline.com.bd</p>
            </div>
            
            <div class="p-6">
                <div class="text-4xl mb-4">🌍</div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">বিশ্বব্যাপী উপস্থিতি</h3>
                <p class="text-gray-600 dark:text-gray-300">বাংলাদেশ • নিউজিল্যান্ড • অস্ট্রেলিয়া • ভারত</p>
            </div>
        </div>
    </div>
</section>