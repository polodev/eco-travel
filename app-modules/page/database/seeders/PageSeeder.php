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
                'bn' => 'সেবার শর্তাবলী'
            ],
            'content' => [
                'en' => "Welcome to our Terms of Service. These terms and conditions outline the rules and regulations for the use of our website and services.\n\nBy accessing this website, we assume you accept these terms and conditions. Do not continue to use our website if you do not agree to take all of the terms and conditions stated on this page.\n\nThe following terminology applies to these terms and conditions:\n\n1. Use License\nPermission is granted to temporarily download one copy of the materials on our website for personal, non-commercial transitory viewing only.\n\n2. Disclaimer\nThe materials on our website are provided on an 'as is' basis. We make no warranties, expressed or implied, and hereby disclaim and negate all other warranties including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.\n\n3. Limitations\nIn no event shall our company or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on our website.\n\n4. Accuracy of Materials\nThe materials appearing on our website could include technical, typographical, or photographic errors. We do not warrant that any of the materials on its website are accurate, complete, or current.\n\n5. Links\nWe have not reviewed all of the sites linked to our website and are not responsible for the contents of any such linked site.\n\n6. Modifications\nWe may revise these terms of service for its website at any time without notice. By using this website, you are agreeing to be bound by the then current version of these terms of service.\n\n7. Governing Law\nThese terms and conditions are governed by and construed in accordance with the laws and you irrevocably submit to the exclusive jurisdiction of the courts in that state or location.",
                'bn' => "আমাদের সেবার শর্তাবলীতে স্বাগতম। এই শর্ত এবং নিয়মাবলী আমাদের ওয়েবসাইট এবং সেবা ব্যবহারের নিয়মকানুন বর্ণনা করে।\n\nএই ওয়েবসাইট অ্যাক্সেস করে, আমরা ধরে নিচ্ছি যে আপনি এই শর্তাবলী গ্রহণ করেছেন। এই পৃষ্ঠায় উল্লেখিত সমস্ত শর্তাবলীতে সম্মত না হলে আমাদের ওয়েবসাইট ব্যবহার চালিয়ে যাবেন না।\n\nনিম্নলিখিত পরিভাষা এই শর্তাবলীর ক্ষেত্রে প্রযোজ্য:\n\n১. ব্যবহারের লাইসেন্স\nব্যক্তিগত, অ-বাণিজ্যিক ক্ষণস্থায়ী দেখার জন্য আমাদের ওয়েবসাইটের উপকরণগুলির একটি অনুলিপি সাময়িকভাবে ডাউনলোড করার অনুমতি দেওয়া হয়েছে।\n\n২. দাবিত্যাগ\nআমাদের ওয়েবসাইটের উপকরণগুলি 'যেমন আছে' ভিত্তিতে প্রদান করা হয়। আমরা কোনো ওয়ারেন্টি প্রদান করি না এবং এর দ্বারা অন্যান্য সমস্ত ওয়ারেন্টি অস্বীকার করি।\n\n৩. সীমাবদ্ধতা\nকোনো অবস্থাতেই আমাদের কোম্পানি বা এর সরবরাহকারীগণ ওয়েবসাইটের উপকরণ ব্যবহার বা ব্যবহারে অক্ষমতার কারণে সৃষ্ট কোনো ক্ষতির জন্য দায়বদ্ধ থাকবে না।"
            ],
            'template' => 'terms-of-service',
            'meta_title' => [
                'en' => 'Terms of Service - Your Company',
                'bn' => 'সেবার শর্তাবলী - আপনার কোম্পানি'
            ],
            'meta_description' => [
                'en' => 'Read our terms of service to understand the rules and regulations for using our website and services.',
                'bn' => 'আমাদের ওয়েবসাইট এবং সেবা ব্যবহারের নিয়মকানুন বুঝতে আমাদের সেবার শর্তাবলী পড়ুন।'
            ],
            'keywords' => [
                'en' => 'terms of service, legal, conditions, website rules, user agreement',
                'bn' => 'সেবার শর্তাবলী, আইনি, শর্তাবলী, ওয়েবসাইট নিয়ম, ব্যবহারকারী চুক্তি'
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
                'en' => "We are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, and safeguard your data when you visit our website.\n\nInformation We Collect:\n- Personal information you provide (name, email, phone number)\n- Technical information (IP address, browser type, device information)\n- Usage information (pages visited, time spent, interactions)\n- Cookies and similar tracking technologies\n\nHow We Use Your Information:\n- To provide and improve our services\n- To communicate with you about our services\n- To personalize your experience\n- To analyze website usage and performance\n- To comply with legal obligations\n\nData Security:\nWe implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.\n\nThird-Party Services:\nWe may use third-party services for analytics, advertising, and other business purposes. These services have their own privacy policies.\n\nYour Rights:\n- Access your personal data\n- Correct inaccurate information\n- Request deletion of your data\n- Object to data processing\n- Data portability\n\nCookies:\nWe use cookies to enhance your browsing experience. You can control cookie settings through your browser.\n\nContact Us:\nIf you have questions about this Privacy Policy, please contact our Data Protection Officer at privacy@yourcompany.com.",
                'bn' => "আমরা আপনার গোপনীয়তা রক্ষা এবং আপনার ব্যক্তিগত তথ্যের নিরাপত্তা নিশ্চিত করতে প্রতিশ্রুতিবদ্ধ। এই গোপনীয়তার নীতি ব্যাখ্যা করে যে আপনি আমাদের ওয়েবসাইট পরিদর্শন করার সময় আমরা কীভাবে আপনার ডেটা সংগ্রহ, ব্যবহার এবং সুরক্ষিত রাখি।\n\nআমরা যে তথ্য সংগ্রহ করি:\n- আপনার প্রদত্ত ব্যক্তিগত তথ্য (নাম, ইমেইল, ফোন নম্বর)\n- প্রযুক্তিগত তথ্য (আইপি ঠিকানা, ব্রাউজারের ধরন, ডিভাইসের তথ্য)\n- ব্যবহারের তথ্য (পরিদর্শিত পৃষ্ঠা, ব্যয়িত সময়, মিথস্ক্রিয়া)\n- কুকিজ এবং অনুরূপ ট্র্যাকিং প্রযুক্তি\n\nআমরা কীভাবে আপনার তথ্য ব্যবহার করি:\n- আমাদের সেবা প্রদান এবং উন্নত করতে\n- আমাদের সেবা সম্পর্কে আপনার সাথে যোগাযোগ করতে\n- আপনার অভিজ্ঞতা ব্যক্তিগতকরণ করতে\n- ওয়েবসাইট ব্যবহার এবং কর্মক্ষমতা বিশ্লেষণ করতে\n- আইনি বাধ্যবাধকতা মেনে চলতে\n\nডেটা নিরাপত্তা:\nআমরা অননুমোদিত অ্যাক্সেস, পরিবর্তন, প্রকাশ বা ধ্বংসের বিরুদ্ধে আপনার ব্যক্তিগত তথ্য রক্ষা করতে উপযুক্ত প্রযুক্তিগত এবং সাংগঠনিক ব্যবস্থা বাস্তবায়ন করি।"
            ],
            'template' => 'privacy-policy',
            'meta_title' => [
                'en' => 'Privacy Policy - Your Company',
                'bn' => 'গোপনীয়তার নীতি - আপনার কোম্পানি'
            ],
            'meta_description' => [
                'en' => 'Learn how we collect, use, and protect your personal information. Read our privacy policy for complete details.',
                'bn' => 'আমরা কীভাবে আপনার ব্যক্তিগত তথ্য সংগ্রহ, ব্যবহার এবং সুরক্ষিত রাখি তা জানুন। সম্পূর্ণ বিবরণের জন্য আমাদের গোপনীয়তার নীতি পড়ুন।'
            ],
            'keywords' => [
                'en' => 'privacy policy, data protection, personal information, cookies, GDPR, data security',
                'bn' => 'গোপনীয়তার নীতি, ডেটা সুরক্ষা, ব্যক্তিগত তথ্য, কুকিজ, জিডিপিআর, ডেটা নিরাপত্তা'
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