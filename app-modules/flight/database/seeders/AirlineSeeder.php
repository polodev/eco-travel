<?php

namespace Modules\Flight\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Flight\Models\Airline;
use Modules\Location\Models\Country;

class AirlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airlines = [
            // Bangladesh Airlines
            [
                'country_code' => 'BD',
                'name' => 'Biman Bangladesh Airlines',
                'code' => 'BG',
                'icao_code' => 'BBC',
                'logo_url' => 'https://www.biman-airlines.com/assets/img/logo.png',
                'website' => 'https://www.biman-airlines.com',
                'headquarters' => 'Dhaka, Bangladesh',
                'founded' => 1972,
                'alliance' => 'none',
                'is_active' => true,
                'is_low_cost' => false,
                'position' => 1,
            ],
            [
                'country_code' => 'BD',
                'name' => 'US-Bangla Airlines',
                'code' => 'BS',
                'icao_code' => 'UBG',
                'logo_url' => null,
                'website' => 'https://www.us-banglaairlines.com',
                'headquarters' => 'Dhaka, Bangladesh',
                'founded' => 2014,
                'alliance' => 'none',
                'is_active' => true,
                'is_low_cost' => true,
                'position' => 2,
            ],
            [
                'country_code' => 'BD',
                'name' => 'Novoair',
                'code' => 'VQ',
                'icao_code' => 'NVQ',
                'logo_url' => null,
                'website' => 'https://www.flynovoair.com',
                'headquarters' => 'Dhaka, Bangladesh',
                'founded' => 2013,
                'alliance' => 'none',
                'is_active' => true,
                'is_low_cost' => true,
                'position' => 3,
            ],

            // Indian Airlines
            [
                'country_code' => 'IN',
                'name' => 'Air India',
                'code' => 'AI',
                'icao_code' => 'AIC',
                'logo_url' => null,
                'website' => 'https://www.airindia.in',
                'headquarters' => 'New Delhi, India',
                'founded' => 1932,
                'alliance' => 'star_alliance',
                'is_active' => true,
                'is_low_cost' => false,
                'position' => 4,
            ],
            [
                'country_code' => 'IN',
                'name' => 'IndiGo',
                'code' => '6E',
                'icao_code' => 'IGO',
                'logo_url' => null,
                'website' => 'https://www.goindigo.in',
                'headquarters' => 'Gurgaon, India',
                'founded' => 2006,
                'alliance' => 'none',
                'is_active' => true,
                'is_low_cost' => true,
                'position' => 5,
            ],

            // US Airlines
            [
                'country_code' => 'US',
                'name' => 'American Airlines',
                'code' => 'AA',
                'icao_code' => 'AAL',
                'logo_url' => null,
                'website' => 'https://www.aa.com',
                'headquarters' => 'Fort Worth, Texas, USA',
                'founded' => 1930,
                'alliance' => 'oneworld',
                'is_active' => true,
                'is_low_cost' => false,
                'position' => 6,
            ],
            [
                'country_code' => 'US',
                'name' => 'Delta Air Lines',
                'code' => 'DL',
                'icao_code' => 'DAL',
                'logo_url' => null,
                'website' => 'https://www.delta.com',
                'headquarters' => 'Atlanta, Georgia, USA',
                'founded' => 1924,
                'alliance' => 'skyteam',
                'is_active' => true,
                'is_low_cost' => false,
                'position' => 7,
            ],

            // UK Airlines
            [
                'country_code' => 'GB',
                'name' => 'British Airways',
                'code' => 'BA',
                'icao_code' => 'BAW',
                'logo_url' => null,
                'website' => 'https://www.britishairways.com',
                'headquarters' => 'London, UK',
                'founded' => 1974,
                'alliance' => 'oneworld',
                'is_active' => true,
                'is_low_cost' => false,
                'position' => 8,
            ],

            // Thai Airlines
            [
                'country_code' => 'TH',
                'name' => 'Thai Airways',
                'code' => 'TG',
                'icao_code' => 'THA',
                'logo_url' => null,
                'website' => 'https://www.thaiairways.com',
                'headquarters' => 'Bangkok, Thailand',
                'founded' => 1960,
                'alliance' => 'star_alliance',
                'is_active' => true,
                'is_low_cost' => false,
                'position' => 9,
            ],

            // UAE Airlines
            [
                'country_code' => 'AE',
                'name' => 'Emirates',
                'code' => 'EK',
                'icao_code' => 'UAE',
                'logo_url' => null,
                'website' => 'https://www.emirates.com',
                'headquarters' => 'Dubai, UAE',
                'founded' => 1985,
                'alliance' => 'none',
                'is_active' => true,
                'is_low_cost' => false,
                'position' => 10,
            ],
        ];

        foreach ($airlines as $airlineData) {
            $country = Country::where('code', $airlineData['country_code'])->first();
            
            if ($country) {
                $airlineData['country_id'] = $country->id;
                $airlineData['operating_countries'] = [$country->id]; // Default to home country
                unset($airlineData['country_code']);
                
                Airline::create($airlineData);
            }
        }
    }
}