<?php

namespace Modules\VisaProcessing\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\VisaProcessing\Models\VisaProcessing;
use Carbon\Carbon;

class SeedVisaContentCommand extends Command
{
    protected $signature = 'visa:seed-content {--force : Force overwrite existing records}';
    protected $description = 'Seed visa processing content from markdown files';

    private $countryMapping = [
        'australia' => ['name' => 'Australia', 'flag' => '🇦🇺'],
        'brunei' => ['name' => 'Brunei', 'flag' => '🇧🇳'],
        'cambodia' => ['name' => 'Cambodia', 'flag' => '🇰🇭'],
        'canada' => ['name' => 'Canada', 'flag' => '🇨🇦'],
        'china' => ['name' => 'China', 'flag' => '🇨🇳'],
        'egypt' => ['name' => 'Egypt', 'flag' => '🇪🇬'],
        'ethiopia' => ['name' => 'Ethiopia', 'flag' => '🇪🇹'],
        'france' => ['name' => 'France', 'flag' => '🇫🇷'],
        'hong_kong' => ['name' => 'Hong Kong', 'flag' => '🇭🇰'],
        'india' => ['name' => 'India', 'flag' => '🇮🇳'],
        'indonesia' => ['name' => 'Indonesia', 'flag' => '🇮🇩'],
        'italy' => ['name' => 'Italy', 'flag' => '🇮🇹'],
        'japan' => ['name' => 'Japan', 'flag' => '🇯🇵'],
        'kazakhstan' => ['name' => 'Kazakhstan', 'flag' => '🇰🇿'],
        'kenya' => ['name' => 'Kenya', 'flag' => '🇰🇪'],
        'kyrgyzstan' => ['name' => 'Kyrgyzstan', 'flag' => '🇰🇬'],
        'malaysia' => ['name' => 'Malaysia', 'flag' => '🇲🇾'],
        'maldives' => ['name' => 'Maldives', 'flag' => '🇲🇻'],
        'morocco' => ['name' => 'Morocco', 'flag' => '🇲🇦'],
        'nepal' => ['name' => 'Nepal', 'flag' => '🇳🇵'],
        'philippines' => ['name' => 'Philippines', 'flag' => '🇵🇭'],
        'qatar' => ['name' => 'Qatar', 'flag' => '🇶🇦'],
        'singapore' => ['name' => 'Singapore', 'flag' => '🇸🇬'],
        'sri_lanka' => ['name' => 'Sri Lanka', 'flag' => '🇱🇰'],
        'tanzania' => ['name' => 'Tanzania', 'flag' => '🇹🇿'],
        'thailand' => ['name' => 'Thailand', 'flag' => '🇹🇭'],
        'turkey' => ['name' => 'Turkey', 'flag' => '🇹🇷'],
        'united_arab_emirates' => ['name' => 'United Arab Emirates', 'flag' => '🇦🇪'],
        'uzbekistan' => ['name' => 'Uzbekistan', 'flag' => '🇺🇿'],
        'vietnam' => ['name' => 'Vietnam', 'flag' => '🇻🇳'],
        'visa_requirements_for_south_korea' => ['name' => 'South Korea', 'flag' => '🇰🇷'],
    ];

    public function handle()
    {
        $this->info('Starting visa content seeding...');
        
        $contentPath = base_path('content-generation/package--rajib-dada/prompts-single-rajib-dada');
        
        if (!File::exists($contentPath)) {
            $this->error("Content directory not found: {$contentPath}");
            return 1;
        }

        $files = File::glob($contentPath . '/*.md');
        $created = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($files as $file) {
            $result = $this->processFile($file);
            
            switch ($result) {
                case 'created':
                    $created++;
                    break;
                case 'updated':
                    $updated++;
                    break;
                case 'skipped':
                    $skipped++;
                    break;
            }
        }

        $this->info("\nSeeding completed!");
        $this->info("Created: {$created}");
        $this->info("Updated: {$updated}");
        $this->info("Skipped: {$skipped}");
        
        return 0;
    }

