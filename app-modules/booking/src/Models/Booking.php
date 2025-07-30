<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'user_id',
        'booking_type',
        'status',
        'total_amount',
        'paid_amount',
        'due_amount',
        'customer_details',
        'contact_details',
        'additional_requirements',
        'booking_date',
        'travel_date',
        'return_date',
        'adults',
        'children',
        'infants',
        'cancellation_policy',
        'notes',
        'payment_status',
        'confirmation_code',
        'confirmed_at',
        'cancelled_at',
        'cancelled_by',
        'cancellation_reason'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'customer_details' => 'array',
        'contact_details' => 'array',
        'additional_requirements' => 'array',
        'booking_date' => 'datetime',
        'travel_date' => 'datetime',
        'return_date' => 'datetime',
        'adults' => 'integer',
        'children' => 'integer',
        'infants' => 'integer',
        'cancellation_policy' => 'array',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Boot method to generate booking reference.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            if (!$booking->booking_reference) {
                $booking->booking_reference = $booking->generateBookingReference();
            }
        });
    }

    /**
     * Get the user that owns this booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get flight bookings.
     */
    public function flightBookings(): HasMany
    {
        return $this->hasMany(BookingFlight::class);
    }

    /**
     * Get hotel bookings.
     */
    public function hotelBookings(): HasMany
    {
        return $this->hasMany(BookingHotel::class);
    }

    /**
     * Get tour bookings.
     */
    public function tourBookings(): HasMany
    {
        return $this->hasMany(BookingTour::class);
    }

    /**
     * Scope for booking type.
     */
    public function scopeType($query, $type)
    {
        return $query->where('booking_type', $type);
    }

    /**
     * Scope for status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for confirmed bookings.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope for pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Get available booking types.
     */
    public static function getAvailableBookingTypes(): array
    {
        return [
            'flight' => 'Flight',
            'hotel' => 'Hotel',
            'tour' => 'Tour Package',
            'package' => 'Holiday Package',
        ];
    }

    /**
     * Get available statuses.
     */
    public static function getAvailableStatuses(): array
    {
        return [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            'refunded' => 'Refunded',
        ];
    }

    /**
     * Get available payment statuses.
     */
    public static function getAvailablePaymentStatuses(): array
    {
        return [
            'pending' => 'Pending',
            'partial' => 'Partially Paid',
            'paid' => 'Fully Paid',
            'refunded' => 'Refunded',
        ];
    }

    /**
     * Generate unique booking reference.
     */
    private function generateBookingReference(): string
    {
        $prefix = 'ECO';
        $year = now()->year;
        $month = now()->format('m');
        
        // Get last booking number for this month
        $lastBooking = self::where('booking_reference', 'like', "{$prefix}-{$year}{$month}%")
                          ->orderBy('id', 'desc')
                          ->first();
        
        $nextNumber = 1;
        if ($lastBooking) {
            $lastNumber = (int) substr($lastBooking->booking_reference, -4);
            $nextNumber = $lastNumber + 1;
        }
        
        return sprintf('%s-%s%s%04d', $prefix, $year, $month, $nextNumber);
    }

    /**
     * Get status badge.
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
            'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
            'completed' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
            'refunded' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100',
        ];

        $color = $colors[$this->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';
        $name = self::getAvailableStatuses()[$this->status] ?? ucfirst($this->status);

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $name . '</span>';
    }

    /**
     * Get booking type badge.
     */
    public function getBookingTypeBadgeAttribute()
    {
        $colors = [
            'flight' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
            'hotel' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'tour' => 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100',
            'package' => 'bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100',
        ];

        $color = $colors[$this->booking_type] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';
        $name = self::getAvailableBookingTypes()[$this->booking_type] ?? ucfirst($this->booking_type);

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $name . '</span>';
    }

    /**
     * Get payment status badge.
     */
    public function getPaymentStatusBadgeAttribute()
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
            'partial' => 'bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100',
            'paid' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'refunded' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
        ];

        $color = $colors[$this->payment_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';
        $name = self::getAvailablePaymentStatuses()[$this->payment_status] ?? ucfirst($this->payment_status);

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $name . '</span>';
    }

    /**
     * Get total passengers.
     */
    public function getTotalPassengersAttribute()
    {
        return $this->adults + $this->children + $this->infants;
    }

    /**
     * Get customer name.
     */
    public function getCustomerNameAttribute()
    {
        return $this->customer_details['name'] ?? 'N/A';
    }

    /**
     * Get customer email.
     */
    public function getCustomerEmailAttribute()
    {
        return $this->contact_details['email'] ?? 'N/A';
    }

    /**
     * Get customer phone.
     */
    public function getCustomerPhoneAttribute()
    {
        return $this->contact_details['phone'] ?? 'N/A';
    }

    /**
     * Check if booking is cancellable.
     */
    public function isCancellable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']) 
            && $this->travel_date 
            && $this->travel_date->isFuture();
    }

    /**
     * Check if booking is modifiable.
     */
    public function isModifiable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed'])
            && $this->travel_date
            && $this->travel_date->gt(now()->addDays(2)); // At least 2 days before travel
    }

    /**
     * Get payment balance.
     */
    public function getPaymentBalanceAttribute()
    {
        return $this->total_amount - $this->paid_amount;
    }

    /**
     * Check if fully paid.
     */
    public function isFullyPaid(): bool
    {
        return $this->paid_amount >= $this->total_amount;
    }

    /**
     * Mark as confirmed.
     */
    public function markAsConfirmed(): void
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    /**
     * Cancel booking.
     */
    public function cancel(string $reason, string $cancelledBy = 'customer'): void
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancelled_by' => $cancelledBy,
            'cancellation_reason' => $reason,
        ]);
    }
}