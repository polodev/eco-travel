<?php

namespace Modules\Flight\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Flight\Models\FlightSchedule;
use Modules\Flight\Models\Flight;
use Carbon\Carbon;

class FlightScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flights = Flight::with(['airline', 'departureAirport', 'arrivalAirport'])->get();

        foreach ($flights as $flight) {
            // Create schedules for the next 30 days
            for ($i = 0; $i < 30; $i++) {
                $date = Carbon::now()->addDays($i);
                $dayName = strtolower($date->format('l'));
                
                // Only create schedule if flight operates on this day
                if (in_array($dayName, $flight->operating_days)) {
                    $departureDateTime = $date->copy()->setTimeFromTimeString($flight->departure_time->format('H:i:s'));
                    $arrivalDateTime = $date->copy()->setTimeFromTimeString($flight->arrival_time->format('H:i:s'));
                    
                    // Handle overnight flights
                    if ($arrivalDateTime->lt($departureDateTime)) {
                        $arrivalDateTime->addDay();
                    }

                    // Random pricing variations (±20% from base price)
                    $priceMultiplier = rand(80, 120) / 100;
                    $economyPrice = $flight->base_price ? $flight->base_price * $priceMultiplier : null;
                    $businessPrice = $economyPrice ? $economyPrice * 2.5 : null;
                    $firstPrice = $economyPrice ? $economyPrice * 4 : null;

                    // Random seat availability (70-95% available)
                    $economyAvailable = round($flight->economy_seats * (rand(70, 95) / 100));
                    $businessAvailable = round($flight->business_seats * (rand(70, 95) / 100));
                    $firstAvailable = round($flight->first_seats * (rand(70, 95) / 100));

                    // Random status (mostly scheduled)
                    $status = 'scheduled';
                    $delayMinutes = 0;
                    
                    if (rand(1, 100) <= 10) { // 10% chance of delay
                        $status = 'delayed';
                        $delayMinutes = rand(15, 120);
                    } elseif (rand(1, 100) <= 2) { // 2% chance of cancellation
                        $status = 'cancelled';
                    }

                    // Random gates and terminals
                    $gates = ['A1', 'A2', 'A3', 'B1', 'B2', 'B3', 'C1', 'C2'];
                    $terminals = ['1', '2', '3'];

                    FlightSchedule::create([
                        'flight_id' => $flight->id,
                        'flight_date' => $date->toDateString(),
                        'scheduled_departure' => $departureDateTime,
                        'scheduled_arrival' => $arrivalDateTime,
                        'actual_departure' => null,
                        'actual_arrival' => null,
                        'status' => $status,
                        'delay_minutes' => $delayMinutes,
                        'gate' => $gates[array_rand($gates)],
                        'terminal' => $terminals[array_rand($terminals)],
                        'economy_price' => $economyPrice,
                        'business_price' => $businessPrice,
                        'first_price' => $firstPrice,
                        'available_economy_seats' => $economyAvailable,
                        'available_business_seats' => $businessAvailable,
                        'available_first_seats' => $firstAvailable,
                        'booked_seats' => ($flight->total_seats - ($economyAvailable + $businessAvailable + $firstAvailable)),
                        'is_available_for_booking' => $status !== 'cancelled' && $i > 0, // Don't allow booking for today
                        'meal_options' => $flight->has_meal ? ['vegetarian', 'non-vegetarian', 'halal'] : null,
                        'notes' => $status === 'delayed' ? 'Flight delayed due to weather conditions' : 
                                  ($status === 'cancelled' ? 'Flight cancelled due to operational reasons' : null),
                    ]);
                }
            }
        }
    }
}