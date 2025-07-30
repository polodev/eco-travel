<?php

namespace Modules\Tour\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Tour\Models\Tour;
use Modules\Tour\Models\TourItinerary;
use Modules\Tour\Models\TourDate;
use Modules\Location\Models\Country;
use Modules\Location\Models\City;
use Carbon\Carbon;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bangladesh = Country::where('name', 'Bangladesh')->first();
        $thailand = Country::where('name', 'Thailand')->first();
        $india = Country::where('name', 'India')->first();

        // Get cities
        $dhaka = City::where('name', 'Dhaka')->first();
        $coxsBazar = City::where('name', "Cox's Bazar")->first();
        $sylhet = City::where('name', 'Sylhet')->first();
        $bangkok = City::where('name', 'Bangkok')->first();
        $delhi = City::where('name', 'Delhi')->first();

        // Create Bangladesh Tours
        $tours = [
            [
                'name' => "Cox's Bazar Sea Beach Adventure",
                'description' => 'Explore the world\'s longest sea beach with exciting activities and local culture.',
                'detailed_description' => 'Experience the beauty of Cox\'s Bazar, the world\'s longest unbroken sea beach. This tour includes beach activities, local cuisine, sunset watching, and cultural experiences with the local community.',
                'country_id' => $bangladesh->id,
                'city_id' => $coxsBazar->id,
                'duration_days' => 3,
                'duration_nights' => 2,
                'difficulty_level' => 'easy',
                'tour_type' => 'beach',
                'min_group_size' => 2,
                'max_group_size' => 15,
                'base_price' => 8500.00,
                'child_price' => 6000.00,
                'single_supplement' => 2000.00,
                'included_services' => [
                    'Accommodation in sea-facing hotel',
                    'All meals (breakfast, lunch, dinner)',
                    'Transportation from Dhaka',
                    'Local sightseeing',
                    'Professional tour guide',
                    'Beach activities'
                ],
                'excluded_services' => [
                    'Personal expenses',
                    'Tips and gratuities',
                    'Travel insurance',
                    'Optional activities'
                ],
                'amenities' => [
                    'Sea view accommodation',
                    'Air-conditioned transport',
                    'Professional photography',
                    'Local cultural shows'
                ],
                'age_restrictions' => [
                    'minimum_age' => 5,
                    'maximum_age' => null,
                    'notes' => 'Children under 5 travel free'
                ],
                'what_to_bring' => [
                    'Comfortable walking shoes',
                    'Sunscreen and hat',
                    'Swimming clothes',
                    'Light cotton clothes',
                    'Personal medications'
                ],
                'meeting_point' => 'Dhaka Airport',
                'meeting_time' => '08:00:00',
                'cancellation_policy' => [
                    '30_days_before' => '10% cancellation fee',
                    '15_days_before' => '25% cancellation fee',
                    '7_days_before' => '50% cancellation fee',
                    '3_days_before' => '75% cancellation fee',
                    'same_day' => 'No refund'
                ],
                'rating' => 4.5,
                'total_reviews' => 127,
                'is_featured' => true,
                'is_active' => true,
                'availability_status' => 'available',
                'tour_operator' => 'Bangladesh Adventure Tours',
                'contact_person' => 'Karim Rahman',
                'contact_phone' => '+880-1711-123456',
                'contact_email' => 'karim@bdadventure.com',
                'pickup_locations' => [
                    'Dhaka Airport',
                    'Dhaka Railway Station',
                    'Selected hotels in Dhaka'
                ],
                'languages' => ['Bengali', 'English'],
                'special_notes' => 'Best time to visit is October to March for pleasant weather.'
            ],
            [
                'name' => 'Sylhet Tea Garden & Jaflong Tour',
                'description' => 'Discover the tea gardens of Sylhet and the scenic beauty of Jaflong stone quarry.',
                'detailed_description' => 'Immerse yourself in the lush green tea gardens of Sylhet, visit the famous Jaflong stone quarry, and experience the natural beauty of northeastern Bangladesh.',
                'country_id' => $bangladesh->id,
                'city_id' => $sylhet->id,
                'duration_days' => 4,
                'duration_nights' => 3,
                'difficulty_level' => 'moderate',
                'tour_type' => 'nature',
                'min_group_size' => 4,
                'max_group_size' => 20,
                'base_price' => 12000.00,
                'child_price' => 8500.00,
                'single_supplement' => 2500.00,
                'included_services' => [
                    'Hotel accommodation',
                    'All meals during tour',
                    'Transportation',
                    'Tea garden visits',
                    'Jaflong sightseeing',
                    'Local guide services'
                ],
                'excluded_services' => [
                    'Personal shopping',
                    'Extra meals',
                    'Alcoholic beverages',
                    'Personal insurance'
                ],
                'amenities' => [
                    'Tea tasting sessions',
                    'Nature photography',
                    'Hill station visits',
                    'Local cultural experiences'
                ],
                'age_restrictions' => [
                    'minimum_age' => 8,
                    'maximum_age' => null,
                    'notes' => 'Some walking required in tea gardens'
                ],
                'what_to_bring' => [
                    'Comfortable hiking shoes',
                    'Light jacket for cool mornings',
                    'Camera',
                    'Insect repellent',
                    'Personal water bottle'
                ],
                'meeting_point' => 'Sylhet Airport',
                'meeting_time' => '10:00:00',
                'cancellation_policy' => [
                    '30_days_before' => '15% cancellation fee',
                    '15_days_before' => '30% cancellation fee',
                    '7_days_before' => '60% cancellation fee',
                    '3_days_before' => '80% cancellation fee',
                    'same_day' => 'No refund'
                ],
                'rating' => 4.2,
                'total_reviews' => 89,
                'is_featured' => false,
                'is_active' => true,
                'availability_status' => 'available',
                'tour_operator' => 'Green Bangladesh Tours',
                'contact_person' => 'Fatima Khatun',
                'contact_phone' => '+880-1712-234567',
                'contact_email' => 'fatima@greenbdtours.com',
                'pickup_locations' => [
                    'Sylhet Airport',
                    'Sylhet City Center',
                    'Major hotels in Sylhet'
                ],
                'languages' => ['Bengali', 'English'],
                'special_notes' => 'Monsoon season (June-September) offers lush greenery but can be challenging for outdoor activities.'
            ],
            [
                'name' => 'Bangkok City Explorer',
                'description' => 'Comprehensive Bangkok city tour covering temples, markets, and cultural attractions.',
                'detailed_description' => 'Explore the vibrant capital of Thailand with visits to iconic temples, bustling markets, royal palaces, and modern attractions. Experience Thai culture, cuisine, and hospitality.',
                'country_id' => $thailand->id,
                'city_id' => $bangkok->id,
                'duration_days' => 5,
                'duration_nights' => 4,
                'difficulty_level' => 'easy',
                'tour_type' => 'city',
                'min_group_size' => 2,
                'max_group_size' => 25,
                'base_price' => 35000.00,
                'child_price' => 25000.00,
                'single_supplement' => 8000.00,
                'included_services' => [
                    '4-star hotel accommodation',
                    'Daily breakfast',
                    'Airport transfers',
                    'City sightseeing tours',
                    'Temple entrance fees',
                    'English-speaking guide',
                    'River cruise dinner'
                ],
                'excluded_services' => [
                    'International flights',
                    'Lunch and dinner (except cruise)',
                    'Personal shopping',
                    'Optional tours',
                    'Tips and gratuities'
                ],
                'amenities' => [
                    'Temple hopping',
                    'Thai cooking class',
                    'Traditional massage',
                    'Shopping at local markets',
                    'Chao Phraya river cruise'
                ],
                'age_restrictions' => [
                    'minimum_age' => 3,
                    'maximum_age' => null,
                    'notes' => 'Family-friendly tour suitable for all ages'
                ],
                'what_to_bring' => [
                    'Comfortable walking shoes',
                    'Modest clothing for temples',
                    'Sun protection',
                    'Passport and visa',
                    'Personal medications'
                ],
                'meeting_point' => 'Bangkok Suvarnabhumi Airport',
                'meeting_time' => 'Upon arrival',
                'cancellation_policy' => [
                    '45_days_before' => '10% cancellation fee',
                    '30_days_before' => '25% cancellation fee',
                    '15_days_before' => '50% cancellation fee',
                    '7_days_before' => '75% cancellation fee',
                    'same_day' => 'No refund'
                ],
                'rating' => 4.7,
                'total_reviews' => 203,
                'is_featured' => true,
                'is_active' => true,
                'availability_status' => 'available',
                'tour_operator' => 'Thai Discovery Tours',
                'contact_person' => 'Somchai Prasert',
                'contact_phone' => '+66-2-123-4567',
                'contact_email' => 'somchai@thaidiscovery.com',
                'pickup_locations' => [
                    'Bangkok Airport',
                    'Bangkok city hotels',
                    'Bangkok train station'
                ],
                'languages' => ['English', 'Thai', 'Bengali'],
                'special_notes' => 'Dress code required for temple visits - covered shoulders and knees.'
            ]
        ];

        foreach ($tours as $tourData) {
            $tour = Tour::create($tourData);
            
            // Create itineraries for each tour
            $this->createItineraries($tour);
            
            // Create tour dates
            $this->createTourDates($tour);
        }
    }

    /**
     * Create itineraries for a tour.
     */
    private function createItineraries(Tour $tour)
    {
        $itineraries = [];

        if ($tour->name === "Cox's Bazar Sea Beach Adventure") {
            $itineraries = [
                [
                    'day_number' => 1,
                    'day_title' => 'Arrival & Beach Exploration',
                    'day_description' => 'Arrive at Cox\'s Bazar, check into hotel, and enjoy your first sunset at the world\'s longest sea beach.',
                    'activities' => [
                        'Hotel check-in',
                        'Welcome lunch',
                        'Beach walk',
                        'Sunset viewing',
                        'Dinner at beachside restaurant'
                    ],
                    'meals_included' => ['lunch', 'dinner'],
                    'accommodation' => 'Sea Palace Hotel',
                    'accommodation_type' => 'hotel',
                    'accommodation_rating' => 4,
                    'location' => "Cox's Bazar",
                    'start_time' => '12:00:00',
                    'end_time' => '22:00:00',
                    'transportation' => ['Tourist bus from Dhaka'],
                    'estimated_distance' => 420.00,
                    'estimated_duration' => 480,
                    'optional_activities' => [
                        'Horse riding on beach (৳500)',
                        'Parasailing (৳2000)'
                    ],
                    'meal_options' => ['Bengali', 'Chinese', 'Continental'],
                    'special_notes' => 'Keep passports ready for hotel check-in.',
                    'is_rest_day' => false,
                    'sort_order' => 1
                ],
                [
                    'day_number' => 2,
                    'day_title' => 'Full Day Beach Activities',
                    'day_description' => 'Enjoy a full day of beach activities, water sports, and local sightseeing.',
                    'activities' => [
                        'Morning beach walk',
                        'Visit to Himchari National Park',
                        'Inani Beach visit',
                        'Local market shopping',
                        'Cultural show in evening'
                    ],
                    'meals_included' => ['breakfast', 'lunch', 'dinner'],
                    'accommodation' => 'Sea Palace Hotel',
                    'accommodation_type' => 'hotel',
                    'accommodation_rating' => 4,
                    'location' => "Cox's Bazar",
                    'start_time' => '08:00:00',
                    'end_time' => '21:00:00',
                    'transportation' => ['Local bus', 'Rickshaw'],
                    'estimated_distance' => 75.00,
                    'estimated_duration' => 600,
                    'optional_activities' => [
                        'Jet ski (৳3000)',
                        'Deep sea fishing (৳5000)'
                    ],
                    'meal_options' => ['Fresh seafood', 'Local Bengali cuisine'],
                    'special_notes' => 'Wear comfortable clothes for hiking in Himchari.',
                    'is_rest_day' => false,
                    'sort_order' => 2
                ],
                [
                    'day_number' => 3,
                    'day_title' => 'Departure Day',
                    'day_description' => 'Final morning at the beach before departure to Dhaka.',
                    'activities' => [
                        'Early morning beach walk',
                        'Hotel checkout',
                        'Souvenir shopping',
                        'Departure to Dhaka'
                    ],
                    'meals_included' => ['breakfast'],
                    'accommodation' => null,
                    'accommodation_type' => null,
                    'accommodation_rating' => null,
                    'location' => "Cox's Bazar to Dhaka",
                    'start_time' => '08:00:00',
                    'end_time' => '20:00:00',
                    'transportation' => ['Tourist bus to Dhaka'],
                    'estimated_distance' => 420.00,
                    'estimated_duration' => 480,
                    'optional_activities' => [
                        'Extended beach time (no extra cost)'
                    ],
                    'meal_options' => ['Packed lunch available (৳300)'],
                    'special_notes' => 'Check out by 11 AM. Keep some time for last-minute shopping.',
                    'is_rest_day' => false,
                    'sort_order' => 3
                ]
            ];
        } elseif ($tour->name === 'Sylhet Tea Garden & Jaflong Tour') {
            $itineraries = [
                [
                    'day_number' => 1,
                    'day_title' => 'Arrival & City Tour',
                    'day_description' => 'Arrive in Sylhet and explore the city\'s main attractions.',
                    'activities' => [
                        'Airport pickup',
                        'Hotel check-in',
                        'Lunch at local restaurant',
                        'Visit Hazrat Shah Jalal Mazar',
                        'Explore Sylhet city center'
                    ],
                    'meals_included' => ['lunch', 'dinner'],
                    'accommodation' => 'Hotel Supreme',
                    'accommodation_type' => 'hotel',
                    'accommodation_rating' => 3,
                    'location' => 'Sylhet City',
                    'start_time' => '11:00:00',
                    'end_time' => '21:00:00',
                    'transportation' => ['Local car'],
                    'estimated_distance' => 25.00,
                    'estimated_duration' => 300,
                    'optional_activities' => [
                        'Traditional boat ride (৳800)'
                    ],
                    'meal_options' => ['Local Sylheti cuisine', 'Bengali'],
                    'special_notes' => 'Dress modestly for visiting religious sites.',
                    'is_rest_day' => false,
                    'sort_order' => 1
                ],
                [
                    'day_number' => 2,
                    'day_title' => 'Tea Garden Experience',
                    'day_description' => 'Full day exploring the famous tea gardens of Sylhet.',
                    'activities' => [
                        'Visit Malnichhara Tea Garden',
                        'Tea plucking experience',
                        'Tea processing factory tour',
                        'Tea tasting session',
                        'Lunch at tea garden'
                    ],
                    'meals_included' => ['breakfast', 'lunch', 'dinner'],
                    'accommodation' => 'Hotel Supreme',
                    'accommodation_type' => 'hotel',
                    'accommodation_rating' => 3,
                    'location' => 'Sylhet Tea Gardens',
                    'start_time' => '09:00:00',
                    'end_time' => '18:00:00',
                    'transportation' => ['Tourist van'],
                    'estimated_distance' => 120.00,
                    'estimated_duration' => 480,
                    'optional_activities' => [
                        'Tea garden photography tour (৳1500)'
                    ],
                    'meal_options' => ['Garden fresh meals', 'Local specialties'],
                    'special_notes' => 'Wear comfortable shoes for walking in tea gardens.',
                    'is_rest_day' => false,
                    'sort_order' => 2
                ],
                [
                    'day_number' => 3,
                    'day_title' => 'Jaflong Adventure',
                    'day_description' => 'Visit the scenic Jaflong stone quarry and enjoy nature.',
                    'activities' => [
                        'Drive to Jaflong',
                        'Stone quarry observation',
                        'River cruise',
                        'Visit tribal village',
                        'Local handicraft shopping'
                    ],
                    'meals_included' => ['breakfast', 'lunch', 'dinner'],
                    'accommodation' => 'Hotel Supreme',
                    'accommodation_type' => 'hotel',
                    'accommodation_rating' => 3,
                    'location' => 'Jaflong',
                    'start_time' => '08:00:00',
                    'end_time' => '19:00:00',
                    'transportation' => ['Tourist van', 'Local boat'],
                    'estimated_distance' => 140.00,
                    'estimated_duration' => 420,
                    'optional_activities' => [
                        'Stone collection (৳500)',
                        'Tribal culture show (৳1000)'
                    ],
                    'meal_options' => ['River fish specialty', 'Tribal cuisine'],
                    'special_notes' => 'Border area - carry valid ID. Weather dependent activities.',
                    'is_rest_day' => false,
                    'sort_order' => 3
                ],
                [
                    'day_number' => 4,
                    'day_title' => 'Departure',
                    'day_description' => 'Final exploration and departure from Sylhet.',
                    'activities' => [
                        'Morning free time',
                        'Visit local market',
                        'Hotel checkout',
                        'Transfer to airport/station'
                    ],
                    'meals_included' => ['breakfast'],
                    'accommodation' => null,
                    'accommodation_type' => null,
                    'accommodation_rating' => null,
                    'location' => 'Sylhet City',
                    'start_time' => '09:00:00',
                    'end_time' => '14:00:00',
                    'transportation' => ['Local car'],
                    'estimated_distance' => 15.00,
                    'estimated_duration' => 180,
                    'optional_activities' => [
                        'Extended city tour (৳2000)'
                    ],
                    'meal_options' => ['Airport/station meals available'],
                    'special_notes' => 'Check departure times. Keep souvenirs safe.',
                    'is_rest_day' => false,
                    'sort_order' => 4
                ]
            ];
        } else { // Bangkok City Explorer
            $itineraries = [
                [
                    'day_number' => 1,
                    'day_title' => 'Arrival & Grand Palace',
                    'day_description' => 'Arrive in Bangkok and visit the magnificent Grand Palace complex.',
                    'activities' => [
                        'Airport pickup',
                        'Hotel check-in',
                        'Welcome lunch',
                        'Grand Palace tour',
                        'Wat Phra Kaew visit',
                        'Evening at Khao San Road'
                    ],
                    'meals_included' => ['lunch'],
                    'accommodation' => 'Bangkok Palace Hotel',
                    'accommodation_type' => 'hotel',
                    'accommodation_rating' => 4,
                    'location' => 'Bangkok City Center',
                    'start_time' => '10:00:00',
                    'end_time' => '21:00:00',
                    'transportation' => ['Airport taxi', 'Tuk-tuk'],
                    'estimated_distance' => 45.00,
                    'estimated_duration' => 420,
                    'optional_activities' => [
                        'Thai massage (฿800)',
                        'Street food tour (฿1200)'
                    ],
                    'meal_options' => ['Thai cuisine', 'International'],
                    'special_notes' => 'Dress code: covered shoulders and knees for palace visit.',
                    'is_rest_day' => false,
                    'sort_order' => 1
                ],
                [
                    'day_number' => 2,
                    'day_title' => 'Temple Hopping Day',
                    'day_description' => 'Explore Bangkok\'s most famous temples and cultural sites.',
                    'activities' => [
                        'Wat Pho (Reclining Buddha)',
                        'Wat Arun (Temple of Dawn)',
                        'River taxi experience',
                        'Local market visit',
                        'Thai cooking class'
                    ],
                    'meals_included' => ['breakfast'],
                    'accommodation' => 'Bangkok Palace Hotel',
                    'accommodation_type' => 'hotel',
                    'accommodation_rating' => 4,
                    'location' => 'Bangkok Temples',
                    'start_time' => '09:00:00',
                    'end_time' => '18:00:00',
                    'transportation' => ['River taxi', 'Walking', 'Tuk-tuk'],
                    'estimated_distance' => 35.00,
                    'estimated_duration' => 480,
                    'optional_activities' => [
                        'Temple blessing ceremony (฿500)',
                        'Traditional dance show (฿1500)'
                    ],
                    'meal_options' => ['Cooking class meal included', 'Street food'],
                    'special_notes' => 'Comfortable walking shoes recommended. Bring water.',
                    'is_rest_day' => false,
                    'sort_order' => 2
                ],
                [
                    'day_number' => 3,
                    'day_title' => 'Markets & Shopping',
                    'day_description' => 'Experience Bangkok\'s vibrant markets and shopping districts.',
                    'activities' => [
                        'Chatuchak Weekend Market',
                        'MBK Center shopping',
                        'Siam Paragon visit',
                        'Jim Thompson House',
                        'Lumpini Park relaxation'
                    ],
                    'meals_included' => ['breakfast'],
                    'accommodation' => 'Bangkok Palace Hotel',
                    'accommodation_type' => 'hotel',
                    'accommodation_rating' => 4,
                    'location' => 'Bangkok Shopping Areas',
                    'start_time' => '09:00:00',
                    'end_time' => '19:00:00',
                    'transportation' => ['BTS Skytrain', 'Taxi'],
                    'estimated_distance' => 25.00,
                    'estimated_duration' => 420,
                    'optional_activities' => [
                        'Personal shopping assistant (฿2000)',
                        'Silk weaving demonstration (฿800)'
                    ],
                    'meal_options' => ['Food court variety', 'Restaurant meals'],
                    'special_notes' => 'Bargaining expected at markets. Keep valuables safe.',
                    'is_rest_day' => false,
                    'sort_order' => 3
                ],
                [
                    'day_number' => 4,
                    'day_title' => 'Cultural Immersion',
                    'day_description' => 'Deep dive into Thai culture and traditions.',
                    'activities' => [
                        'Vimanmek Mansion visit',
                        'Thai cultural performance',
                        'Traditional handicraft workshop',
                        'Buddhist meditation session',
                        'Farewell dinner cruise'
                    ],
                    'meals_included' => ['breakfast', 'dinner'],
                    'accommodation' => 'Bangkok Palace Hotel',
                    'accommodation_type' => 'hotel',
                    'accommodation_rating' => 4,
                    'location' => 'Bangkok Cultural Sites',
                    'start_time' => '09:00:00',
                    'end_time' => '22:00:00',
                    'transportation' => ['Private van', 'River cruise boat'],
                    'estimated_distance' => 40.00,
                    'estimated_duration' => 480,
                    'optional_activities' => [
                        'Private cultural guide (฿3000)',
                        'Souvenir shopping assistance (฿1000)'
                    ],
                    'meal_options' => ['Cruise buffet dinner', 'Vegetarian options'],
                    'special_notes' => 'Dress respectfully for cultural sites. Camera fees may apply.',
                    'is_rest_day' => false,
                    'sort_order' => 4
                ],
                [
                    'day_number' => 5,
                    'day_title' => 'Departure Day',
                    'day_description' => 'Final shopping and departure from Bangkok.',
                    'activities' => [
                        'Hotel checkout',
                        'Last minute shopping',
                        'Airport transfer',
                        'Flight departure'
                    ],
                    'meals_included' => ['breakfast'],
                    'accommodation' => null,
                    'accommodation_type' => null,
                    'accommodation_rating' => null,
                    'location' => 'Bangkok to Airport',
                    'start_time' => '10:00:00',
                    'end_time' => '15:00:00',
                    'transportation' => ['Airport taxi'],
                    'estimated_distance' => 35.00,
                    'estimated_duration' => 180,
                    'optional_activities' => [
                        'Airport lounge access (฿1200)'
                    ],
                    'meal_options' => ['Airport restaurants', 'In-flight meals'],
                    'special_notes' => 'Check baggage weight limits. Arrive at airport 3 hours early.',
                    'is_rest_day' => false,
                    'sort_order' => 5
                ]
            ];
        }

        foreach ($itineraries as $itineraryData) {
            $itineraryData['tour_id'] = $tour->id;
            TourItinerary::create($itineraryData);
        }
    }

    /**
     * Create tour dates for a tour.
     */
    private function createTourDates(Tour $tour)
    {
        $startDate = Carbon::now()->addDays(15); // Start 15 days from now
        
        // Create 12 tour dates (once per month for a year)
        for ($i = 0; $i < 12; $i++) {
            $tourStartDate = $startDate->copy()->addMonths($i);
            $tourEndDate = $tourStartDate->copy()->addDays($tour->duration_days - 1);
            
            // Vary pricing by season
            $seasonMultiplier = 1.0;
            $isPeakSeason = false;
            
            // Peak season pricing (December-February and June-August)
            if (in_array($tourStartDate->month, [12, 1, 2, 6, 7, 8])) {
                $seasonMultiplier = 1.3;
                $isPeakSeason = true;
            }
            
            $pricePerPerson = $tour->base_price * $seasonMultiplier;
            $childPrice = $tour->child_price ? $tour->child_price * $seasonMultiplier : null;
            
            // Random availability
            $availableSpots = rand(10, $tour->max_group_size);
            $bookedSpots = rand(0, min(5, $availableSpots - 2));
            
            // Determine status based on availability
            $remainingSpots = $availableSpots - $bookedSpots;
            if ($remainingSpots <= 0) {
                $status = 'fully_booked';
            } elseif ($remainingSpots <= 3) {
                $status = 'limited';
            } else {
                $status = 'available';
            }
            
            // Special offers for some dates
            $specialOffers = null;
            if (rand(1, 4) === 1) { // 25% chance of special offer
                $specialOffers = [
                    [
                        'type' => 'percentage',
                        'value' => rand(10, 25),
                        'description' => 'Early bird discount'
                    ]
                ];
            }
            
            TourDate::create([
                'tour_id' => $tour->id,
                'start_date' => $tourStartDate,
                'end_date' => $tourEndDate,
                'price_per_person' => $pricePerPerson,
                'child_price' => $childPrice,
                'single_supplement' => $tour->single_supplement,
                'available_spots' => $availableSpots,
                'booked_spots' => $bookedSpots,
                'min_participants' => $tour->min_group_size,
                'status' => $status,
                'tour_guide' => $this->getRandomGuide(),
                'seasonal_adjustments' => [
                    'season' => $isPeakSeason ? 'peak' : 'regular',
                    'multiplier' => $seasonMultiplier
                ],
                'special_offers' => $specialOffers,
                'special_notes' => $isPeakSeason ? 'Peak season - advance booking recommended' : null,
                'is_peak_season' => $isPeakSeason,
                'is_guaranteed' => $bookedSpots >= $tour->min_group_size,
                'booking_deadline' => $tourStartDate->copy()->subDays(7),
                'cancellation_deadline' => $tourStartDate->copy()->subDays(3),
                'deposit_amount' => $pricePerPerson * 0.3, // 30% deposit
                'deposit_percentage' => 30,
                'weather_info' => $this->getWeatherInfo($tourStartDate->month, $tour->city->name),
                'local_events' => $this->getLocalEvents($tourStartDate->month, $tour->city->name)
            ]);
        }
    }

    /**
     * Get random tour guide name.
     */
    private function getRandomGuide(): string
    {
        $guides = [
            'Rashid Ahmed',
            'Fatima Begum',
            'Karim Rahman',
            'Nasir Uddin',
            'Ruma Khatun',
            'Tariq Hassan',
            'Somchai Prasert',
            'Siriporn Nakamura',
            'Malee Wongsawat'
        ];
        
        return $guides[array_rand($guides)];
    }

    /**
     * Get weather information based on month and location.
     */
    private function getWeatherInfo(int $month, string $city): array
    {
        $weatherData = [
            "Cox's Bazar" => [
                1 => ['temp' => '15-25°C', 'condition' => 'Cool and dry', 'rainfall' => 'Low'],
                2 => ['temp' => '18-28°C', 'condition' => 'Pleasant and dry', 'rainfall' => 'Low'],
                3 => ['temp' => '22-32°C', 'condition' => 'Warm and dry', 'rainfall' => 'Low'],
                4 => ['temp' => '25-35°C', 'condition' => 'Hot and humid', 'rainfall' => 'Moderate'],
                5 => ['temp' => '26-35°C', 'condition' => 'Hot and humid', 'rainfall' => 'High'],
                6 => ['temp' => '25-32°C', 'condition' => 'Monsoon season', 'rainfall' => 'Very High'],
                7 => ['temp' => '25-32°C', 'condition' => 'Monsoon season', 'rainfall' => 'Very High'],
                8 => ['temp' => '25-32°C', 'condition' => 'Monsoon season', 'rainfall' => 'Very High'],
                9 => ['temp' => '24-31°C', 'condition' => 'Post-monsoon', 'rainfall' => 'High'],
                10 => ['temp' => '22-30°C', 'condition' => 'Pleasant', 'rainfall' => 'Moderate'],
                11 => ['temp' => '18-28°C', 'condition' => 'Cool and pleasant', 'rainfall' => 'Low'],
                12 => ['temp' => '15-25°C', 'condition' => 'Cool and dry', 'rainfall' => 'Low']
            ],
            'Sylhet' => [
                1 => ['temp' => '10-20°C', 'condition' => 'Cool and misty', 'rainfall' => 'Low'],
                2 => ['temp' => '15-25°C', 'condition' => 'Pleasant', 'rainfall' => 'Low'],
                3 => ['temp' => '20-30°C', 'condition' => 'Warm', 'rainfall' => 'Moderate'],
                4 => ['temp' => '22-32°C', 'condition' => 'Hot and humid', 'rainfall' => 'High'],
                5 => ['temp' => '24-33°C', 'condition' => 'Pre-monsoon', 'rainfall' => 'High'],
                6 => ['temp' => '24-30°C', 'condition' => 'Monsoon', 'rainfall' => 'Very High'],
                7 => ['temp' => '24-30°C', 'condition' => 'Heavy monsoon', 'rainfall' => 'Very High'],
                8 => ['temp' => '24-30°C', 'condition' => 'Monsoon', 'rainfall' => 'Very High'],
                9 => ['temp' => '23-29°C', 'condition' => 'Post-monsoon', 'rainfall' => 'High'],
                10 => ['temp' => '20-28°C', 'condition' => 'Pleasant', 'rainfall' => 'Moderate'],
                11 => ['temp' => '15-25°C', 'condition' => 'Cool and clear', 'rainfall' => 'Low'],
                12 => ['temp' => '10-20°C', 'condition' => 'Cool and misty', 'rainfall' => 'Low']
            ],
            'Bangkok' => [
                1 => ['temp' => '20-32°C', 'condition' => 'Cool and dry', 'rainfall' => 'Low'],
                2 => ['temp' => '23-34°C', 'condition' => 'Warm and dry', 'rainfall' => 'Low'],
                3 => ['temp' => '25-36°C', 'condition' => 'Hot and dry', 'rainfall' => 'Low'],
                4 => ['temp' => '27-38°C', 'condition' => 'Very hot', 'rainfall' => 'Moderate'],
                5 => ['temp' => '26-36°C', 'condition' => 'Hot and humid', 'rainfall' => 'High'],
                6 => ['temp' => '25-34°C', 'condition' => 'Rainy season', 'rainfall' => 'Very High'],
                7 => ['temp' => '25-33°C', 'condition' => 'Rainy season', 'rainfall' => 'Very High'],
                8 => ['temp' => '25-33°C', 'condition' => 'Rainy season', 'rainfall' => 'Very High'],
                9 => ['temp' => '25-33°C', 'condition' => 'Rainy season', 'rainfall' => 'High'],
                10 => ['temp' => '24-32°C', 'condition' => 'Post-rain', 'rainfall' => 'Moderate'],
                11 => ['temp' => '22-31°C', 'condition' => 'Cool and pleasant', 'rainfall' => 'Low'],
                12 => ['temp' => '20-30°C', 'condition' => 'Cool and dry', 'rainfall' => 'Low']
            ]
        ];
        
        return $weatherData[$city][$month] ?? ['temp' => 'N/A', 'condition' => 'Variable', 'rainfall' => 'Moderate'];
    }

    /**
     * Get local events based on month and location.
     */
    private function getLocalEvents(int $month, string $city): array
    {
        $events = [
            "Cox's Bazar" => [
                2 => ['Pahela Falgun (Spring Festival)', 'Beach volleyball tournament'],
                4 => ['Pohela Boishakh (Bengali New Year)', 'Traditional boat race'],
                11 => ['Cox\'s Bazar Beach Festival', 'International kite festival'],
                12 => ['Winter tourism season opening', 'Beach concert series']
            ],
            'Sylhet' => [
                3 => ['Tea harvest season begins', 'Cultural programs in tea gardens'],
                4 => ['Pohela Boishakh celebrations', 'Traditional music festivals'],
                7 => ['Monsoon season tea tours', 'Rain festival celebrations'],
                11 => ['Orange harvest festival', 'Folk music competitions']
            ],
            'Bangkok' => [
                2 => ['Chinese New Year celebrations', 'Flower markets festival'],
                4 => ['Songkran (Thai New Year)', 'Water festival citywide'],
                11 => ['Loy Krathong festival', 'River lantern ceremonies'],
                12 => ['King\'s Birthday celebrations', 'Royal ceremonies and parades']
            ]
        ];
        
        return $events[$city][$month] ?? [];
    }
}