    private function processFile($filePath)
    {
        $filename = basename($filePath, '.md');
        $content = File::get($filePath);
        
        // Parse country and visa type from filename
        $parsedData = $this->parseFilename($filename);
        
        if (!$parsedData) {
            $this->warn("Could not parse filename: {$filename}");
            return 'skipped';
        }

        // Check if record already exists
        $countryKey = VisaProcessing::getCountryKeyFromSlug($parsedData['country_slug']) ?? $parsedData['country_slug'];
        $existing = VisaProcessing::where('country', $countryKey)
            ->where('visa_type', $parsedData['visa_type'])
            ->first();

        if ($existing && !$this->option('force')) {
            $this->line("Skipping existing record: {$parsedData['country_name']} {$parsedData['visa_type']} visa");
            return 'skipped';
        }

        // Parse markdown content
        $parsedContent = $this->parseMarkdownContent($content);
        
        // Generate pricing based on country and visa type
        $pricing = $this->generatePricing($parsedData['country_name'], $parsedData['visa_type']);

        $data = [
            'english_title' => $parsedData['english_title'],
            'title' => [
                'en' => $parsedData['english_title'],
                'bn' => $this->generateBengaliTitle($parsedData['country_name'], $parsedData['visa_type'])
            ],
            'content' => [
                'en' => $parsedContent['content'],
                'bn' => $this->generateBengaliContent($parsedData['country_name'], $parsedData['visa_type'])
            ],
            'country' => $countryKey,
            'visa_type' => $parsedData['visa_type'],
            'visa_fees' => $pricing['visa_fees'],
            'processing_fee' => $pricing['processing_fee'],
            'processing_days' => $pricing['processing_days'],
            'required_documents' => $parsedContent['documents'] ?? $this->getDefaultDocuments($parsedData['visa_type']),
            'meta_title' => [
                'en' => $parsedData['english_title'] . ' - Apply Online',
                'bn' => $parsedData['country_name'] . ' ভিসা আবেদন - অনলাইনে আবেদন করুন'
            ],
            'meta_description' => [
                'en' => "Apply for {$parsedData['english_title']} online. Fast processing, competitive rates, and expert assistance.",
                'bn' => "{$parsedData['country_name']} ভিসার জন্য অনলাইনে আবেদন করুন। দ্রুত প্রক্রিয়াকরণ এবং প্রতিযোগিতামূলক হার।"
            ],
            'keywords' => [
                'en' => "{$parsedData['country_name']} visa, {$parsedData['visa_type']} visa, visa application, travel visa",
                'bn' => "{$parsedData['country_name']} ভিসা, {$parsedData['visa_type']} ভিসা, ভিসা আবেদন, ভ্রমণ ভিসা"
            ],
            'status' => 'published',
            'published_at' => now(),
            'position' => 0,
            'is_featured' => $this->shouldBeFeatured($parsedData['country_name'], $parsedData['visa_type']),
            'estimated_processing_time' => $pricing['processing_days'],
            'embassy_info' => $this->getEmbassyInfo($parsedData['country_name']),
            'difficulty_level' => $this->getDifficultyLevel($parsedData['country_name'], $parsedData['visa_type']),
            'user_id' => 1, // Admin user
        ];

        if ($existing) {
            $existing->update($data);
            $this->info("Updated: {$parsedData['english_title']}");
            return 'updated';
        } else {
            VisaProcessing::create($data);
            $this->info("Created: {$parsedData['english_title']}");
            return 'created';
        }
    }

