<?php

namespace Modules\Hotel\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Hotel\Models\Hotel;
use Modules\Hotel\Models\HotelRoom;
use Modules\Hotel\Models\RoomInventory;
use Modules\Location\Models\Country;
use Modules\Location\Models\City;
use Carbon\Carbon;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            HotelDataSeeder::class,
            HotelRoomSeeder::class,
            RoomInventorySeeder::class,
        ]);
    }
}

class HotelDataSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
            // Bangladesh Hotels
            [
                'country_code' => 'BD',
                'city_name' => 'Dhaka',
                'name' => 'Pan Pacific Sonargaon Dhaka',
                'description' => 'Luxury 5-star hotel in the heart of Dhaka with world-class amenities and service.',
                'address' => '107 Kazi Nazrul Islam Avenue, Karwan Bazar',
                'latitude' => 23.7516,
                'longitude' => 90.3916,
                'phone' => '+880-2-8158001',
                'email' => 'info@panpacific.com',
                'website' => 'https://www.panpacific.com',
                'star_rating' => 5,
                'amenities' => ['wifi', 'pool', 'gym', 'spa', 'restaurant', 'bar', 'parking', 'airport_shuttle', 'room_service', 'concierge'],
                'checkin_time' => '14:00',
                'checkout_time' => '12:00',
                'is_active' => true,
                'is_featured' => true,
                'average_rating' => 4.5,
                'total_reviews' => 1250,
                'distance_from_airport' => 12.5,
                'distance_from_city_center' => 2.0,
                'position' => 1,
            ],
            [
                'country_code' => 'BD',
                'city_name' => 'Dhaka',
                'name' => 'The Westin Dhaka',
                'description' => 'Modern luxury hotel offering sophisticated accommodations and exceptional dining.',
                'address' => 'Main Gulshan Avenue, Gulshan-2',
                'latitude' => 23.7925,
                'longitude' => 90.4077,
                'phone' => '+880-2-48810088',
                'email' => 'reservations@westin-dhaka.com',
                'website' => 'https://www.marriott.com',
                'star_rating' => 5,
                'amenities' => ['wifi', 'pool', 'gym', 'spa', 'restaurant', 'bar', 'parking', 'business_center', 'conference_room'],
                'checkin_time' => '15:00',
                'checkout_time' => '12:00',
                'is_active' => true,
                'is_featured' => true,
                'average_rating' => 4.3,
                'total_reviews' => 890,
                'distance_from_airport' => 8.2,
                'distance_from_city_center' => 5.5,
                'position' => 2,
            ],
            [
                'country_code' => 'BD',
                'city_name' => 'Cox\'s Bazar',
                'name' => 'Hotel Sea Crown',
                'description' => 'Beachfront resort with stunning sea views and modern amenities.',
                'address' => 'Hotel Motel Zone, Kolatoli Road',
                'latitude' => 21.4272,
                'longitude' => 92.0058,
                'phone' => '+880-341-64500',
                'email' => 'info@seacrown.com',
                'website' => 'https://www.seacrown.com',
                'star_rating' => 4,
                'amenities' => ['wifi', 'pool', 'restaurant', 'bar', 'parking', 'air_conditioning'],
                'checkin_time' => '14:00',
                'checkout_time' => '11:00',
                'is_active' => true,
                'is_featured' => false,
                'average_rating' => 4.1,
                'total_reviews' => 456,
                'distance_from_airport' => 2.5,
                'distance_from_city_center' => 1.0,
                'position' => 3,
            ],

            // Dubai Hotels
            [
                'country_code' => 'AE',
                'city_name' => 'Dubai',
                'name' => 'Burj Al Arab Jumeirah',
                'description' => 'The world\'s most luxurious hotel with unparalleled service and opulent suites.',
                'address' => 'Jumeirah Beach Road, Umm Suqeim 3',
                'latitude' => 25.1413,
                'longitude' => 55.1853,
                'phone' => '+971-4-3017777',
                'email' => 'baainfo@jumeirah.com',
                'website' => 'https://www.jumeirah.com',
                'star_rating' => 5,
                'amenities' => ['wifi', 'pool', 'gym', 'spa', 'restaurant', 'bar', 'parking', 'airport_shuttle', 'room_service', 'concierge', 'business_center'],
                'checkin_time' => '15:00',
                'checkout_time' => '12:00',
                'is_active' => true,
                'is_featured' => true,
                'average_rating' => 4.8,
                'total_reviews' => 3250,
                'distance_from_airport' => 25.0,
                'distance_from_city_center' => 15.0,
                'position' => 1,
            ],

            // Bangkok Hotels
            [
                'country_code' => 'TH',
                'city_name' => 'Bangkok',
                'name' => 'The Oriental Bangkok',
                'description' => 'Historic luxury hotel on the Chao Phraya River, a legend of hospitality.',
                'address' => '48 Oriental Avenue, Bangrak',
                'latitude' => 13.7245,
                'longitude' => 100.5156,
                'phone' => '+66-2-6599000',
                'email' => 'mobkk-reservations@mohg.com',
                'website' => 'https://www.mandarinoriental.com',
                'star_rating' => 5,
                'amenities' => ['wifi', 'pool', 'gym', 'spa', 'restaurant', 'bar', 'parking', 'airport_shuttle', 'room_service', 'concierge'],
                'checkin_time' => '14:00',
                'checkout_time' => '12:00',
                'is_active' => true,
                'is_featured' => true,
                'average_rating' => 4.6,
                'total_reviews' => 2100,
                'distance_from_airport' => 32.0,
                'distance_from_city_center' => 2.5,
                'position' => 1,
            ],

            // London Hotels
            [
                'country_code' => 'GB',
                'city_name' => 'London',
                'name' => 'The Savoy',
                'description' => 'Iconic luxury hotel in the heart of London with timeless elegance.',
                'address' => 'Strand, Covent Garden',
                'latitude' => 51.5106,
                'longitude' => -0.1208,
                'phone' => '+44-20-78368343',
                'email' => 'info@the-savoy.co.uk',
                'website' => 'https://www.fairmont.com/savoy-london',
                'star_rating' => 5,
                'amenities' => ['wifi', 'gym', 'spa', 'restaurant', 'bar', 'room_service', 'concierge', 'business_center'],
                'checkin_time' => '15:00',
                'checkout_time' => '12:00',
                'is_active' => true,
                'is_featured' => true,
                'average_rating' => 4.4,
                'total_reviews' => 1850,
                'distance_from_airport' => 45.0,
                'distance_from_city_center' => 1.0,
                'position' => 1,
            ],
        ];

        foreach ($hotels as $hotelData) {
            $country = Country::where('code', $hotelData['country_code'])->first();
            $city = City::where('name', $hotelData['city_name'])
                       ->where('country_id', $country->id ?? null)
                       ->first();
            
            if ($country && $city) {
                $hotelData['country_id'] = $country->id;
                $hotelData['city_id'] = $city->id;
                unset($hotelData['country_code'], $hotelData['city_name']);
                
                Hotel::create($hotelData);
            }
        }
    }
}

class HotelRoomSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {
            // Create different room types for each hotel
            $roomTypes = [
                [
                    'room_type' => 'standard',
                    'name' => 'Standard Room',
                    'description' => 'Comfortable standard room with essential amenities.',
                    'max_occupancy' => 2,
                    'max_adults' => 2,
                    'max_children' => 1,
                    'room_size' => 25.0,
                    'bed_type' => 'queen',
                    'bed_count' => 1,
                    'amenities' => ['ac', 'tv', 'wifi', 'safe', 'shower', 'hairdryer'],
                    'base_price' => $hotel->star_rating * 3000,
                    'total_rooms' => 20,
                    'position' => 1,
                ],
                [
                    'room_type' => 'deluxe',
                    'name' => 'Deluxe Room',
                    'description' => 'Spacious deluxe room with city or sea view.',
                    'max_occupancy' => 3,
                    'max_adults' => 2,
                    'max_children' => 2,
                    'room_size' => 35.0,
                    'bed_type' => 'king',
                    'bed_count' => 1,
                    'amenities' => ['ac', 'tv', 'wifi', 'minibar', 'safe', 'balcony', 'city_view', 'bathtub', 'coffee_maker'],
                    'base_price' => $hotel->star_rating * 4500,
                    'total_rooms' => 15,
                    'position' => 2,
                ],
                [
                    'room_type' => 'suite',
                    'name' => 'Executive Suite',
                    'description' => 'Luxurious suite with separate living area and premium amenities.',
                    'max_occupancy' => 4,
                    'max_adults' => 2,
                    'max_children' => 2,
                    'room_size' => 60.0,
                    'bed_type' => 'king',
                    'bed_count' => 1,
                    'amenities' => ['ac', 'tv', 'wifi', 'minibar', 'safe', 'balcony', 'sea_view', 'bathtub', 'coffee_maker', 'desk', 'sofa'],
                    'base_price' => $hotel->star_rating * 8000,
                    'total_rooms' => 5,
                    'position' => 3,
                ],
            ];

            foreach ($roomTypes as $roomData) {
                $roomData['hotel_id'] = $hotel->id;
                HotelRoom::create($roomData);
            }
        }
    }
}

class RoomInventorySeeder extends Seeder
{
    public function run(): void
    {
        $rooms = HotelRoom::all();

        foreach ($rooms as $room) {
            // Create inventory for next 90 days
            for ($i = 0; $i < 90; $i++) {
                $date = Carbon::now()->addDays($i);
                
                // Price variations based on day of week and season
                $priceMultiplier = 1.0;
                
                // Weekend pricing
                if ($date->isWeekend()) {
                    $priceMultiplier *= 1.3;
                }
                
                // Random seasonal variations
                $priceMultiplier *= rand(80, 120) / 100;
                
                $price = $room->base_price * $priceMultiplier;
                $discountPercentage = rand(1, 100) <= 20 ? rand(5, 25) : 0; // 20% chance of discount
                $finalPrice = $price * (1 - $discountPercentage / 100);
                
                // Random availability (85-95% available)
                $availableRooms = round($room->total_rooms * (rand(85, 95) / 100));
                $bookedRooms = $room->total_rooms - $availableRooms;
                
                RoomInventory::create([
                    'hotel_room_id' => $room->id,
                    'date' => $date->toDateString(),
                    'total_rooms' => $room->total_rooms,
                    'available_rooms' => $availableRooms,
                    'booked_rooms' => $bookedRooms,
                    'blocked_rooms' => 0,
                    'price' => $price,
                    'discount_percentage' => $discountPercentage,
                    'final_price' => $finalPrice,
                    'is_available' => true,
                    'rate_plan' => ['room_only', 'standard', 'breakfast_included', 'half_board', 'full_board', 'all_inclusive'][array_rand(['room_only', 'standard', 'breakfast_included', 'half_board', 'full_board', 'all_inclusive'])],
                    'inclusions' => $i % 3 === 0 ? ['breakfast', 'wifi'] : ['wifi'],
                    'minimum_stay' => 1,
                    'maximum_stay' => null,
                    'stop_sell' => false,
                    'notes' => null,
                ]);
            }
        }
    }
}