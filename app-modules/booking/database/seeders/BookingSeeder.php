<?php

namespace Modules\Booking\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\BookingFlight;
use Modules\Booking\Models\BookingHotel;
use Modules\Booking\Models\BookingTour;
use App\Models\User;
use Modules\Flight\Models\FlightSchedule;
use Modules\Hotel\Models\Hotel;
use Modules\Hotel\Models\HotelRoom;
use Modules\Hotel\Models\RoomInventory;
use Modules\Tour\Models\Tour;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::limit(50)->get(); // Increased to 50 users
        
        // Get available data for booking references
        $hotels = Hotel::with('rooms')->limit(10)->get();
        $tours = Tour::limit(10)->get();
        
        // For now, we'll create flight bookings without FlightSchedule dependency
        // as FlightSchedule model doesn't exist yet
        
        $bookingTypes = ['flight', 'hotel', 'tour', 'package'];
        $statuses = ['pending', 'confirmed', 'cancelled', 'completed', 'refunded'];
        $couponCodes = ['SAVE10', 'EARLY20', 'SUMMER15', 'FAMILY25', null, null, null]; // More nulls for variety
        
        foreach ($users as $user) {
            // Create 3-8 bookings per user for more test data
            $numBookings = rand(3, 8);
            
            for ($i = 0; $i < $numBookings; $i++) {
                $bookingType = $bookingTypes[array_rand($bookingTypes)];
                $status = $statuses[array_rand($statuses)];
                $couponCode = $couponCodes[array_rand($couponCodes)];
                
                // Generate realistic amounts
                $totalAmount = $this->getRealisticAmount($bookingType);
                $discount = $couponCode ? ($totalAmount * rand(5, 25) / 100) : 0;
                $netReceivableAmount = $totalAmount - $discount;
                
                // Generate travel dates
                $bookingDate = Carbon::now()->subDays(rand(1, 90));
                $travelDate = $bookingDate->copy()->addDays(rand(5, 180));
                $returnDate = $travelDate->copy()->addDays(rand(1, 14));
                
                $booking = Booking::create([
                    'user_id' => $user->id,
                    'booking_type' => $bookingType,
                    'status' => $status,
                    'total_amount' => $totalAmount,
                    'net_receivable_amount' => $netReceivableAmount,
                    'discount' => $discount,
                    'coupon_code' => $couponCode,
                    'customer_details' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'nationality' => $this->getRandomNationality(),
                        'passport_number' => $this->generatePassportNumber(),
                        'date_of_birth' => Carbon::now()->subYears(rand(18, 70))->toDateString(),
                    ],
                    'contact_details' => [
                        'email' => $user->email,
                        'phone' => $this->generatePhoneNumber(),
                        'emergency_contact' => $this->generatePhoneNumber(),
                        'address' => $this->getRandomAddress(),
                    ],
                    'additional_requirements' => $this->getRandomRequirements(),
                    'booking_date' => $bookingDate,
                    'travel_date' => $travelDate,
                    'return_date' => $bookingType !== 'hotel' ? $returnDate : null,
                    'adults' => rand(1, 4),
                    'children' => rand(0, 3),
                    'infants' => rand(0, 1),
                    'cancellation_policy' => $this->getCancellationPolicy(),
                    'notes' => $this->getRandomNotes(),
                    'confirmation_code' => $status === 'confirmed' || $status === 'completed' ? strtoupper(uniqid()) : null,
                    'confirmed_at' => in_array($status, ['confirmed', 'completed']) ? $bookingDate->copy()->addDays(rand(1, 5)) : null,
                    'cancelled_at' => $status === 'cancelled' ? $bookingDate->copy()->addDays(rand(1, 10)) : null,
                    'cancelled_by' => $status === 'cancelled' ? ['customer', 'admin', 'system'][array_rand(['customer', 'admin', 'system'])] : null,
                    'cancellation_reason' => $status === 'cancelled' ? $this->getCancellationReason() : null,
                ]);
                
                // Create specific booking records based on type
                $this->createSpecificBookingRecord($booking, $bookingType, $hotels, $tours);
            }
        }
    }
    
    /**
     * Create specific booking records based on booking type.
     */
    private function createSpecificBookingRecord(Booking $booking, string $type, $hotels, $tours)
    {
        switch ($type) {
            case 'flight':
                $this->createFlightBooking($booking);
                break;
            case 'hotel':
                $this->createHotelBooking($booking, $hotels);
                break;
            case 'tour':
                $this->createTourBooking($booking, $tours);
                break;
            case 'package':
                // Create combination bookings
                $this->createFlightBooking($booking);
                $this->createHotelBooking($booking, $hotels);
                break;
        }
    }
    
    /**
     * Create flight booking record.
     */
    private function createFlightBooking(Booking $booking)
    {
        $cabinClass = ['economy', 'business', 'first'][array_rand(['economy', 'business', 'first'])];
        $tripType = ['oneway', 'roundtrip'][array_rand(['oneway', 'roundtrip'])];
        
        // Generate realistic flight pricing
        $basePrice = rand(8000, 45000);
        $adultPrice = $basePrice * $this->getCabinMultiplier($cabinClass);
        $childPrice = $adultPrice * 0.75;
        $infantPrice = $adultPrice * 0.10;
        $taxesFees = $adultPrice * 0.15;
        
        $totalFlightAmount = ($adultPrice * $booking->adults) + 
                           ($childPrice * $booking->children) + 
                           ($infantPrice * $booking->infants) + 
                           $taxesFees;
        
        BookingFlight::create([
            'booking_id' => $booking->id,
            'flight_schedule_id' => rand(1, 10), // Placeholder ID
            'trip_type' => $tripType,
            'cabin_class' => $cabinClass,
            'adults' => $booking->adults,
            'children' => $booking->children,
            'infants' => $booking->infants,
            'adult_price' => $adultPrice,
            'child_price' => $childPrice,
            'infant_price' => $infantPrice,
            'taxes_fees' => $taxesFees,
            'total_amount' => $totalFlightAmount,
            'passenger_details' => $this->generatePassengerDetails($booking),
            'seat_selections' => $this->generateSeatSelections($booking->adults + $booking->children),
            'meal_preferences' => $this->generateMealPreferences($booking->adults + $booking->children),
            'special_requests' => $this->getFlightSpecialRequests(),
            'pnr_code' => in_array($booking->status, ['confirmed', 'completed']) ? strtoupper(uniqid()) : null,
            'ticket_numbers' => in_array($booking->status, ['confirmed', 'completed']) ? $this->generateTicketNumbers($booking->adults + $booking->children) : null,
            'ticket_status' => $this->getTicketStatus($booking->status),
            'departure_datetime' => $booking->travel_date,
            'arrival_datetime' => $booking->travel_date->copy()->addMinutes(rand(90, 480)), // 1.5 to 8 hours
            'departure_airport' => $this->getRandomAirport(),
            'arrival_airport' => $this->getRandomAirport(),
            'airline_code' => $this->getRandomAirlineCode(),
            'flight_number' => rand(100, 999),
        ]);
    }
    
    /**
     * Create hotel booking record.
     */
    private function createHotelBooking(Booking $booking, $hotels)
    {
        if ($hotels->isEmpty()) return;
        
        $hotel = $hotels->random();
        $room = $hotel->rooms->isNotEmpty() ? $hotel->rooms->random() : null;
        
        if (!$room) return;
        
        $checkinDate = $booking->travel_date;
        $checkoutDate = $checkinDate->copy()->addDays(rand(1, 7));
        $nights = $checkinDate->diffInDays($checkoutDate);
        $rooms = rand(1, 3);
        
        $roomRate = $room->base_price * (1 + rand(-20, 50) / 100); // Price variation
        $totalRoomCost = $roomRate * $nights * $rooms;
        $taxesFees = $totalRoomCost * 0.12; // 12% tax
        $totalHotelAmount = $totalRoomCost + $taxesFees;
        
        BookingHotel::create([
            'booking_id' => $booking->id,
            'hotel_id' => $hotel->id,
            'hotel_room_id' => $room->id,
            'checkin_date' => $checkinDate->toDateString(),
            'checkout_date' => $checkoutDate->toDateString(),
            'nights' => $nights,
            'rooms' => $rooms,
            'adults' => $booking->adults,
            'children' => $booking->children,
            'room_rate' => $roomRate,
            'total_room_cost' => $totalRoomCost,
            'taxes_fees' => $taxesFees,
            'total_amount' => $totalHotelAmount,
            'guest_details' => $this->generateGuestDetails($booking),
            'rate_plan' => ['room_only', 'breakfast_included', 'half_board', 'full_board', 'all_inclusive'][array_rand(['room_only', 'breakfast_included', 'half_board', 'full_board', 'all_inclusive'])],
            'room_preferences' => $this->getRoomPreferences(),
            'special_requests' => $this->getHotelSpecialRequests(),
            'confirmation_number' => in_array($booking->status, ['confirmed', 'completed']) ? strtoupper(uniqid()) : null,
            'booking_status' => $this->getHotelBookingStatus($booking->status),
            'checkin_time' => '14:00:00',
            'checkout_time' => '12:00:00',
            'hotel_policies' => $this->getHotelPolicies(),
            'included_services' => $this->getIncludedServices(),
            'confirmed_at' => in_array($booking->status, ['confirmed', 'completed']) ? $booking->confirmed_at : null,
        ]);
    }
    
    /**
     * Create tour booking record.
     */
    private function createTourBooking(Booking $booking, $tours)
    {
        if ($tours->isEmpty()) return;
        
        $tour = $tours->random();
        
        $adultPrice = $tour->base_price;
        $childPrice = $tour->child_price ?? ($adultPrice * 0.7);
        $singleSupplement = rand(0, 1) ? $tour->single_supplement ?? 0 : 0;
        
        $totalTourAmount = ($adultPrice * $booking->adults) + 
                          ($childPrice * $booking->children) + 
                          $singleSupplement;
        
        BookingTour::create([
            'booking_id' => $booking->id,
            'tour_id' => $tour->id,
            'tour_start_date' => $booking->travel_date->toDateString(),
            'tour_end_date' => $booking->travel_date->copy()->addDays($tour->duration_days - 1)->toDateString(),
            'adults' => $booking->adults,
            'children' => $booking->children,
            'adult_price' => $adultPrice,
            'child_price' => $childPrice,
            'single_supplement' => $singleSupplement,
            'total_amount' => $totalTourAmount,
            'participant_details' => $this->generateParticipantDetails($booking),
            'accommodation_type' => ['shared', 'single', 'twin', 'double'][array_rand(['shared', 'single', 'twin', 'double'])],
            'dietary_requirements' => $this->getDietaryRequirements(),
            'medical_conditions' => $this->getMedicalConditions(),
            'emergency_contacts' => $this->getEmergencyContacts(),
            'special_requests' => $this->getTourSpecialRequests(),
            'optional_activities' => $this->getOptionalActivities(),
            'tour_voucher' => in_array($booking->status, ['confirmed', 'completed']) ? strtoupper(uniqid()) : null,
            'booking_status' => $this->getTourBookingStatus($booking->status),
            'tour_guide' => in_array($booking->status, ['confirmed', 'completed']) ? $this->getRandomTourGuide() : null,
            'pickup_details' => $this->getPickupDetails(),
            'tour_inclusions' => $tour->included_services ?? [],
            'tour_exclusions' => $tour->excluded_services ?? [],
            'what_to_bring' => $tour->what_to_bring ?? [],
            'confirmed_at' => in_array($booking->status, ['confirmed', 'completed']) ? $booking->confirmed_at : null,
        ]);
    }
    
    // Helper methods for generating realistic data
    private function getRealisticAmount(string $type): float
    {
        switch ($type) {
            case 'flight':
                return rand(8000, 85000); // ৳8k to ৳85k
            case 'hotel':
                return rand(5000, 45000); // ৳5k to ৳45k
            case 'tour':
                return rand(12000, 75000); // ৳12k to ৳75k
            case 'package':
                return rand(25000, 150000); // ৳25k to ৳150k
            default:
                return rand(10000, 50000);
        }
    }
    
    private function getRandomNationality(): string
    {
        $nationalities = ['Bangladeshi', 'Indian', 'Pakistani', 'British', 'American', 'Canadian', 'Australian'];
        return $nationalities[array_rand($nationalities)];
    }
    
    private function generatePassportNumber(): string
    {
        return strtoupper(chr(rand(65, 90)) . chr(rand(65, 90)) . rand(1000000, 9999999));
    }
    
    private function generatePhoneNumber(): string
    {
        $codes = ['+880-17', '+880-19', '+880-16', '+880-18', '+880-15'];
        return $codes[array_rand($codes)] . rand(10000000, 99999999);
    }
    
    private function getRandomAddress(): string
    {
        $addresses = [
            'Dhaka, Bangladesh',
            'Chittagong, Bangladesh', 
            'Sylhet, Bangladesh',
            'London, UK',
            'New York, USA',
            'Toronto, Canada',
            'Mumbai, India'
        ];
        return $addresses[array_rand($addresses)];
    }
    
    private function getRandomRequirements(): ?array
    {
        $requirements = [
            ['dietary' => 'Vegetarian meals', 'accessibility' => 'Wheelchair accessible'],
            ['special' => 'Halal food only', 'medical' => 'Diabetic passenger'],
            ['preference' => 'Window seat', 'note' => 'First time traveler'],
            null, null // More nulls for variety
        ];
        return $requirements[array_rand($requirements)];
    }
    
    private function getCancellationPolicy(): array
    {
        return [
            '30_days_before' => rand(10, 20) . '% cancellation fee',
            '15_days_before' => rand(25, 40) . '% cancellation fee',
            '7_days_before' => rand(50, 65) . '% cancellation fee',
            '3_days_before' => rand(75, 85) . '% cancellation fee',
            'same_day' => 'No refund'
        ];
    }
    
    private function getRandomNotes(): ?string
    {
        $notes = [
            'Customer requested early check-in',
            'Honeymoon couple - special arrangement needed',
            'Group booking with corporate discount',
            'Frequent traveler - VIP treatment',
            'First time international travel',
            null, null, null // More nulls
        ];
        return $notes[array_rand($notes)];
    }
    
    private function getCancellationReason(): string
    {
        $reasons = [
            'Travel restrictions due to COVID-19',
            'Personal emergency',
            'Flight cancelled by airline',
            'Health issues',
            'Visa denied',
            'Change in travel plans',
            'Financial constraints'
        ];
        return $reasons[array_rand($reasons)];
    }
    
    private function getCabinMultiplier(string $cabin): float
    {
        switch ($cabin) {
            case 'business': return 2.5;
            case 'first': return 4.0;
            default: return 1.0;
        }
    }
    
    private function generatePassengerDetails(Booking $booking): array
    {
        $passengers = [];
        $totalPassengers = $booking->adults + $booking->children + $booking->infants;
        
        for ($i = 0; $i < $totalPassengers; $i++) {
            $passengers[] = [
                'name' => 'Passenger ' . ($i + 1),
                'type' => $i < $booking->adults ? 'adult' : ($i < $booking->adults + $booking->children ? 'child' : 'infant'),
                'passport' => $this->generatePassportNumber(),
                'nationality' => $this->getRandomNationality()
            ];
        }
        
        return $passengers;
    }
    
    private function generateSeatSelections(?int $count): ?array
    {
        if (!$count) return null;
        
        $seats = [];
        for ($i = 0; $i < $count; $i++) {
            $seats[] = rand(1, 30) . chr(rand(65, 70)); // 1A, 15F, etc.
        }
        return $seats;
    }
    
    private function generateMealPreferences(?int $count): ?array
    {
        if (!$count) return null;
        
        $meals = ['Standard', 'Vegetarian', 'Halal', 'Kosher', 'Hindu', 'Child Meal'];
        $preferences = [];
        for ($i = 0; $i < $count; $i++) {
            $preferences[] = $meals[array_rand($meals)];
        }
        return $preferences;
    }
    
    private function getFlightSpecialRequests(): ?array
    {
        $requests = [
            ['wheelchair_assistance' => true],
            ['extra_legroom' => true],
            ['special_meal' => 'Diabetic'],
            null, null
        ];
        return $requests[array_rand($requests)];
    }
    
    private function generateTicketNumbers(int $count): string
    {
        $numbers = [];
        for ($i = 0; $i < $count; $i++) {
            $numbers[] = '235-' . rand(1000000000, 9999999999);
        }
        return implode(', ', $numbers);
    }
    
    private function getTicketStatus(string $bookingStatus): string
    {
        switch ($bookingStatus) {
            case 'confirmed':
            case 'completed':
                return 'issued';
            case 'cancelled':
                return 'cancelled';
            default:
                return 'pending';
        }
    }
    
    private function generateGuestDetails(Booking $booking): array
    {
        return [
            'primary_guest' => $booking->customer_details['name'] ?? 'Guest',
            'total_guests' => $booking->adults + $booking->children,
            'guest_preferences' => ['Non-smoking room', 'High floor preferred']
        ];
    }
    
    private function getRoomPreferences(): ?array
    {
        $preferences = [
            ['view' => 'Sea view', 'floor' => 'High floor'],
            ['view' => 'City view', 'bed' => 'King size bed'],
            ['accessibility' => 'Wheelchair accessible'],
            null, null
        ];
        return $preferences[array_rand($preferences)];
    }
    
    private function getHotelSpecialRequests(): ?array
    {
        $requests = [
            ['early_checkin' => true, 'late_checkout' => false],
            ['extra_bed' => true, 'baby_cot' => false],
            ['room_service' => 'Welcome fruit basket'],
            null, null
        ];
        return $requests[array_rand($requests)];
    }
    
    private function getHotelBookingStatus(string $bookingStatus): string
    {
        switch ($bookingStatus) {
            case 'completed':
                return 'checked_out';
            case 'confirmed':
                return 'confirmed';
            case 'cancelled':
                return 'cancelled';
            default:
                return 'pending';
        }
    }
    
    private function getHotelPolicies(): string
    {
        return 'Check-in: 2:00 PM, Check-out: 12:00 PM. Cancellation allowed up to 24 hours before arrival.';
    }
    
    private function getIncludedServices(): array
    {
        return ['Free WiFi', 'Daily housekeeping', 'Welcome drink', '24-hour front desk'];
    }
    
    private function generateParticipantDetails(Booking $booking): array
    {
        $participants = [];
        $totalParticipants = $booking->adults + $booking->children;
        
        for ($i = 0; $i < $totalParticipants; $i++) {
            $participants[] = [
                'name' => 'Participant ' . ($i + 1),
                'age' => $i < $booking->adults ? rand(18, 65) : rand(5, 17),
                'passport' => $this->generatePassportNumber(),
                'emergency_contact' => $this->generatePhoneNumber()
            ];
        }
        
        return $participants;
    }
    
    private function getDietaryRequirements(): ?array
    {
        $requirements = [
            ['vegetarian' => true, 'no_nuts' => false],
            ['halal' => true, 'no_seafood' => false],
            ['diabetic_friendly' => true],
            null, null
        ];
        return $requirements[array_rand($requirements)];
    }
    
    private function getMedicalConditions(): ?array
    {
        $conditions = [
            ['condition' => 'Diabetes', 'medication' => 'Insulin'],
            ['condition' => 'Hypertension', 'medication' => 'Blood pressure medication'],
            ['condition' => 'Asthma', 'medication' => 'Inhaler'],
            null, null, null
        ];
        return $conditions[array_rand($conditions)];
    }
    
    private function getEmergencyContacts(): array
    {
        return [
            'primary' => [
                'name' => 'Emergency Contact',
                'relationship' => 'Spouse',
                'phone' => $this->generatePhoneNumber()
            ]
        ];
    }
    
    private function getTourSpecialRequests(): ?array
    {
        $requests = [
            ['photography_service' => true],
            ['private_guide' => true],
            ['cultural_experience' => 'Local cooking class'],
            null, null
        ];
        return $requests[array_rand($requests)];
    }
    
    private function getOptionalActivities(): ?array
    {
        $activities = [
            [
                'activity' => 'Sunset cruise',
                'price' => 2500,
                'selected' => true
            ],
            [
                'activity' => 'Cultural show',
                'price' => 1500,
                'selected' => false
            ],
            null, null
        ];
        return $activities[array_rand($activities)];
    }
    
    private function getTourBookingStatus(string $bookingStatus): string
    {
        switch ($bookingStatus) {
            case 'completed':
                return 'completed';
            case 'confirmed':
                return 'confirmed';
            case 'cancelled':
                return 'cancelled';
            default:
                return 'pending';
        }
    }
    
    private function getRandomTourGuide(): string
    {
        $guides = ['Rahman Ahmed', 'Fatima Khan', 'Karim Hassan', 'Rashida Begum', 'Abdul Malik'];
        return $guides[array_rand($guides)];
    }
    
    private function getPickupDetails(): array
    {
        return [
            'location' => 'Hotel lobby',
            'time' => '08:00:00',
            'contact' => $this->generatePhoneNumber()
        ];
    }
    
    private function getRandomAirport(): string
    {
        $airports = ['DAC', 'CGP', 'CXB', 'ZYL', 'DEL', 'BOM', 'BKK', 'DXB', 'LHR', 'JFK'];
        return $airports[array_rand($airports)];
    }
    
    private function getRandomAirlineCode(): string
    {
        $airlines = ['BG', 'BS', 'VQ', '6E', 'AI', 'EK', 'TG', 'BA', 'AA'];
        return $airlines[array_rand($airlines)];
    }
}