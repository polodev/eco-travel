{{-- Hero Section --}}
<section class="relative bg-gradient-to-r from-purple-600 to-pink-600 dark:from-purple-800 dark:to-pink-800 text-white py-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">হলিডে প্যাকেজ</h1>
            <p class="text-xl md:text-2xl mb-8">সারা বছর রোমাঞ্চকর অফার সহ অসাধারণ গন্তব্য অন্বেষণ করুন</p>
            <p class="text-lg mb-8">থাইল্যান্ড • ইন্দোনেশিয়া • ভারত • মালয়েশিয়া • মালদ্বীপ • আরো অনেক!</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-lg font-semibold transition-colors">
                    প্যাকেজ অন্বেষণ করুন
                </button>
                <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-purple-800 px-8 py-3 rounded-lg font-semibold transition-colors">
                    কাস্টম কোটেশন নিন
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Popular Destinations Section --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">জনপ্রিয় গন্তব্যসমূহ</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">বিশ্বজুড়ে শ্বাসরুদ্ধকর গন্তব্যগুলি আবিষ্কার করুন</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $destinations = [
                [
                    'name' => 'থাইল্যান্ড',
                    'packages' => 4,
                    'price_from' => '২০,০০০',
                    'duration' => '৫-৭ দিন',
                    'highlights' => ['ব্যাংকক', 'পাতায়া', 'ফুকেট'],
                    'flag' => '🇹🇭'
                ],
                [
                    'name' => 'ইন্দোনেশিয়া',
                    'packages' => 4,
                    'price_from' => '২৫,০০০',
                    'duration' => '৬-৮ দিন',
                    'highlights' => ['বালি', 'নুসা পেনিডা', 'জাকার্তা'],
                    'flag' => '🇮🇩'
                ],
                [
                    'name' => 'ভারত',
                    'packages' => 4,
                    'price_from' => '১৫,০০০',
                    'duration' => '৪-৬ দিন',
                    'highlights' => ['দিল্লি', 'আগ্রা', 'কাশ্মীর'],
                    'flag' => '🇮🇳'
                ],
                [
                    'name' => 'মালয়েশিয়া',
                    'packages' => 4,
                    'price_from' => '৩০,০০০',
                    'duration' => '৫-৭ দিন',
                    'highlights' => ['কুয়ালালামপুর', 'পেনাং', 'লাংকাউই'],
                    'flag' => '🇲🇾'
                ],
                [
                    'name' => 'মালদ্বীপ',
                    'packages' => 4,
                    'price_from' => '৮০,০০০',
                    'duration' => '৪-৬ দিন',
                    'highlights' => ['ওয়াটার ভিলা', 'বিচ রিসোর্ট', 'কোরাল রিফ'],
                    'flag' => '🇲🇻'
                ],
                [
                    'name' => 'নেপাল',
                    'packages' => 4,
                    'price_from' => '১৮,০০০',
                    'duration' => '৫-৭ দিন',
                    'highlights' => ['কাঠমান্ডু', 'পোখরা', 'চিতওয়ান'],
                    'flag' => '🇳🇵'
                ],
                [
                    'name' => 'জাপান',
                    'packages' => 4,
                    'price_from' => '১,৫০,০০০',
                    'duration' => '৭-১০ দিন',
                    'highlights' => ['টোকিও', 'হিরোশিমা', 'কিয়োটো'],
                    'flag' => '🇯🇵'
                ],
                [
                    'name' => 'তুরস্ক',
                    'packages' => 4,
                    'price_from' => '১,২০,০০০',
                    'duration' => '৮-১০ দিন',
                    'highlights' => ['ইস্তাম্বুল', 'ক্যাপাডোকিয়া', 'আন্তালিয়া'],
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
                        <p>{{ $destination['packages'] }}টি প্যাকেজ উপলব্ধ</p>
                        <p>সময়কাল: {{ $destination['duration'] }}</p>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">বিশেষত্ব:</h4>
                        <div class="flex flex-wrap gap-1">
                            @foreach($destination['highlights'] as $highlight)
                            <span class="text-xs bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-2 py-1 rounded">{{ $highlight }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-lg font-bold text-purple-600 dark:text-purple-400">৳{{ $destination['price_from'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">শুরু হতে</p>
                        </div>
                        <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            প্যাকেজ দেখুন
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">প্যাকেজের ধরন</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">আমাদের যত্নসহকারে তৈরি হলিডে প্যাকেজ থেকে বেছে নিন</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
            $packageTypes = [
                [
                    'title' => 'বাজেট প্যাকেজ',
                    'description' => 'অভিজ্ঞতার সাথে আপস না করে সাশ্রয়ী প্যাকেজ',
                    'icon' => '💰',
                    'price_range' => '১৫,০০০ - ৫০,০০০',
                    'features' => ['স্ট্যান্ডার্ড হোটেল', '৩-৫ দিন', 'গ্রুপ ট্যুর', 'সাধারণ খাবার'],
                    'destinations' => ['ভারত', 'নেপাল', 'থাইল্যান্ড']
                ],
                [
                    'title' => 'প্রিমিয়াম প্যাকেজ',
                    'description' => 'প্রিমিয়াম আবাসন সহ বিলাসবহুল অভিজ্ঞতা',
                    'icon' => '⭐',
                    'price_range' => '৮০,০০০ - ২,০০,০০০',
                    'features' => ['৫-স্টার হোটেল', '৭-১০ দিন', 'প্রাইভেট ট্যুর', 'ফাইন ডাইনিং'],
                    'destinations' => ['মালদ্বীপ', 'জাপান', 'ইউরোপ']
                ],
                [
                    'title' => 'পারিবারিক প্যাকেজ',
                    'description' => 'পারিবারিক ছুটির জন্য ডিজাইন করা নিখুঁত প্যাকেজ',
                    'icon' => '👨‍👩‍👧‍👦',
                    'price_range' => '২৫,০০০ - ১,৫০,০০০',
                    'features' => ['ফ্যামিলি রুম', '৫-৮ দিন', 'শিশু-বান্ধব', 'সব খাবার'],
                    'destinations' => ['মালয়েশিয়া', 'ইন্দোনেশিয়া', 'তুরস্ক']
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
                    <p class="text-sm text-gray-500 dark:text-gray-400">প্রতি ব্যক্তি</p>
                </div>
                
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-3">প্যাকেজে অন্তর্ভুক্ত:</h4>
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
                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">জনপ্রিয় গন্তব্য:</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($type['destinations'] as $dest)
                        <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded">{{ $dest }}</span>
                        @endforeach
                    </div>
                </div>

                <button class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg font-medium transition-colors">
                    {{ $type['title'] }} অন্বেষণ করুন
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">কেন আমাদের হলিডে প্যাকেজ বেছে নিবেন?</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">আমাদের ব্যাপক প্যাকেজগুলির সাথে ঝামেলামুক্ত ছুটির অভিজ্ঞতা নিন</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $features = [
                [
                    'icon' => '✈️',
                    'title' => 'সব-অন্তর্ভুক্ত',
                    'description' => 'ফ্লাইট, হোটেল, খাবার এবং ট্রান্সফার এক প্যাকেজে অন্তর্ভুক্ত'
                ],
                [
                    'icon' => '🗺️',
                    'title' => 'বিশেষজ্ঞ গাইড',
                    'description' => 'প্রতিটি গন্তব্যের সেরা দিকগুলো দেখানোর জন্য স্থানীয় বিশেষজ্ঞ গাইড'
                ],
                [
                    'icon' => '🏨',
                    'title' => 'মানসম্পন্ন হোটেল',
                    'description' => 'চমৎকার রেটিং এবং সুবিধা সহ হাতে-বাছাই করা ৩-৫ স্টার হোটেল'
                ],
                [
                    'icon' => '🛡️',
                    'title' => 'ট্রাভেল ইন্স্যুরেন্স',
                    'description' => 'মানসিক শান্তির জন্য ব্যাপক ট্রাভেল ইন্স্যুরেন্স কভারেজ'
                ],
                [
                    'icon' => '📞',
                    'title' => '২৪/৭ সহায়তা',
                    'description' => 'আপনার সম্পূর্ণ যাত্রায় ২৪ ঘন্টা গ্রাহক সহায়তা'
                ],
                [
                    'icon' => '💳',
                    'title' => 'সহজ পেমেন্ট',
                    'description' => 'সহজ কিস্তি পরিকল্পনা সহ নমনীয় পেমেন্ট বিকল্প'
                ],
                [
                    'icon' => '🎯',
                    'title' => 'কাস্টমাইজেবল',
                    'description' => 'আপনার পছন্দ এবং বাজেট অনুযায়ী প্যাকেজ কাস্টমাইজ করুন'
                ],
                [
                    'icon' => '⭐',
                    'title' => 'সেরা অফার',
                    'description' => 'আর্ল্য বুকিং এবং গ্রুপের জন্য এক্সক্লুসিভ অফার এবং ছাড়'
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
            <h2 class="text-3xl md:text-4xl font-bold mb-4">আপনার স্বপ্নের ছুটির জন্য প্রস্তুত?</h2>
            <p class="text-xl mb-8">আপনার নিখুঁত ছুটির পরিকল্পনা করতে আজই আমাদের সাথে যোগাযোগ করুন</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-lg text-center">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-2xl font-semibold mb-3">আমাদের বিশেষজ্ঞদের কল করুন</h3>
                <p class="text-3xl font-bold mb-4">+৮৮০৯৬৪৭৬৬৮৮২২</p>
                <p class="text-sm opacity-90">ব্যক্তিগত প্যাকেজের জন্য আমাদের ট্রাভেল কনসালট্যান্টদের সাথে কথা বলুন</p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-lg text-center">
                <div class="text-4xl mb-4">✉️</div>
                <h3 class="text-2xl font-semibold mb-3">আপনার প্রয়োজনীয়তা ইমেইল করুন</h3>
                <p class="text-xl mb-4">info@ecotravelsonline.com.bd</p>
                <p class="text-sm opacity-90">কাস্টম কোটেশনের জন্য আমাদের আপনার ভ্রমণ পছন্দ পাঠান</p>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="bg-white text-purple-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition-colors inline-block">
                কাস্টম প্যাকেজ কোটেশন পান
            </a>
        </div>
    </div>
</section>