    private function parseFilename($filename)
    {
        // Handle special cases
        if ($filename === 'visa_requirements_for_south_korea') {
            return [
                'country_name' => 'South Korea',
                'country_slug' => 'south-korea',
                'visa_type' => 'tourist',
                'english_title' => 'South Korea Tourist Visa'
            ];
        }

        if ($filename === 'japan_package') {
            return [
                'country_name' => 'Japan',
                'country_slug' => 'japan',
                'visa_type' => 'tourist',
                'english_title' => 'Japan Tourist Visa Package'
            ];
        }

        if ($filename === 'indonesia') {
            return [
                'country_name' => 'Indonesia',
                'country_slug' => 'indonesia',
                'visa_type' => 'tourist',
                'english_title' => 'Indonesia Tourist Visa'
            ];
        }

        // Extract country and visa type
        $parts = explode('_', $filename);
        
        if (count($parts) < 2) {
            return null;
        }

        $country = $parts[0];
        $visaType = 'tourist'; // default
        
        if (strpos($filename, 'business') !== false) {
            $visaType = 'business';
        } elseif (strpos($filename, 'medical') !== false) {
            $visaType = 'medical';
        } elseif (strpos($filename, 'evisa') !== false) {
            $visaType = 'tourist'; // e-visa is still tourist
        }

        // Handle multi-word countries
        if (in_array($country, ['hong', 'sri', 'united'])) {
            if ($country === 'hong') {
                $country = 'hong_kong';
                $countryName = 'Hong Kong';
            } elseif ($country === 'sri') {
                $country = 'sri_lanka';
                $countryName = 'Sri Lanka';
            } elseif ($country === 'united') {
                $country = 'united_arab_emirates';
                $countryName = 'United Arab Emirates';
            }
        } else {
            $countryName = $this->countryMapping[$country]['name'] ?? ucfirst($country);
        }

        return [
            'country_name' => $countryName,
            'country_slug' => Str::slug($countryName),
            'visa_type' => $visaType,
            'english_title' => "{$countryName} " . ucfirst($visaType) . " Visa"
        ];
    }

    private function parseMarkdownContent($content)
    {
        // Remove markdown headers and clean content
        $content = preg_replace('/^#+\s+/m', '', $content);
        $content = trim($content);
        
        // Extract documents if present
        $documents = [];
        if (preg_match('/(?:Required Documents|Documents|Requirements):\s*\n((?:[-*]\s+.+\n?)+)/im', $content, $matches)) {
            $docLines = explode("\n", trim($matches[1]));
            foreach ($docLines as $line) {
                $line = trim($line);
                if (preg_match('/^[-*]\s+(.+)$/', $line, $match)) {
                    $documents[] = trim($match[1]);
                }
            }
        }

        return [
            'content' => $content,
            'documents' => $documents
        ];
    }

    private function generatePricing($countryName, $visaType)
    {
        $basePrices = [
            'Australia' => 8000,
            'Canada' => 7500,
            'Japan' => 6000,
            'Singapore' => 4500,
            'Thailand' => 3500,
            'Malaysia' => 3000,
            'Indonesia' => 2500,
            'Vietnam' => 2000,
            'Cambodia' => 2000,
            'Nepal' => 1500,
            'India' => 2500,
        ];

        $typeMultiplier = [
            'tourist' => 1.0,
            'business' => 1.3,
            'medical' => 1.2,
            'work' => 1.5,
            'student' => 1.4,
            'transit' => 0.8,
        ];

        $basePrice = $basePrices[$countryName] ?? 4000;
        $multiplier = $typeMultiplier[$visaType] ?? 1.0;
        
        $visaFees = (int)($basePrice * $multiplier);
        $processingFee = (int)($visaFees * 0.15); // 15% processing fee
        $processingDays = $this->getProcessingDays($countryName, $visaType);

        return [
            'visa_fees' => $visaFees,
            'processing_fee' => $processingFee,
            'processing_days' => $processingDays
        ];
    }

    private function getProcessingDays($countryName, $visaType)
    {
        $standardDays = [
            'Australia' => 15,
            'Canada' => 20,
            'Japan' => 10,
            'Singapore' => 5,
            'Thailand' => 3,
            'Malaysia' => 7,
            'Indonesia' => 5,
            'Vietnam' => 5,
            'Cambodia' => 3,
            'Nepal' => 7,
            'India' => 10,
        ];

        $days = $standardDays[$countryName] ?? 7;
        
        if ($visaType === 'business' || $visaType === 'work') {
            $days += 5;
        }

        return $days;
    }

