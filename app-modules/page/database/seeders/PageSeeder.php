<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Page\Models\Page;
use App\Models\User;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user or create one
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        // Create Terms of Service page (with template)
        Page::create([
            'english_title' => 'Terms of Service',
            'slug' => 'terms-of-service',
            'title' => [
                'en' => 'Terms of Service',
                'bn' => 'সার্ভিসের শর্তাবলী'
            ],
            'content' => [
                'en' => "Welcome to Eco Travel's Terms of Service. These terms and conditions outline the rules and regulations for the use of our website and travel services.\n\nBy accessing ecotravelsonline.com.bd or booking our services, you accept these terms and conditions. Do not continue to use our website or services if you do not agree to these terms.\n\nCompany Information:\nEco Travel is a New Zealand-based multinational travel agency operating in Bangladesh since 2007. Our registered office is located at House 3, Road 16, Sector 11, Uttara, Dhaka - 1230, Bangladesh.\n\n1. Services\nWe provide travel booking services including:\n- Domestic and international flight bookings\n- Hotel reservations and accommodation bookings\n- Holiday packages and tour arrangements\n- Hajj and Umrah pilgrimage packages\n- Travel consultation and support services\n\n2. Booking Terms\n- All bookings are subject to availability and confirmation\n- Prices are subject to change without notice until booking is confirmed\n- Full payment or required deposit must be made to confirm bookings\n- Booking confirmations will be sent via email\n- Changes to bookings may incur additional charges\n\n3. Payment Terms\n- We accept various payment methods including bank transfers, mobile banking, and online payments\n- All prices are displayed in Bangladeshi Taka (BDT) unless otherwise specified\n- Payment receipts will be provided for all transactions\n- Refunds are subject to airline, hotel, and service provider policies\n\n4. Cancellation Policy\n- Cancellation policies vary by service provider (airlines, hotels, tour operators)\n- Cancellation fees may apply as per supplier terms and conditions\n- Travel insurance is recommended to protect against unforeseen circumstances\n- Eco Travel cancellation fees may apply in addition to supplier fees\n\n5. Travel Documentation\n- Passengers are responsible for ensuring valid travel documents (passport, visa, permits)\n- We provide assistance with visa applications but do not guarantee approval\n- Health certificates and vaccinations are passenger's responsibility\n- Eco Travel is not liable for denied boarding due to inadequate documentation\n\n6. Liability Limitations\n- Eco Travel acts as an intermediary between customers and service providers\n- We are not liable for delays, cancellations, or changes by airlines or hotels\n- Our liability is limited to the service fees paid to Eco Travel\n- We recommend comprehensive travel insurance for full protection\n\n7. Customer Responsibilities\n- Provide accurate information during booking\n- Arrive at departure points with adequate time\n- Comply with airline, hotel, and destination country regulations\n- Notify us immediately of any issues during travel\n\n8. Privacy and Data Protection\n- We collect and process personal data in accordance with our Privacy Policy\n- Customer information is used solely for travel service purposes\n- We do not share personal data with unauthorized third parties\n- Customers may request access to or deletion of their personal data\n\n9. Contact Information\nFor questions about these terms or our services:\nEmail: info@ecotravelsonline.com.bd\nPhone: +8809647668822\nAddress: House 3, Road 16, Sector 11, Uttara, Dhaka - 1230\n\n10. Modifications\nEco Travel reserves the right to modify these terms at any time. Updated terms will be posted on our website. Continued use of our services constitutes acceptance of modified terms.\n\n11. Governing Law\nThese terms are governed by the laws of Bangladesh. Any disputes will be resolved through arbitration in Dhaka, Bangladesh.\n\nLast updated: January 2025",
                'bn' => "ইকো ট্রাভেলের সার্ভিসের শর্তাবলীতে স্বাগতম। এই শর্ত এবং নিয়মাবলী আমাদের ওয়েবসাইট এবং ভ্রমণ সার্ভিস ব্যবহারের নিয়মকানুন বর্ণনা করে।\n\necotravelsonline.com.bd অ্যাক্সেস করে বা আমাদের সার্ভিস বুক করে, আপনি এই শর্তাবলী গ্রহণ করেছেন। এই শর্তাবলীতে সম্মত না হলে আমাদের ওয়েবসাইট বা সার্ভিস ব্যবহার বন্ধ করুন।\n\nকোম্পানির তথ্য:\nইকো ট্রাভেল নিউজিল্যান্ড ভিত্তিক একটি বহুজাতিক ট্রাভেল এজেন্সি যা ২০০৭ সাল থেকে বাংলাদেশে কাজ করছে। আমাদের নিবন্ধিত অফিস: বাড়ি ৩, রোড ১৬, সেক্টর ১১, উত্তরা, ঢাকা - ১২৩০।\n\n১. সার্ভিসসমূহ\nআমরা যে ভ্রমণ বুকিং সার্ভিস প্রদান করি:\n- দেশীয় ও আন্তর্জাতিক ফ্লাইট বুকিং\n- হোটেল রিজার্ভেশন ও থাকার ব্যবস্থা\n- হলিডে প্যাকেজ ও ট্যুর আয়োজন\n- হজ ও উমরাহ তীর্থযাত্রা প্যাকেজ\n- ভ্রমণ পরামর্শ ও সহায়তা সার্ভিস\n\n২. বুকিং শর্তাবলী\n- সকল বুকিং প্রাপ্যতা ও নিশ্চিতকরণ সাপেক্ষে\n- বুকিং নিশ্চিত না হওয়া পর্যন্ত দাম পরিবর্তন হতে পারে\n- বুকিং নিশ্চিত করতে সম্পূর্ণ পেমেন্ট বা প্রয়োজনীয় জমা দিতে হবে\n- বুকিং নিশ্চিতকরণ ইমেইলের মাধ্যমে পাঠানো হবে\n- বুকিং পরিবর্তনে অতিরিক্ত চার্জ প্রযোজ্য হতে পারে\n\n৩. পেমেন্ট শর্তাবলী\n- আমরা ব্যাংক ট্রান্সফার, মোবাইল ব্যাংকিং ও অনলাইন পেমেন্ট গ্রহণ করি\n- সকল দাম বাংলাদেশী টাকায় (BDT) প্রদর্শিত হয় যদি না অন্যথায় উল্লেখ থাকে\n- সকল লেনদেনের জন্য পেমেন্ট রসিদ প্রদান করা হবে\n- রিফান্ড এয়ারলাইন, হোটেল ও সেবা প্রদানকারীর নীতি অনুযায়ী\n\n৪. বাতিলকরণ নীতি\n- বাতিলকরণ নীতি সেবা প্রদানকারী অনুযায়ী পরিবর্তিত হয়\n- সরবরাহকারীর শর্ত অনুযায়ী বাতিলকরণ ফি প্রযোজ্য হতে পারে\n- অপ্রত্যাশিত পরিস্থিতি থেকে সুরক্ষার জন্য ভ্রমণ বীমা সুপারিশ করা হয়\n- সরবরাহকারী ফি ছাড়াও ইকো ট্রাভেল বাতিলকরণ ফি প্রযোজ্য হতে পারে\n\n৫. ভ্রমণ নথিপত্র\n- যাত্রীরা বৈধ ভ্রমণ নথি (পাসপোর্ট, ভিসা, পারমিট) নিশ্চিত করার জন্য দায়বদ্ধ\n- আমরা ভিসা আবেদনে সহায়তা করি কিন্তু অনুমোদনের গ্যারান্টি দিই না\n- স্বাস্থ্য সার্টিফিকেট ও টিকাদান যাত্রীর দায়িত্ব\n- অপর্যাপ্ত নথির কারণে বোর্ডিং অস্বীকারের জন্য ইকো ট্রাভেল দায়বদ্ধ নয়\n\n৬. যোগাযোগের তথ্য\nএই শর্তাবলী বা আমাদের সেবা সম্পর্কে প্রশ্নের জন্য:\nইমেইল: info@ecotravelsonline.com.bd\nফোন: +৮৮০৯৬৪৭৬৬৮৮২২\nঠিকানা: বাড়ি ৩, রোড ১৬, সেক্টর ১১, উত্তরা, ঢাকা - ১২৩০\n\n৭. পরিবর্তন\nইকো ট্রাভেল যেকোনো সময় এই শর্তাবলী পরিবর্তন করার অধিকার সংরক্ষণ করে। আপডেট শর্তাবলী আমাদের ওয়েবসাইটে পোস্ট করা হবে।\n\n৮. প্রযোজ্য আইন\nএই শর্তাবলী বাংলাদেশের আইন দ্বারা নিয়ন্ত্রিত। যেকোনো বিরোধ ঢাকা, বাংলাদেশে সালিশের মাধ্যমে সমাধান করা হবে।\n\nসর্বশেষ আপডেট: জানুয়ারি ২০২৫"
            ],
            'template' => 'terms-of-service',
            'meta_title' => [
                'en' => 'Terms of Service - Eco Travel',
                'bn' => 'সার্ভিসের শর্তাবলী - ইকো ট্রাভেল'
            ],
            'meta_description' => [
                'en' => 'Read Eco Travel\'s terms of service for travel bookings, flights, hotels, and holiday packages. Understand our booking policies and conditions.',
                'bn' => 'ভ্রমণ বুকিং, ফ্লাইট, হোটেল এবং হলিডে প্যাকেজের জন্য ইকো ট্রাভেলের সার্ভিসের শর্তাবলী পড়ুন। আমাদের বুকিং নীতি ও শর্তাবলী বুঝুন।'
            ],
            'keywords' => [
                'en' => 'eco travel terms, travel booking terms, flight booking conditions, hotel booking policy, holiday package terms',
                'bn' => 'ইকো ট্রাভেল শর্তাবলী, ভ্রমণ বুকিং শর্ত, ফ্লাইট বুকিং নিয়ম, হোটেল বুকিং নীতি, হলিডে প্যাকেজ শর্ত'
            ],
            'status' => 'published',
            'published_at' => now(),
            'position' => 1,
            'user_id' => $user->id,
        ]);

        // Create Privacy Policy page (with template)
        Page::create([
            'english_title' => 'Privacy Policy',
            'slug' => 'privacy-policy',
            'title' => [
                'en' => 'Privacy Policy',
                'bn' => 'গোপনীয়তার নীতি'
            ],
            'content' => [
                'en' => "Eco Travel is committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you visit ecotravelsonline.com.bd or use our travel services.\n\nAbout Eco Travel:\nEco Travel is a New Zealand-based multinational travel agency operating in Bangladesh since 2007. We are located at House 3, Road 16, Sector 11, Uttara, Dhaka - 1230, Bangladesh.\n\n1. Information We Collect\n\nPersonal Information:\n- Name, email address, phone number\n- Passport details and travel document information\n- Date of birth and nationality\n- Emergency contact information\n- Payment and billing information\n- Travel preferences and special requirements\n\nTechnical Information:\n- IP address and browser type\n- Device information and operating system\n- Website usage patterns and interactions\n- Cookies and similar tracking technologies\n\nBooking Information:\n- Flight preferences and travel dates\n- Hotel and accommodation preferences\n- Package selections and customizations\n- Travel history and previous bookings\n\n2. How We Use Your Information\n\nWe use your personal information to:\n- Process travel bookings and reservations\n- Communicate booking confirmations and updates\n- Provide customer support and assistance\n- Send travel-related notifications and alerts\n- Process payments and handle billing\n- Comply with legal and regulatory requirements\n- Improve our services and website functionality\n- Send promotional offers (with your consent)\n\n3. Information Sharing\n\nWe may share your information with:\n- Airlines, hotels, and other travel service providers for booking purposes\n- Payment processors for secure transaction processing\n- Government authorities when required by law\n- Emergency contacts in case of travel emergencies\n- Third-party service providers who assist in our operations\n\nWe do not sell your personal information to third parties for marketing purposes.\n\n4. Data Security\n\nWe implement industry-standard security measures including:\n- SSL encryption for data transmission\n- Secure servers and databases\n- Regular security audits and updates\n- Access controls and staff training\n- Compliance with international data protection standards\n\n5. Data Retention\n\n- Booking records: Retained for 7 years for legal and accounting purposes\n- Payment information: Retained as required by financial regulations\n- Marketing communications: Until you unsubscribe\n- Website usage data: Retained for 2 years for analytics purposes\n\n6. Your Privacy Rights\n\nYou have the right to:\n- Access your personal data\n- Correct inaccurate information\n- Request deletion of your data (subject to legal requirements)\n- Object to processing of your data\n- Request data portability\n- Withdraw consent for marketing communications\n\n7. Cookies and Tracking\n\nWe use cookies to:\n- Remember your preferences and settings\n- Analyze website usage and performance\n- Provide personalized content and offers\n- Ensure website security and functionality\n\nYou can control cookie settings through your browser preferences.\n\n8. Third-Party Services\n\nWe work with reputable third-party services including:\n- Airlines and hotel booking systems\n- Payment gateways and processors\n- Email communication platforms\n- Website analytics tools\n\nThese services have their own privacy policies and security measures.\n\n9. International Data Transfers\n\nAs a multinational company, we may transfer your data internationally for:\n- Processing bookings with global travel partners\n- Providing customer support across time zones\n- Maintaining backup systems for data security\n\nAll transfers are conducted with appropriate safeguards in place.\n\n10. Updates to This Policy\n\nWe may update this Privacy Policy to reflect changes in our practices or legal requirements. Updated policies will be posted on our website with the revision date.\n\n11. Contact Information\n\nFor privacy-related questions or to exercise your rights:\n\nEmail: info@ecotravelsonline.com.bd\nPhone: +8809647668822\nAddress: House 3, Road 16, Sector 11, Uttara, Dhaka - 1230, Bangladesh\n\nData Protection Officer: Available upon request\n\n12. Complaints\n\nIf you have concerns about our privacy practices, please contact us first. If your concerns are not resolved, you may contact the relevant data protection authority in your jurisdiction.\n\nLast updated: January 2025\n\nThis Privacy Policy is effective as of the date listed above and applies to all information collected by Eco Travel through our website and services.",
                'bn' => "ইকো ট্রাভেল আপনার গোপনীয়তা রক্ষা এবং আপনার ব্যক্তিগত তথ্যের নিরাপত্তা নিশ্চিত করতে প্রতিশ্রুতিবদ্ধ। এই গোপনীয়তার নীতি ব্যাখ্যা করে যে আপনি ecotravelsonline.com.bd পরিদর্শন করার সময় বা আমাদের ভ্রমণ সেবা ব্যবহার করার সময় আমরা কীভাবে আপনার ডেটা সংগ্রহ, ব্যবহার এবং সুরক্ষিত রাখি।\n\nইকো ট্রাভেল সম্পর্কে:\nইকো ট্রাভেল নিউজিল্যান্ড ভিত্তিক একটি বহুজাতিক ট্রাভেল এজেন্সি যা ২০০৭ সাল থেকে বাংলাদেশে কাজ করছে। আমাদের অবস্থান: বাড়ি ৩, রোড ১৬, সেক্টর ১১, উত্তরা, ঢাকা - ১২৩০।\n\n১. আমরা যে তথ্য সংগ্রহ করি\n\nব্যক্তিগত তথ্য:\n- নাম, ইমেইল ঠিকানা, ফোন নম্বর\n- পাসপোর্ট বিবরণ ও ভ্রমণ নথির তথ্য\n- জন্ম তারিখ ও জাতীয়তা\n- জরুরি যোগাযোগের তথ্য\n- পেমেন্ট ও বিলিং তথ্য\n- ভ্রমণ পছন্দ ও বিশেষ প্রয়োজনীয়তা\n\nপ্রযুক্তিগত তথ্য:\n- আইপি ঠিকানা ও ব্রাউজারের ধরন\n- ডিভাইসের তথ্য ও অপারেটিং সিস্টেম\n- ওয়েবসাইট ব্যবহারের ধরন ও মিথস্ক্রিয়া\n- কুকিজ ও অনুরূপ ট্র্যাকিং প্রযুক্তি\n\nবুকিং তথ্য:\n- ফ্লাইট পছন্দ ও ভ্রমণের তারিখ\n- হোটেল ও থাকার পছন্দ\n- প্যাকেজ নির্বাচন ও কাস্টমাইজেশন\n- ভ্রমণের ইতিহাস ও পূর্ববর্তী বুকিং\n\n২. আমরা কীভাবে আপনার তথ্য ব্যবহার করি\n\nআমরা আপনার ব্যক্তিগত তথ্য ব্যবহার করি:\n- ভ্রমণ বুকিং ও রিজার্ভেশন প্রক্রিয়াকরণে\n- বুকিং নিশ্চিতকরণ ও আপডেট যোগাযোগে\n- গ্রাহক সহায়তা ও সাহায্য প্রদানে\n- ভ্রমণ সম্পর্কিত বিজ্ঞপ্তি ও সতর্কতা পাঠাতে\n- পেমেন্ট প্রক্রিয়াকরণ ও বিলিং পরিচালনায়\n- আইনি ও নিয়ন্ত্রক প্রয়োজনীয়তা মেনে চলতে\n- আমাদের সেবা ও ওয়েবসাইট কার্যকারিতা উন্নত করতে\n- প্রচারণামূলক অফার পাঠাতে (আপনার সম্মতি সাপেক্ষে)\n\n৩. তথ্য শেয়ারিং\n\nআমরা আপনার তথ্য শেয়ার করতে পারি:\n- এয়ারলাইন, হোটেল ও অন্যান্য ভ্রমণ সেবা প্রদানকারীর সাথে বুকিংয়ের উদ্দেশ্যে\n- নিরাপদ লেনদেন প্রক্রিয়াকরণের জন্য পেমেন্ট প্রসেসরদের সাথে\n- আইন দ্বারা প্রয়োজনীয় হলে সরকারি কর্তৃপক্ষের সাথে\n- ভ্রমণ জরুরি অবস্থায় জরুরি যোগাযোগের সাথে\n- আমাদের কার্যক্রমে সহায়তাকারী তৃতীয় পক্ষের সেবা প্রদানকারীদের সাথে\n\nআমরা বিপণনের উদ্দেশ্যে তৃতীয় পক্ষের কাছে আপনার ব্যক্তিগত তথ্য বিক্রি করি না।\n\n৪. ডেটা নিরাপত্তা\n\nআমরা ইন্ডাস্ট্রি-স্ট্যান্ডার্ড নিরাপত্তা ব্যবস্থা বাস্তবায়ন করি:\n- ডেটা ট্রান্সমিশনের জন্য SSL এনক্রিপশন\n- নিরাপদ সার্ভার ও ডেটাবেস\n- নিয়মিত নিরাপত্তা অডিট ও আপডেট\n- অ্যাক্সেস কন্ট্রোল ও কর্মী প্রশিক্ষণ\n- আন্তর্জাতিক ডেটা সুরক্ষা মানদণ্ডের সাথে সামঞ্জস্য\n\n৫. যোগাযোগের তথ্য\n\nগোপনীয়তা সম্পর্কিত প্রশ্ন বা আপনার অধিকার প্রয়োগের জন্য:\n\nইমেইল: info@ecotravelsonline.com.bd\nফোন: +৮৮০৯৬৪৭৬৬৮৮২২\nঠিকানা: বাড়ি ৩, রোড ১৬, সেক্টর ১১, উত্তরা, ঢাকা - ১২৩০\n\nডেটা সুরক্ষা কর্মকর্তা: অনুরোধের ভিত্তিতে উপলব্ধ\n\n৬. নীতি আপডেট\n\nআমরা আমাদের অনুশীলন বা আইনি প্রয়োজনীয়তার পরিবর্তন প্রতিফলিত করতে এই গোপনীয়তার নীতি আপডেট করতে পারি। আপডেট নীতি সংশোধনের তারিখ সহ আমাদের ওয়েবসাইটে পোস্ট করা হবে।\n\nসর্বশেষ আপডেট: জানুয়ারি ২০২৫\n\nএই গোপনীয়তার নীতি উপরে তালিকাভুক্ত তারিখ থেকে কার্যকর এবং আমাদের ওয়েবসাইট ও সেবার মাধ্যমে ইকো ট্রাভেল দ্বারা সংগৃহীত সমস্ত তথ্যের ক্ষেত্রে প্রযোজ্য।"
            ],
            'template' => 'privacy-policy',
            'meta_title' => [
                'en' => 'Privacy Policy - Eco Travel',
                'bn' => 'গোপনীয়তার নীতি - ইকো ট্রাভেল'
            ],
            'meta_description' => [
                'en' => 'Learn how Eco Travel collects, uses, and protects your personal and travel information. Read our comprehensive privacy policy for travel bookings.',
                'bn' => 'ইকো ট্রাভেল কীভাবে আপনার ব্যক্তিগত ও ভ্রমণ তথ্য সংগ্রহ, ব্যবহার এবং সুরক্ষিত রাখে তা জানুন। ভ্রমণ বুকিংয়ের জন্য আমাদের বিস্তৃত গোপনীয়তার নীতি পড়ুন।'
            ],
            'keywords' => [
                'en' => 'eco travel privacy, travel data protection, booking privacy policy, travel information security, passenger data protection',
                'bn' => 'ইকো ট্রাভেল গোপনীয়তা, ভ্রমণ ডেটা সুরক্ষা, বুকিং গোপনীয়তা নীতি, ভ্রমণ তথ্য নিরাপত্তা, যাত্রী ডেটা সুরক্ষা'
            ],
            'status' => 'published',
            'published_at' => now(),
            'position' => 2,
            'user_id' => $user->id,
        ]);

        // Create FAQ page (no template - default content)
        Page::create([
            'english_title' => 'Frequently Asked Questions',
            'slug' => 'faq',
            'title' => [
                'en' => 'Frequently Asked Questions',
                'bn' => 'প্রায়শই জিজ্ঞাসিত প্রশ্নাবলী'
            ],
            'content' => [
                'en' => "Here are answers to some of the most commonly asked questions about our services:\n\nQ: What services do you offer?\nA: We offer web development, mobile app development, consulting services, and technical support to help businesses grow their digital presence.\n\nQ: How can I get started with your services?\nA: Simply contact us through our contact form or give us a call. We'll schedule a consultation to discuss your needs and provide a customized solution.\n\nQ: What is your typical project timeline?\nA: Project timelines vary depending on complexity and scope. Simple websites typically take 2-4 weeks, while complex applications may take 2-6 months. We'll provide a detailed timeline during our initial consultation.\n\nQ: Do you provide ongoing support?\nA: Yes, we offer comprehensive support and maintenance packages to ensure your website or application continues to perform optimally.\n\nQ: What technologies do you work with?\nA: We work with modern technologies including Laravel, React, Vue.js, Node.js, PHP, Python, and various database systems. We choose the best technology stack for each project.\n\nQ: How do you handle project communication?\nA: We maintain regular communication through email, project management tools, and scheduled meetings. You'll have a dedicated project manager as your primary point of contact.\n\nQ: What are your payment terms?\nA: We typically work with a 50% upfront payment and 50% upon completion. For larger projects, we can arrange milestone-based payments.\n\nQ: Do you offer SEO services?\nA: Yes, we provide SEO optimization as part of our web development services, including on-page SEO, performance optimization, and search engine friendly structure.\n\nQ: Can you help with website maintenance?\nA: Absolutely! We offer various maintenance packages including security updates, content updates, performance monitoring, and regular backups.\n\nQ: How do I get a quote for my project?\nA: Contact us with your project details, and we'll provide a free consultation and detailed quote within 24-48 hours.",
                'bn' => "আমাদের সেবা সম্পর্কে সবচেয়ে সাধারণভাবে জিজ্ঞাসিত কিছু প্রশ্নের উত্তর এখানে রয়েছে:\n\nপ্রশ্ন: আপনারা কী সেবা প্রদান করেন?\nউত্তর: আমরা ওয়েব ডেভেলপমেন্ট, মোবাইল অ্যাপ ডেভেলপমেন্ট, পরামর্শ সেবা এবং প্রযুক্তিগত সহায়তা প্রদান করি ব্যবসার ডিজিটাল উপস্থিতি বৃদ্ধিতে সহায়তা করতে।\n\nপ্রশ্ন: আমি কীভাবে আপনাদের সেবা নিয়ে শুরু করতে পারি?\nউত্তর: আমাদের যোগাযোগ ফর্মের মাধ্যমে বা ফোন করে যোগাযোগ করুন। আমরা আপনার প্রয়োজন নিয়ে আলোচনা করতে এবং কাস্টমাইজড সমাধান প্রদান করতে একটি পরামর্শের সময় নির্ধারণ করব।\n\nপ্রশ্ন: আপনাদের সাধারণ প্রকল্পের সময়সীমা কী?\nউত্তর: জটিলতা এবং পরিধির উপর নির্ভর করে প্রকল্পের সময়সীমা পরিবর্তিত হয়। সাধারণ ওয়েবসাইট সাধারণত ২-৪ সপ্তাহ সময় নেয়, জটিল অ্যাপ্লিকেশনের ক্ষেত্রে ২-৬ মাস লাগতে পারে।\n\nপ্রশ্ন: আপনারা কি চলমান সহায়তা প্রদান করেন?\nউত্তর: হ্যাঁ, আমরা আপনার ওয়েবসাইট বা অ্যাপ্লিকেশন সর্বোত্তমভাবে কাজ করতে নিশ্চিত করতে ব্যাপক সহায়তা এবং রক্ষণাবেক্ষণ প্যাকেজ অফার করি।\n\nপ্রশ্ন: আপনারা কোন প্রযুক্তির সাথে কাজ করেন?\nউত্তর: আমরা Laravel, React, Vue.js, Node.js, PHP, Python এবং বিভিন্ন ডেটাবেস সিস্টেম সহ আধুনিক প্রযুক্তির সাথে কাজ করি।\n\nপ্রশ্ন: আমি আমার প্রকল্পের জন্য কোটেশন কীভাবে পেতে পারি?\nউত্তর: আপনার প্রকল্পের বিবরণ সহ আমাদের সাথে যোগাযোগ করুন, এবং আমরা ২৪-৪৮ ঘন্টার মধ্যে একটি বিনামূল্যে পরামর্শ এবং বিস্তারিত কোটেশন প্রদান করব।"
            ],
            'template' => null, // No template - use default
            'meta_title' => [
                'en' => 'FAQ - Frequently Asked Questions',
                'bn' => 'প্রায়শই জিজ্ঞাসিত প্রশ্নাবলী'
            ],
            'meta_description' => [
                'en' => 'Find answers to frequently asked questions about our web development, mobile app development, and consulting services.',
                'bn' => 'আমাদের ওয়েব ডেভেলপমেন্ট, মোবাইল অ্যাপ ডেভেলপমেন্ট এবং পরামর্শ সেবা সম্পর্কে প্রায়শই জিজ্ঞাসিত প্রশ্নের উত্তর খুঁজুন।'
            ],
            'keywords' => [
                'en' => 'FAQ, questions, answers, web development, support, services, help',
                'bn' => 'প্রশ্নোত্তর, প্রশ্ন, উত্তর, ওয়েব ডেভেলপমেন্ট, সহায়তা, সেবা, সাহায্য'
            ],
            'status' => 'published',
            'published_at' => now(),
            'position' => 3,
            'user_id' => $user->id,
        ]);

        // Create About page (no template - default content)
        Page::create([
            'english_title' => 'About Us',
            'slug' => 'about',
            'title' => [
                'en' => 'About Us',
                'bn' => 'আমাদের সম্পর্কে'
            ],
            'content' => [
                'en' => "Welcome to our company! We are a passionate team of developers, designers, and digital strategists dedicated to helping businesses thrive in the digital world.\n\nOur Story:\nFounded in 2020, we started as a small team with a big vision: to make high-quality web development and digital solutions accessible to businesses of all sizes. Over the years, we've grown into a trusted partner for companies looking to establish or enhance their digital presence.\n\nWhat We Do:\n- Custom Web Development: We create bespoke websites tailored to your specific needs and goals\n- Mobile App Development: From concept to deployment, we build mobile applications for iOS and Android\n- E-commerce Solutions: We help businesses sell online with powerful e-commerce platforms\n- Digital Consulting: Strategic guidance to help you make informed decisions about your digital journey\n- Technical Support: Ongoing maintenance and support to keep your digital assets running smoothly\n\nOur Approach:\nWe believe in collaboration, transparency, and delivering results that exceed expectations. Every project begins with understanding your unique challenges and goals. We then craft solutions that not only meet your immediate needs but also position you for future growth.\n\nOur Values:\n- Quality: We never compromise on the quality of our work\n- Innovation: We stay current with the latest technologies and best practices\n- Communication: We keep you informed every step of the way\n- Results: We measure our success by your success\n- Integrity: We conduct business with honesty and transparency\n\nOur Team:\nOur diverse team brings together expertise in various technologies and industries. We're not just developers and designers – we're problem solvers who are passionate about creating digital solutions that make a real impact.\n\nWhy Choose Us:\n- Proven track record with 100+ successful projects\n- Experienced team with deep technical expertise\n- Agile development methodology for faster delivery\n- Ongoing support and maintenance services\n- Competitive pricing without compromising quality\n- Clear communication throughout the project lifecycle\n\nLet's Build Something Amazing Together:\nWhether you're a startup looking to establish your digital presence or an established business seeking to modernize your technology stack, we're here to help. Contact us today to discuss how we can bring your vision to life.",
                'bn' => "আমাদের কোম্পানিতে স্বাগতম! আমরা ডেভেলপার, ডিজাইনার এবং ডিজিটাল কৌশলবিদদের একটি উৎসাহী দল যারা ব্যবসায়িক প্রতিষ্ঠানগুলোকে ডিজিটাল জগতে সফল হতে সাহায্য করার জন্য নিবেদিত।\n\nআমাদের গল্প:\n২০২০ সালে প্রতিষ্ঠিত, আমরা একটি বড় দৃষ্টিভঙ্গি নিয়ে একটি ছোট দল হিসেবে শুরু করেছিলাম: সকল আকারের ব্যবসার জন্য উচ্চ মানের ওয়েব ডেভেলপমেন্ট এবং ডিজিটাল সমাধান সহজলভ্য করা। বছরের পর বছর ধরে, আমরা একটি বিশ্বস্ত অংশীদার হিসেবে বৃদ্ধি পেয়েছি।\n\nআমরা যা করি:\n- কাস্টম ওয়েব ডেভেলপমেন্ট: আমরা আপনার নির্দিষ্ট প্রয়োজন এবং লক্ষ্য অনুযায়ী বিশেষভাবে তৈরি ওয়েবসাইট তৈরি করি\n- মোবাইল অ্যাপ ডেভেলপমেন্ট: ধারণা থেকে স্থাপনা পর্যন্ত, আমরা iOS এবং Android এর জন্য মোবাইল অ্যাপ্লিকেশন তৈরি করি\n- ই-কমার্স সমাধান: আমরা শক্তিশালী ই-কমার্স প্ল্যাটফর্মের সাথে ব্যবসায়িক প্রতিষ্ঠানগুলোকে অনলাইনে বিক্রয় করতে সাহায্য করি\n- ডিজিটাল পরামর্শ: আপনার ডিজিটাল যাত্রা সম্পর্কে সচেতন সিদ্ধান্ত নিতে কৌশলগত নির্দেশনা\n- প্রযুক্তিগত সহায়তা: আপনার ডিজিটাল সম্পদগুলো মসৃণভাবে চালু রাখতে চলমান রক্ষণাবেক্ষণ এবং সহায়তা\n\nআমাদের পদ্ধতি:\nআমরা সহযোগিতা, স্বচ্ছতা এবং প্রত্যাশা অতিক্রম করে ফলাফল প্রদানে বিশ্বাস করি। প্রতিটি প্রকল্প আপনার অনন্য চ্যালেঞ্জ এবং লক্ষ্য বোঝার মাধ্যমে শুরু হয়।\n\nআমাদের মূল্যবোধ:\n- গুণমান: আমরা আমাদের কাজের গুণমানে কখনো আপস করি না\n- উদ্ভাবন: আমরা সর্বশেষ প্রযুক্তি এবং সর্বোত্তম অনুশীলনের সাথে তাল মিলিয়ে চলি\n- যোগাযোগ: আমরা প্রতিটি পদক্ষেপে আপনাকে অবহিত রাখি\n- ফলাফল: আপনার সাফল্যের মাধ্যমে আমরা আমাদের সাফল্য পরিমাপ করি\n- সততা: আমরা সততা এবং স্বচ্ছতার সাথে ব্যবসা পরিচালনা করি\n\nআসুন একসাথে অসাধারণ কিছু তৈরি করি:\nআপনি যদি একটি স্টার্টআপ হন যা আপনার ডিজিটাল উপস্থিতি প্রতিষ্ঠা করতে চান বা একটি প্রতিষ্ঠিত ব্যবসা যা আপনার প্রযুক্তি স্ট্যাক আধুনিকীকরণ করতে চান, আমরা সাহায্য করতে এখানে আছি।"
            ],
            'template' => null, // No template - use default
            'meta_title' => [
                'en' => 'About Us - Learn About Our Company',
                'bn' => 'আমাদের সম্পর্কে - আমাদের কোম্পানি সম্পর্কে জানুন'
            ],
            'meta_description' => [
                'en' => 'Learn about our company, our team, and our mission to help businesses succeed in the digital world through innovative web development solutions.',
                'bn' => 'আমাদের কোম্পানি, আমাদের দল এবং উদ্ভাবনী ওয়েব ডেভেলপমেন্ট সমাধানের মাধ্যমে ব্যবসায়িক প্রতিষ্ঠানগুলোকে ডিজিটাল জগতে সফল হতে সাহায্য করার আমাদের লক্ষ্য সম্পর্কে জানুন।'
            ],
            'keywords' => [
                'en' => 'about us, company, team, web development, mission, values, services',
                'bn' => 'আমাদের সম্পর্কে, কোম্পানি, দল, ওয়েব ডেভেলপমেন্ট, লক্ষ্য, মূল্যবোধ, সেবা'
            ],
            'status' => 'published',
            'published_at' => now(),
            'position' => 4,
            'user_id' => $user->id,
        ]);
    }
}