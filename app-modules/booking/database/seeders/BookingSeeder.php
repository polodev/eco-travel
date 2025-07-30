<?php

namespace Modules\Booking\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Booking\Models\Booking;
use App\Models\User;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::limit(10)->get();
        
        foreach ($users as $user) {
            // Create 2-3 bookings per user
            for ($i = 0; $i < rand(2, 3); $i++) {
                $bookingType = ['flight', 'hotel', 'tour'][array_rand(['flight', 'hotel', 'tour'])];
                $status = ['pending', 'confirmed', 'completed'][array_rand(['pending', 'confirmed', 'completed'])];
                $totalAmount = rand(5000, 50000);
                $paidAmount = $status === 'completed' ? $totalAmount : rand(0, $totalAmount);
                
                Booking::create([
                    'user_id' => $user->id,
                    'booking_type' => $bookingType,
                    'status' => $status,
                    'total_amount' => $totalAmount,
                    'paid_amount' => $paidAmount,
                    'due_amount' => $totalAmount - $paidAmount,
                    'customer_details' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'nationality' => 'Bangladeshi',
                    ],
                    'contact_details' => [
                        'email' => $user->email,
                        'phone' => '+880' . rand(1000000000, 1999999999),
                    ],
                    'booking_date' => Carbon::now()->subDays(rand(1, 30)),
                    'travel_date' => Carbon::now()->addDays(rand(5, 60)),
                    'adults' => rand(1, 4),
                    'children' => rand(0, 2),
                    'payment_status' => $paidAmount >= $totalAmount ? 'paid' : ($paidAmount > 0 ? 'partial' : 'pending'),
                    'confirmed_at' => $status === 'confirmed' || $status === 'completed' ? Carbon::now()->subDays(rand(1, 10)) : null,
                ]);
            }
        }
    }
}