    private function getDefaultDocuments($visaType)
    {
        $common = [
            'Valid passport (minimum 6 months validity)',
            'Completed visa application form',
            'Recent passport-size photographs',
            'Flight itinerary or booking confirmation',
            'Hotel booking confirmation',
            'Bank statement (last 3 months)',
            'No objection certificate (NOC)',
        ];

        $typeSpecific = [
            'business' => [
                'Business invitation letter',
                'Company registration certificate',
                'Business card',
            ],
            'medical' => [
                'Medical appointment letter',
                'Hospital admission letter',
                'Medical reports',
            ],
            'student' => [
                'University admission letter',
                'Academic transcripts',
                'Scholarship documents (if applicable)',
            ],
        ];

        return array_merge($common, $typeSpecific[$visaType] ?? []);
    }

    private function getEmbassyInfo($countryName)
    {
        $embassies = [
            'Thailand' => [
                'address' => 'House 18, Road 2, Dhanmondi R/A, Dhaka 1205',
                'phone' => '+880-2-8616395',
                'email' => 'thaiemb.dhk@mfa.go.th',
                'website' => 'http://www.thaiembassydhaka.org',
            ],
            'Malaysia' => [
                'address' => 'House 20, Road 6, Dhanmondi R/A, Dhaka 1205',
                'phone' => '+880-2-8616364',
                'email' => 'mdhaka@kln.gov.my',
                'website' => 'https://www.kln.gov.my/web/bgd_dhaka',
            ],
            'Singapore' => [
                'address' => 'Road 71, Gulshan 2, Dhaka 1212',
                'phone' => '+880-2-8837645',
                'email' => 'singemb_dhk@mfa.sg',
                'website' => 'https://www.mfa.gov.sg/dhaka',
            ],
        ];

        return $embassies[$countryName] ?? [
            'address' => 'Embassy information available on request',
            'phone' => 'Contact for details',
            'email' => 'Visit embassy website',
            'website' => 'Official embassy website',
        ];
    }

    private function getDifficultyLevel($countryName, $visaType)
    {
        $easyCountries = ['Thailand', 'Malaysia', 'Indonesia', 'Cambodia', 'Nepal'];
        $hardCountries = ['Australia', 'Canada', 'Japan', 'Singapore'];

        if (in_array($countryName, $easyCountries)) {
            return 'easy';
        } elseif (in_array($countryName, $hardCountries)) {
            return 'hard';
        }

        return 'medium';
    }

    private function shouldBeFeatured($countryName, $visaType)
    {
        $featuredCountries = ['Thailand', 'Malaysia', 'Singapore', 'Japan', 'Australia'];
        return in_array($countryName, $featuredCountries) && $visaType === 'tourist';
    }

    private function generateBengaliTitle($countryName, $visaType)
    {
        $countryBengali = [
            'Thailand' => 'থাইল্যান্ড',
            'Malaysia' => 'মালয়েশিয়া',
            'Singapore' => 'সিঙ্গাপুর',
            'Japan' => 'জাপান',
            'Australia' => 'অস্ট্রেলিয়া',
            'Canada' => 'কানাডা',
            'India' => 'ভারত',
            'Nepal' => 'নেপাল',
            'Indonesia' => 'ইন্দোনেশিয়া',
            'Vietnam' => 'ভিয়েতনাম',
            'Cambodia' => 'কম্বোডিয়া',
        ];

        $visaTypeBengali = [
            'tourist' => 'পর্যটন',
            'business' => 'ব্যবসায়িক',
            'medical' => 'চিকিৎসা',
            'work' => 'কাজের',
            'student' => 'ছাত্র',
        ];

        $country = $countryBengali[$countryName] ?? $countryName;
        $type = $visaTypeBengali[$visaType] ?? $visaType;

        return "{$country} {$type} ভিসা";
    }

    private function generateBengaliContent($countryName, $visaType)
    {
        return "এই {$countryName} {$visaType} ভিসার জন্য আবেদন করুন। আমরা দ্রুত এবং নির্ভরযোগ্য ভিসা প্রক্রিয়াকরণ সেবা প্রদান করি। আমাদের অভিজ্ঞ দল আপনার ভিসা আবেদনের প্রতিটি ধাপে সহায়তা করবে।";
    }
}