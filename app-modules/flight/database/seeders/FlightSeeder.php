<?php

namespace Modules\Flight\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\Airline;
use Modules\Location\Models\Airport;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get airports by IATA codes for easy reference
        $airports = Airport::whereIn('iata_code', [
            'DAC', 'CGP', 'CXB', 'ZYL', // Bangladesh
            'DEL', 'BOM', 'CCU', // India
            'JFK', 'LAX', // USA
            'LHR', 'LGW', 'MAN', // UK
            'BKK', 'HKT', // Thailand
            'DXB', 'AUH' // UAE
        ])->get()->keyBy('iata_code');

        // Get airlines by code for easy reference
        $airlines = Airline::whereIn('code', ['BG', 'BS', 'VQ', 'AI', '6E', 'AA', 'DL', 'BA', 'TG', 'EK'])
                          ->get()->keyBy('code');

        $flights = [
            // Biman Bangladesh Airlines Flights
            [
                'airline_code' => 'BG',
                'flight_number' => '147',
                'departure_airport' => 'DAC',
                'arrival_airport' => 'CGP',
                'departure_time' => '08:00',
                'arrival_time' => '09:15',
                'duration_minutes' => 75,
                'aircraft_type' => 'dash_8',
                'operating_days' => ['monday', 'wednesday', 'friday', 'sunday'],
                'flight_type' => 'domestic',
                'is_active' => true,
                'has_meal' => true,
                'has_wifi' => false,
                'has_entertainment' => false,
                'baggage_allowance' => ['cabin' => '7kg', 'checked' => '20kg'],
                'base_price' => 4500.00,
                'total_seats' => 78,
                'economy_seats' => 78,
                'business_seats' => 0,
                'first_seats' => 0,
                'position' => 1,
            ],
            [
                'airline_code' => 'BG',
                'flight_number' => '148',
                'departure_airport' => 'CGP',
                'arrival_airport' => 'DAC',
                'departure_time' => '10:30',
                'arrival_time' => '11:45',
                'duration_minutes' => 75,
                'aircraft_type' => 'dash_8',
                'operating_days' => ['monday', 'wednesday', 'friday', 'sunday'],
                'flight_type' => 'domestic',
                'is_active' => true,
                'has_meal' => true,
                'has_wifi' => false,
                'has_entertainment' => false,
                'baggage_allowance' => ['cabin' => '7kg', 'checked' => '20kg'],
                'base_price' => 4500.00,
                'total_seats' => 78,
                'economy_seats' => 78,
                'business_seats' => 0,
                'first_seats' => 0,
                'position' => 2,
            ],
            [
                'airline_code' => 'BG',
                'flight_number' => '084',
                'departure_airport' => 'DAC',
                'arrival_airport' => 'DEL',
                'departure_time' => '11:45',
                'arrival_time' => '13:30',
                'duration_minutes' => 165,
                'aircraft_type' => 'boeing_737',
                'operating_days' => ['tuesday', 'thursday', 'saturday'],
                'flight_type' => 'international',
                'is_active' => true,
                'has_meal' => true,
                'has_wifi' => true,
                'has_entertainment' => true,
                'baggage_allowance' => ['cabin' => '7kg', 'checked' => '30kg'],
                'base_price' => 25000.00,
                'total_seats' => 150,
                'economy_seats' => 120,
                'business_seats' => 30,
                'first_seats' => 0,
                'position' => 3,
            ],

            // US-Bangla Airlines Flights
            [
                'airline_code' => 'BS',
                'flight_number' => '211',
                'departure_airport' => 'DAC',
                'arrival_airport' => 'CXB',
                'departure_time' => '07:30',
                'arrival_time' => '08:45',
                'duration_minutes' => 75,
                'aircraft_type' => 'atr_72',
                'operating_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
                'flight_type' => 'domestic',
                'is_active' => true,
                'has_meal' => false,
                'has_wifi' => false,
                'has_entertainment' => false,
                'baggage_allowance' => ['cabin' => '7kg', 'checked' => '20kg'],
                'base_price' => 6500.00,
                'total_seats' => 72,
                'economy_seats' => 72,
                'business_seats' => 0,
                'first_seats' => 0,
                'position' => 4,
            ],

            // IndiGo Flights
            [
                'airline_code' => '6E',
                'flight_number' => '2501',
                'departure_airport' => 'DEL',
                'arrival_airport' => 'BOM',
                'departure_time' => '06:00',
                'arrival_time' => '08:30',
                'duration_minutes' => 150,
                'aircraft_type' => 'airbus_a320',
                'operating_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
                'flight_type' => 'domestic',
                'is_active' => true,
                'has_meal' => false,
                'has_wifi' => true,
                'has_entertainment' => false,
                'baggage_allowance' => ['cabin' => '7kg', 'checked' => '15kg'],
                'base_price' => 8500.00,
                'total_seats' => 180,
                'economy_seats' => 180,
                'business_seats' => 0,
                'first_seats' => 0,
                'position' => 5,
            ],

            // Emirates Flights
            [
                'airline_code' => 'EK',
                'flight_number' => '582',
                'departure_airport' => 'DXB',
                'arrival_airport' => 'DAC',
                'departure_time' => '03:30',
                'arrival_time' => '09:15',
                'duration_minutes' => 285,
                'aircraft_type' => 'boeing_777',
                'operating_days' => ['monday', 'wednesday', 'friday', 'sunday'],
                'flight_type' => 'international',
                'is_active' => true,
                'has_meal' => true,
                'has_wifi' => true,
                'has_entertainment' => true,
                'baggage_allowance' => ['cabin' => '7kg', 'checked' => '30kg'],
                'base_price' => 45000.00,
                'total_seats' => 354,
                'economy_seats' => 304,
                'business_seats' => 42,
                'first_seats' => 8,
                'position' => 6,
            ],

            // British Airways Flights
            [
                'airline_code' => 'BA',
                'flight_number' => '127',
                'departure_airport' => 'LHR',
                'arrival_airport' => 'JFK',
                'departure_time' => '11:25',
                'arrival_time' => '14:55',
                'duration_minutes' => 510,
                'aircraft_type' => 'boeing_777',
                'operating_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
                'flight_type' => 'international',
                'is_active' => true,
                'has_meal' => true,
                'has_wifi' => true,
                'has_entertainment' => true,
                'baggage_allowance' => ['cabin' => '10kg', 'checked' => '23kg'],
                'base_price' => 85000.00,
                'total_seats' => 275,
                'economy_seats' => 199,
                'business_seats' => 56,
                'first_seats' => 14,
                'position' => 7,
            ],

            // Thai Airways Flights
            [
                'airline_code' => 'TG',
                'flight_number' => '322',
                'departure_airport' => 'BKK',
                'arrival_airport' => 'DAC',
                'departure_time' => '23:55',
                'arrival_time' => '01:20',
                'duration_minutes' => 85,
                'aircraft_type' => 'airbus_a330',
                'operating_days' => ['tuesday', 'thursday', 'saturday'],
                'flight_type' => 'international',
                'is_active' => true,
                'has_meal' => true,
                'has_wifi' => true,
                'has_entertainment' => true,
                'baggage_allowance' => ['cabin' => '7kg', 'checked' => '30kg'],
                'base_price' => 32000.00,
                'total_seats' => 277,
                'economy_seats' => 249,
                'business_seats' => 28,
                'first_seats' => 0,
                'position' => 8,
            ],
        ];

        foreach ($flights as $flightData) {
            $airline = $airlines->get($flightData['airline_code']);
            $departureAirport = $airports->get($flightData['departure_airport']);
            $arrivalAirport = $airports->get($flightData['arrival_airport']);
            
            if ($airline && $departureAirport && $arrivalAirport) {
                $flightData['airline_id'] = $airline->id;
                $flightData['departure_airport_id'] = $departureAirport->id;
                $flightData['arrival_airport_id'] = $arrivalAirport->id;
                
                unset($flightData['airline_code'], $flightData['departure_airport'], $flightData['arrival_airport']);
                
                Flight::create($flightData);
            }
        }
    }
}