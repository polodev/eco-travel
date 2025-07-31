<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Payment\Models\Payment;
use Modules\Payment\Models\CustomPayment;
use Modules\Booking\Models\Booking;
use App\Models\User;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CustomPaymentSeeder::class,
            BookingPaymentSeeder::class,
        ]);
    }
}

class CustomPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::limit(20)->get();
        
        // Create custom payments (frontend form submissions)
        foreach ($users as $user) {
            // 30% chance of having custom payments
            if (rand(1, 100) <= 30) {
                $numPayments = rand(1, 3);
                
                for ($i = 0; $i < $numPayments; $i++) {
                    $amount = rand(1000, 25000);
                    $status = ['submitted', 'processing', 'completed', 'cancelled'][array_rand(['submitted', 'processing', 'completed', 'cancelled'])];
                    $submittedAt = Carbon::now()->subDays(rand(1, 60));
                    
                    $customPayment = CustomPayment::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'mobile' => $this->generatePhoneNumber(),
                        'amount' => $amount,
                        'purpose' => $this->getPaymentPurpose(),
                        'description' => $this->getPaymentDescription(),
                        'reference_number' => 'REF-' . strtoupper(uniqid()),
                        'payment_method' => $this->getRandomPaymentMethod(),
                        'status' => $status,
                        'form_data' => $this->getFormData($user, $amount),
                        'ip_address' => $this->generateIPAddress(),
                        'user_agent' => $this->generateUserAgent(),
                        'submitted_at' => $submittedAt,
                        'processed_at' => in_array($status, ['processing', 'completed']) ? $submittedAt->copy()->addHours(rand(1, 48)) : null,
                        'completed_at' => $status === 'completed' ? $submittedAt->copy()->addDays(rand(1, 7)) : null,
                        'admin_notes' => $this->getAdminNotes($status),
                        'processed_by' => in_array($status, ['processing', 'completed']) ? $users->random()->id : null,
                    ]);
                    
                    // Create payment records for this custom payment
                    $this->createCustomPaymentRecords($customPayment, $users);
                }
            }
        }
    }
    
    private function createCustomPaymentRecords(CustomPayment $customPayment, $users)
    {
        // Determine how many payment attempts/records to create
        $paymentCount = rand(1, 3);
        $totalPaid = 0;
        
        for ($i = 0; $i < $paymentCount; $i++) {
            $remainingAmount = $customPayment->amount - $totalPaid;
            if ($remainingAmount <= 0) break;
            
            // Payment amount (could be partial)
            $paymentAmount = $i === $paymentCount - 1 ? $remainingAmount : rand(500, min($remainingAmount, $customPayment->amount * 0.7));
            $totalPaid += $paymentAmount;
            
            $paymentStatus = $this->getPaymentStatus($customPayment->status, $i, $paymentCount);
            $paymentDate = $customPayment->submitted_at->copy()->addDays(rand(0, 5));
            
            Payment::create([
                'custom_payment_id' => $customPayment->id,
                'created_by' => $users->random()->id, // Admin who created the payment record
                'amount' => $paymentAmount,
                'status' => $paymentStatus,
                'payment_method' => $customPayment->payment_method,
                'transaction_id' => $paymentStatus === 'completed' ? 'TXN-' . strtoupper(uniqid()) : null,
                'gateway_payment_id' => $paymentStatus === 'completed' ? 'GPW-' . rand(100000, 999999) : null,
                'gateway_response' => $paymentStatus === 'completed' ? $this->getGatewayResponse() : null,
                'gateway_reference' => $paymentStatus === 'completed' ? 'REF-' . rand(100000, 999999) : null,
                'payment_date' => $paymentStatus === 'completed' ? $paymentDate : null,
                'processed_at' => in_array($paymentStatus, ['completed', 'failed']) ? $paymentDate->copy()->addMinutes(rand(5, 120)) : null,
                'failed_at' => $paymentStatus === 'failed' ? $paymentDate->copy()->addMinutes(rand(5, 30)) : null,
                'notes' => $this->getPaymentNotes($paymentStatus),
                'receipt_number' => $paymentStatus === 'completed' ? 'RCP-' . date('Ymd') . '-' . rand(1000, 9999) : null,
                'payment_details' => $this->getPaymentDetails($customPayment->payment_method),
            ]);
        }
    }
    
    private function generatePhoneNumber(): string
    {
        $codes = ['+880-17', '+880-19', '+880-16', '+880-18', '+880-15'];
        return $codes[array_rand($codes)] . rand(10000000, 99999999);
    }
    
    private function getPaymentPurpose(): string
    {
        $purposes = [
            'Tour booking payment',
            'Flight ticket payment',
            'Hotel reservation payment',
            'Service payment',
            'Package booking payment',
            'Additional services',
            'Visa processing fee',
            'Travel insurance'
        ];
        return $purposes[array_rand($purposes)];
    }
    
    private function getPaymentDescription(): ?string
    {
        $descriptions = [
            'Payment for Cox\'s Bazar tour package',
            'Flight booking for Dhaka to Bangkok',
            'Hotel reservation at Sea Palace',
            'Visa processing and documentation',
            'Travel insurance and additional services',
            null, null // Some payments without description
        ];
        return $descriptions[array_rand($descriptions)];
    }
    
    private function getRandomPaymentMethod(): string
    {
        $methods = ['sslcommerz', 'bkash', 'nagad', 'city_bank', 'brac_bank', 'bank_transfer', 'cash'];
        return $methods[array_rand($methods)];
    }
    
    private function getFormData($user, $amount): array
    {
        return [
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'amount' => $amount,
            'currency' => 'BDT',
            'form_type' => 'custom_payment',
            'browser_info' => [
                'user_agent' => $this->generateUserAgent(),
                'language' => 'en-US',
                'screen_resolution' => '1920x1080'
            ]
        ];
    }
    
    private function generateIPAddress(): string
    {
        return rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255);
    }
    
    private function generateUserAgent(): string
    {
        $agents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1'
        ];
        return $agents[array_rand($agents)];
    }
    
    private function getAdminNotes(?string $status): ?string
    {
        switch ($status) {
            case 'processing':
                return 'Payment verification in progress';
            case 'completed':
                return 'Payment completed successfully';
            case 'cancelled':
                return 'Payment cancelled by customer request';
            default:
                return null;
        }
    }
    
    private function getPaymentStatus(string $customPaymentStatus, int $index, int $total): string
    {
        if ($customPaymentStatus === 'cancelled') {
            return 'cancelled';
        }
        
        if ($customPaymentStatus === 'completed') {
            return 'completed';
        }
        
        // For processing and submitted, mix payment statuses
        $statuses = ['pending', 'processing', 'completed', 'failed'];
        return $statuses[array_rand($statuses)];
    }
    
    private function getGatewayResponse(): array
    {
        return [
            'status' => 'success',
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
            'amount' => rand(1000, 25000),
            'currency' => 'BDT',
            'gateway_fee' => rand(50, 200),
            'response_code' => '00',
            'response_message' => 'Transaction successful'
        ];
    }
    
    private function getPaymentNotes(string $status): ?string
    {
        switch ($status) {
            case 'completed':
                return 'Payment processed successfully through gateway';
            case 'failed':
                return 'Payment failed due to insufficient balance';
            case 'pending':
                return 'Payment awaiting processing';
            default:
                return null;
        }
    }
    
    private function getPaymentDetails(string $method): ?array
    {
        switch ($method) {
            case 'bkash':
                return [
                    'sender_number' => '+880-17' . rand(10000000, 99999999),
                    'transaction_type' => 'send_money'
                ];
            case 'nagad':
                return [
                    'sender_number' => '+880-19' . rand(10000000, 99999999),
                    'transaction_type' => 'send_money'
                ];
            case 'bank_transfer':
                return [
                    'bank_name' => 'Dutch Bangla Bank',
                    'account_number' => 'DBL-' . rand(1000000, 9999999)
                ];
            default:
                return null;
        }
    }
}

class BookingPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = Booking::limit(100)->get(); // Create payments for first 100 bookings
        $users = User::all();
        
        foreach ($bookings as $booking) {
            // 80% chance of having payment records
            if (rand(1, 100) <= 80) {
                $this->createBookingPayments($booking, $users);
            }
        }
    }
    
    private function createBookingPayments(Booking $booking, $users)
    {
        $totalPaid = 0;
        $netReceivableAmount = $booking->net_receivable_amount;
        
        // Determine payment pattern based on booking status
        $paymentCount = $this->getPaymentCount($booking->status);
        
        for ($i = 0; $i < $paymentCount; $i++) {
            $remainingAmount = $netReceivableAmount - $totalPaid;
            if ($remainingAmount <= 0) break;
            
            // Determine payment amount
            $paymentAmount = $this->getPaymentAmount($booking, $remainingAmount, $i, $paymentCount);
            $totalPaid += $paymentAmount;
            
            $paymentStatus = $this->getBookingPaymentStatus($booking->status, $i, $paymentCount, $totalPaid, $netReceivableAmount);
            $paymentDate = $booking->booking_date->copy()->addDays(rand(0, 10));
            
            Payment::create([
                'booking_id' => $booking->id,
                'created_by' => $this->getPaymentCreator($users, $booking),
                'amount' => $paymentAmount,
                'status' => $paymentStatus,
                'payment_method' => $this->getBookingPaymentMethod(),
                'transaction_id' => $paymentStatus === 'completed' ? 'BKG-' . strtoupper(uniqid()) : null,
                'gateway_payment_id' => $paymentStatus === 'completed' ? 'GPW-' . rand(100000, 999999) : null,
                'gateway_response' => $paymentStatus === 'completed' ? $this->getBookingGatewayResponse($paymentAmount) : null,
                'gateway_reference' => $paymentStatus === 'completed' ? 'REF-' . rand(100000, 999999) : null,
                'payment_date' => $paymentStatus === 'completed' ? $paymentDate : null,
                'processed_at' => in_array($paymentStatus, ['completed', 'failed']) ? $paymentDate->copy()->addMinutes(rand(5, 120)) : null,
                'failed_at' => $paymentStatus === 'failed' ? $paymentDate->copy()->addMinutes(rand(5, 30)) : null,
                'notes' => $this->getBookingPaymentNotes($booking, $i),
                'receipt_number' => $paymentStatus === 'completed' ? 'BKG-' . date('Ymd') . '-' . rand(1000, 9999) : null,
                'payment_details' => $this->getBookingPaymentDetails($booking),
            ]);
        }
    }
    
    private function getPaymentCount(string $bookingStatus): int
    {
        switch ($bookingStatus) {
            case 'completed':
                return rand(1, 3); // Completed bookings have 1-3 payments
            case 'confirmed':
                return rand(1, 2); // Confirmed bookings have 1-2 payments
            case 'cancelled':
                return rand(0, 1); // Cancelled might have 0-1 payments
            default:
                return rand(1, 2); // Pending bookings have 1-2 payments
        }
    }
    
    private function getPaymentAmount(Booking $booking, float $remainingAmount, int $index, int $total): float
    {
        if ($index === $total - 1) {
            // Last payment covers remaining amount
            return $remainingAmount;
        }
        
        // Partial payments - typically 30-70% of remaining
        $percentage = rand(30, 70) / 100;
        return min($remainingAmount * $percentage, $remainingAmount);
    }
    
    private function getBookingPaymentStatus(string $bookingStatus, int $index, int $total, float $totalPaid, float $netAmount): string
    {
        if ($bookingStatus === 'completed' && $totalPaid >= $netAmount) {
            return 'completed';
        }
        
        if ($bookingStatus === 'cancelled') {
            return rand(0, 1) ? 'refunded' : 'cancelled';
        }
        
        // Mix of statuses for active bookings
        $statuses = ['pending', 'processing', 'completed', 'failed'];
        $weights = [10, 15, 60, 15]; // Higher chance of completed payments
        
        return $this->getWeightedRandom($statuses, $weights);
    }
    
    private function getWeightedRandom(array $values, array $weights): string
    {
        $totalWeight = array_sum($weights);
        $random = rand(1, $totalWeight);
        
        $currentWeight = 0;
        foreach ($values as $i => $value) {
            $currentWeight += $weights[$i];
            if ($random <= $currentWeight) {
                return $value;
            }
        }
        
        return $values[0];
    }
    
    private function getPaymentCreator($users, Booking $booking): ?int
    {
        // 70% chance it's auto-generated (null), 30% chance admin created
        if (rand(1, 100) <= 70) {
            return null; // Auto-generated when booking created
        }
        
        return $users->random()->id; // Admin/employee created
    }
    
    private function getBookingPaymentMethod(): string
    {
        $methods = ['sslcommerz', 'bkash', 'nagad', 'city_bank', 'brac_bank', 'bank_transfer'];
        $weights = [25, 20, 15, 15, 10, 15]; // SSLCommerz and bKash more common
        
        return $this->getWeightedRandom($methods, $weights);
    }
    
    private function getBookingGatewayResponse(float $amount): array
    {
        return [
            'status' => 'success',
            'transaction_id' => 'BKG-' . strtoupper(uniqid()),
            'amount' => $amount,
            'currency' => 'BDT',
            'gateway_fee' => $amount * 0.02, // 2% gateway fee
            'response_code' => '00',
            'response_message' => 'Booking payment successful',
            'card_type' => ['visa', 'mastercard', 'mobile_banking'][array_rand(['visa', 'mastercard', 'mobile_banking'])]
        ];
    }
    
    private function getBookingPaymentNotes(Booking $booking, int $paymentIndex): ?string
    {
        $notes = [
            'Advance payment for booking ' . $booking->booking_reference,
            'Full payment for confirmed booking',
            'Partial payment - ' . ($paymentIndex + 1) . ' of multiple installments',
            'Payment processed automatically',
            'Manual payment entry by admin',
            null, null // Some payments without notes
        ];
        return $notes[array_rand($notes)];
    }
    
    private function getBookingPaymentDetails(Booking $booking): array
    {
        return [
            'booking_reference' => $booking->booking_reference,
            'booking_type' => $booking->booking_type,
            'customer_name' => $booking->customer_details['name'] ?? 'Unknown',
            'payment_for' => ucfirst($booking->booking_type) . ' booking',
            'travel_date' => $booking->travel_date ? $booking->travel_date->toDateString() : null
        ];
    }
}