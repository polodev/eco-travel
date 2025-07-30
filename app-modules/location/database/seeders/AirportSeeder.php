<?php

namespace Modules\Location\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Location\Models\Country;
use Modules\Location\Models\City;
use Modules\Location\Models\Airport;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airports = [
            // Bangladesh Airports
            [
                'country_code' => 'BD',
                'city_name' => 'Dhaka',
                'name' => 'Hazrat Shahjalal International Airport',
                'iata_code' => 'DAC',
                'icao_code' => 'VGHS',
                'latitude' => 23.8433,
                'longitude' => 90.3978,
                'timezone' => 'Asia/Dhaka',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => true,
                'position' => 1,
            ],
            [
                'country_code' => 'BD',
                'city_name' => 'Chittagong',
                'name' => 'Shah Amanat International Airport',
                'iata_code' => 'CGP',
                'icao_code' => 'VGEG',
                'latitude' => 22.2496,
                'longitude' => 91.8133,
                'timezone' => 'Asia/Dhaka',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => false,
                'position' => 2,
            ],
            [
                'country_code' => 'BD',
                'city_name' => 'Cox\'s Bazar',
                'name' => 'Cox\'s Bazar Airport',
                'iata_code' => 'CXB',
                'icao_code' => 'VGCB',
                'latitude' => 21.4522,
                'longitude' => 91.9636,
                'timezone' => 'Asia/Dhaka',
                'type' => 'domestic',
                'is_active' => true,
                'is_hub' => false,
                'position' => 3,
            ],
            [
                'country_code' => 'BD',
                'city_name' => 'Sylhet',
                'name' => 'Osmani International Airport',
                'iata_code' => 'ZYL',
                'icao_code' => 'VGSY',
                'latitude' => 24.9633,
                'longitude' => 91.8739,
                'timezone' => 'Asia/Dhaka',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => false,
                'position' => 4,
            ],

            // India Airports
            [
                'country_code' => 'IN',
                'city_name' => 'New Delhi',
                'name' => 'Indira Gandhi International Airport',
                'iata_code' => 'DEL',
                'icao_code' => 'VIDP',
                'latitude' => 28.5665,
                'longitude' => 77.1031,
                'timezone' => 'Asia/Kolkata',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => true,
                'position' => 1,
            ],
            [
                'country_code' => 'IN',
                'city_name' => 'Mumbai',
                'name' => 'Chhatrapati Shivaji Maharaj International Airport',
                'iata_code' => 'BOM',
                'icao_code' => 'VABB',
                'latitude' => 19.0896,
                'longitude' => 72.8656,
                'timezone' => 'Asia/Kolkata',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => true,
                'position' => 2,
            ],
            [
                'country_code' => 'IN',
                'city_name' => 'Kolkata',
                'name' => 'Netaji Subhash Chandra Bose International Airport',
                'iata_code' => 'CCU',
                'icao_code' => 'VECC',
                'latitude' => 22.6546,
                'longitude' => 88.4467,
                'timezone' => 'Asia/Kolkata',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => false,
                'position' => 3,
            ],

            // USA Airports
            [
                'country_code' => 'US',
                'city_name' => 'New York',
                'name' => 'John F. Kennedy International Airport',
                'iata_code' => 'JFK',
                'icao_code' => 'KJFK',
                'latitude' => 40.6413,
                'longitude' => -73.7781,
                'timezone' => 'America/New_York',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => true,
                'position' => 1,
            ],
            [
                'country_code' => 'US',
                'city_name' => 'Los Angeles',
                'name' => 'Los Angeles International Airport',
                'iata_code' => 'LAX',
                'icao_code' => 'KLAX',
                'latitude' => 33.9425,
                'longitude' => -118.4081,
                'timezone' => 'America/Los_Angeles',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => true,
                'position' => 2,
            ],

            // UK Airports
            [
                'country_code' => 'GB',
                'city_name' => 'London',
                'name' => 'Heathrow Airport',
                'iata_code' => 'LHR',
                'icao_code' => 'EGLL',
                'latitude' => 51.4700,
                'longitude' => -0.4543,
                'timezone' => 'Europe/London',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => true,
                'position' => 1,
            ],
            [
                'country_code' => 'GB',
                'city_name' => 'London',
                'name' => 'Gatwick Airport',
                'iata_code' => 'LGW',
                'icao_code' => 'EGKK',
                'latitude' => 51.1537,
                'longitude' => -0.1821,
                'timezone' => 'Europe/London',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => false,
                'position' => 2,
            ],
            [
                'country_code' => 'GB',
                'city_name' => 'Manchester',
                'name' => 'Manchester Airport',
                'iata_code' => 'MAN',
                'icao_code' => 'EGCC',
                'latitude' => 53.3537,
                'longitude' => -2.2750,
                'timezone' => 'Europe/London',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => false,
                'position' => 3,
            ],

            // Thailand Airports
            [
                'country_code' => 'TH',
                'city_name' => 'Bangkok',
                'name' => 'Suvarnabhumi Airport',
                'iata_code' => 'BKK',
                'icao_code' => 'VTBS',
                'latitude' => 13.6900,
                'longitude' => 100.7501,
                'timezone' => 'Asia/Bangkok',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => true,
                'position' => 1,
            ],
            [
                'country_code' => 'TH',
                'city_name' => 'Phuket',
                'name' => 'Phuket International Airport',
                'iata_code' => 'HKT',
                'icao_code' => 'VTSP',
                'latitude' => 8.1132,
                'longitude' => 98.3169,
                'timezone' => 'Asia/Bangkok',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => false,
                'position' => 2,
            ],

            // UAE Airports
            [
                'country_code' => 'AE',
                'city_name' => 'Dubai',
                'name' => 'Dubai International Airport',
                'iata_code' => 'DXB',
                'icao_code' => 'OMDB',
                'latitude' => 25.2532,
                'longitude' => 55.3657,
                'timezone' => 'Asia/Dubai',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => true,
                'position' => 1,
            ],
            [
                'country_code' => 'AE',
                'city_name' => 'Abu Dhabi',
                'name' => 'Abu Dhabi International Airport',
                'iata_code' => 'AUH',
                'icao_code' => 'OMAA',
                'latitude' => 24.4330,
                'longitude' => 54.6511,
                'timezone' => 'Asia/Dubai',
                'type' => 'international',
                'is_active' => true,
                'is_hub' => true,
                'position' => 2,
            ],
        ];

        foreach ($airports as $airportData) {
            $country = Country::where('code', $airportData['country_code'])->first();
            $city = City::where('name', $airportData['city_name'])
                       ->where('country_id', $country->id ?? null)
                       ->first();
            
            if ($country && $city) {
                $airportData['country_id'] = $country->id;
                $airportData['city_id'] = $city->id;
                unset($airportData['country_code'], $airportData['city_name']);
                
                Airport::create($airportData);
            }
        }
    }
}