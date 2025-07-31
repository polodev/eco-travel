<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Hotel\Models\Hotel;
use Modules\Hotel\Models\HotelRoom;

class BookingHotel extends Model
{
    protected $fillable = [
        'booking_id',
        'hotel_id',
        'hotel_room_id',
        'checkin_date',
        'checkout_date',
        'nights',
        'rooms',
        'adults',
        'children',
        'room_rate',
        'total_room_cost',
        'taxes_fees',
        'total_amount',
        'guest_details',
        'rate_plan',
        'room_preferences',
        'special_requests',
        'confirmation_number',
        'booking_status',
        'checkin_time',
        'checkout_time',
        'hotel_policies',
        'included_services',
        'confirmed_at'
    ];

    protected $casts = [
        'room_rate' => 'decimal:2',
        'total_room_cost' => 'decimal:2',
        'taxes_fees' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'guest_details' => 'array',
        'room_preferences' => 'array',
        'special_requests' => 'array',
        'included_services' => 'array',
        'checkin_date' => 'date',
        'checkout_date' => 'date',
        'checkin_time' => 'datetime:H:i',
        'checkout_time' => 'datetime:H:i',
        'confirmed_at' => 'datetime',
        'nights' => 'integer',
        'rooms' => 'integer',
        'adults' => 'integer',
        'children' => 'integer'
    ];

    /**
     * Get the booking that owns this hotel booking.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the hotel.
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Get the hotel room.
     */
    public function hotelRoom(): BelongsTo
    {
        return $this->belongsTo(HotelRoom::class);
    }

    /**
     * Get total guests.
     */
    public function getTotalGuestsAttribute(): int
    {
        return $this->adults + $this->children;
    }

    /**
     * Get formatted total amount.
     */
    public function getFormattedTotalAmountAttribute(): string
    {
        return '৳' . number_format($this->total_amount, 2);
    }

    /**
     * Get formatted room rate.
     */
    public function getFormattedRoomRateAttribute(): string
    {
        return '৳' . number_format($this->room_rate, 2);
    }

    /**
     * Get booking status badge.
     */
    public function getBookingStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'checked_in' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'checked_out' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
            'no_show' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
        ];

        $color = $colors[$this->booking_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        $name = ucwords(str_replace('_', ' ', $this->booking_status));

        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>',
            $color,
            $name
        );
    }

    /**
     * Get rate plan badge.
     */
    public function getRatePlanBadgeAttribute(): string
    {
        $colors = [
            'room_only' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200',
            'breakfast_included' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'half_board' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'full_board' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
            'all_inclusive' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
        ];

        $color = $colors[$this->rate_plan] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        $name = ucwords(str_replace('_', ' ', $this->rate_plan));

        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>',
            $color,
            $name
        );
    }
}