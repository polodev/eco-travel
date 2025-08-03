{{-- Hero Section --}}
<section class="relative bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-800 dark:to-teal-800 text-white py-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative container mx-auto px-4">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">হজ ও উমরাহ প্যাকেজ</h1>
            <p class="text-xl md:text-2xl mb-8">আধ্যাত্মিক যাত্রার অভিজ্ঞতা সহ সম্পূর্ণ হজ ও উমরাহ প্যাকেজ</p>
            <p class="text-lg mb-8">পবিত্র যাত্রা • বিশেষজ্ঞ গাইডেন্স • আরামদায়ক থাকার ব্যবস্থা</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-black px-8 py-3 rounded-lg font-semibold transition-colors">
                    হজ প্যাকেজ দেখুন
                </button>
                <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-emerald-800 px-8 py-3 rounded-lg font-semibold transition-colors">
                    যোগাযোগ করুন
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Package Types Section --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">আমাদের হজ ও উমরাহ প্যাকেজ</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">আপনার আধ্যাত্মিক যাত্রার জন্য যত্নসহকারে ডিজাইন করা প্যাকেজগুলি থেকে বেছে নিন</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 mb-12">
            @php
            $packageTypes = [
                [
                    'title' => 'হজ প্যাকেজ',
                    'description' => 'আপনার পবিত্র হজ যাত্রার জন্য সকল প্রয়োজনীয় ব্যবস্থা সহ সম্পূর্ণ হজ প্যাকেজ',
                    'icon' => '🕋',
                    'duration' => '১৫-২৫ দিন',
                    'price_range' => '৪,৫০,০০০ - ৮,০০,০০০',
                    'features' => [
                        'ঢাকা থেকে রাউন্ড-ট্রিপ বিমান ভাড়া',
                        'মক্কা ও মদিনায় থাকার ব্যবস্থা',
                        'সকল খাবার অন্তর্ভুক্ত',
                        'সৌদি আরবের মধ্যে পরিবহন',
                        'বিশেষজ্ঞ ধর্মীয় গাইডেন্স',
                        'গ্রুপ কোঅর্ডিনেশন',
                        'হজ পারমিট ও ভিসা প্রক্রিয়াকরণ',
                        'চিকিৎসা সহায়তা'
                    ],
                    'color' => 'emerald'
                ],
                [
                    'title' => 'উমরাহ প্যাকেজ',
                    'description' => 'আরাম ও সুবিধা সহ সারা বছরের তীর্থযাত্রার জন্য আধ্যাত্মিক উমরাহ প্যাকেজ',
                    'icon' => '🌙',
                    'duration' => '৭-১৪ দিন',
                    'price_range' => '৮৫,০০০ - ২,৫০,০০০',
                    'features' => [
                        'রাউন্ড-ট্রিপ ফ্লাইট',
                        'হারামের কাছে হোটেল',
                        'দৈনিক নাস্তা ও রাতের খাবার',
                        'এয়ারপোর্ট ট্রান্সফার',
                        'জিয়ারত (ধর্মীয় স্থান পরিদর্শন)',
                        'অভিজ্ঞ ট্যুর গাইড',
                        'উমরাহ ভিসা প্রক্রিয়াকরণ',
                        '২৪/৭ গ্রাহক সহায়তা'
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
                        <p class="text-sm text-gray-500 dark:text-gray-400">সময়কাল: {{ $package['duration'] }}</p>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-3">প্যাকেজে অন্তর্ভুক্ত:</h4>
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
                    {{ $package['title'] }} দেখুন
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">প্যাকেজের ক্যাটাগরি</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">আপনার পছন্দ এবং বাজেট অনুযায়ী বিভিন্ন ক্যাটাগরি</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @php
            $categories = [
                [
                    'title' => 'ইকোনমি প্যাকেজ',
                    'description' => 'প্রয়োজনীয় সেবা সহ বাজেট-বান্ধব প্যাকেজ',
                    'icon' => '💰',
                    'features' => [
                        'স্ট্যান্ডার্ড থাকার ব্যবস্থা',
                        'শেয়ার্ড পরিবহন',
                        'বেসিক খাবার পরিকল্পনা',
                        'গ্রুপ গাইডেন্স',
                        'প্রয়োজনীয় সেবা'
                    ],
                    'hajj_price' => '৪,৫০,০০০ - ৫,৫০,০০০',
                    'umrah_price' => '৮৫,০০০ - ১,২০,০০০'
                ],
                [
                    'title' => 'স্ট্যান্ডার্ড প্যাকেজ',
                    'description' => 'উন্নত সেবা সহ আরামদায়ক প্যাকেজ',
                    'icon' => '⭐',
                    'features' => [
                        'ভাল মানের হোটেল',
                        'এয়ার-কন্ডিশন্ড পরিবহন',
                        'সম্পূর্ণ খাবার পরিকল্পনা',
                        'অভিজ্ঞ গাইড',
                        'অতিরিক্ত সেবা'
                    ],
                    'hajj_price' => '৫,৫০,০০০ - ৬,৫০,০০০',
                    'umrah_price' => '১,২০,০০০ - ১,৮০,০০০'
                ],
                [
                    'title' => 'প্রিমিয়াম প্যাকেজ',
                    'description' => 'ভিআইপি সেবা সহ বিলাসবহুল প্যাকেজ',
                    'icon' => '👑',
                    'features' => [
                        '৪-৫ স্টার হোটেল',
                        'প্রাইভেট পরিবহন',
                        'প্রিমিয়াম ডাইনিং',
                        'ব্যক্তিগত সহায়তা',
                        'ভিআইপি সেবা'
                    ],
                    'hajj_price' => '৬,৫০,০০০ - ৮,০০,০০০',
                    'umrah_price' => '১,৮০,০০০ - ২,৫০,০০০'
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
                    <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-3">বৈশিষ্ট্য:</h4>
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
                        <p class="text-sm font-medium text-emerald-700 dark:text-emerald-300">হজ প্যাকেজ</p>
                        <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400">৳{{ $category['hajj_price'] }}</p>
                    </div>
                    <div class="p-3 bg-teal-50 dark:bg-teal-900/20 rounded">
                        <p class="text-sm font-medium text-teal-700 dark:text-teal-300">উমরাহ প্যাকেজ</p>
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">গুরুত্বপূর্ণ তথ্য</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">আপনার হজ ও উমরাহ যাত্রার জন্য প্রয়োজনীয় বিবরণ</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $importantInfo = [
                [
                    'icon' => '📋',
                    'title' => 'প্রয়োজনীয় কাগজপত্র',
                    'items' => [
                        'বৈধ পাসপোর্ট (৬+ মাস)',
                        'টিকাদান সার্টিফিকেট',
                        'পাসপোর্ট সাইজ ছবি',
                        'বিবাহের সার্টিফিকেট (প্রযোজ্য হলে)',
                        'মাহরাম কাগজপত্র (মহিলাদের জন্য)'
                    ]
                ],
                [
                    'icon' => '💉',
                    'title' => 'স্বাস্থ্য ও টিকাদান',
                    'items' => [
                        'কোভিড-১৯ টিকাদান',
                        'মেনিনজাইটিস টিকাদান',
                        'হলুদ জ্বর (প্রযোজ্য হলে)',
                        'স্বাস্থ্য বীমা',
                        'চিকিৎসা পরীক্ষা'
                    ]
                ],
                [
                    'icon' => '🕐',
                    'title' => 'যাওয়ার সর্বোত্তম সময়',
                    'items' => [
                        'হজ: জিলহজ মাস',
                        'উমরাহ: সারা বছর',
                        'রমজান উমরাহ: সবচেয়ে বরকতময়',
                        'শীতকাল: ঠান্ডা আবহাওয়া',
                        'গ্রীষ্মকাল এড়িয়ে চলুন: অত্যধিক গরম'
                    ]
                ],
                [
                    'icon' => '🎒',
                    'title' => 'কী প্যাক করবেন',
                    'items' => [
                        'ইহরামের কাপড়',
                        'আরামদায়ক হাঁটার জুতা',
                        'সানস্ক্রিন ও টুপি',
                        'ব্যক্তিগত ওষুধ',
                        'নামাজের চাটাই ও কুরআন'
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
            <h2 class="text-3xl md:text-4xl font-bold mb-4">হজ ও উমরাহের জন্য কেন ইকো ট্রাভেল বেছে নিবেন?</h2>
            <p class="text-xl">আপনার আধ্যাত্মিক যাত্রা, আমাদের অঙ্গীকার</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $whyChooseUs = [
                [
                    'icon' => '🕌',
                    'title' => 'বিশেষজ্ঞ জ্ঞান',
                    'description' => 'গভীর ধর্মীয় বোঝাপড়া সহ হজ ও উমরাহ আয়োজনে বছরের পর বছর অভিজ্ঞতা'
                ],
                [
                    'icon' => '🏨',
                    'title' => 'প্রধান অবস্থান',
                    'description' => 'মসজিদুল হারাম ও মসজিদে নববীতে সহজ প্রবেশের জন্য হারামের কাছে হোটেল'
                ],
                [
                    'icon' => '👨‍🏫',
                    'title' => 'ধর্মীয় গাইডেন্স',
                    'description' => 'আপনার পুরো যাত্রায় সহায়তার জন্য অভিজ্ঞ ইসলামিক স্কলার ও গাইড'
                ],
                [
                    'icon' => '🛡️',
                    'title' => 'সম্পূর্ণ সহায়তা',
                    'description' => '২৪/৭ সাপোর্ট টিম, চিকিৎসা সহায়তা এবং গ্রুপ কোঅর্ডিনেশন সেবা'
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
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">আপনার পবিত্র যাত্রার জন্য প্রস্তুত?</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">বিস্তারিত তথ্য এবং ব্যক্তিগত প্যাকেজের জন্য আমাদের সাথে যোগাযোগ করুন</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">আমাদের হজ বিভাগে কল করুন</h3>
                <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mb-4">+৮৮০৯৬৪৭৬৬৮৮২২</p>
                <p class="text-gray-600 dark:text-gray-300">আমাদের হজ ও উমরাহ বিশেষজ্ঞদের সাথে কথা বলুন</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
                <div class="text-4xl mb-4">✉️</div>
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">আপনার অনুসন্ধান ইমেইল করুন</h3>
                <p class="text-xl text-emerald-600 dark:text-emerald-400 mb-4">info@ecotravelsonline.com.bd</p>
                <p class="text-gray-600 dark:text-gray-300">বিস্তারিত প্যাকেজ তথ্য পান</p>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-block">
                প্যাকেজের বিবরণ অনুরোধ করুন
            </a>
        </div>
    </div>
</section>