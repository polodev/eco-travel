<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Flight\Models\FlightSchedule;

class BookingFlight extends Model
{
    protected $fillable = [
        'booking_id',
        'flight_schedule_id',
        'trip_type',
        'cabin_class',
        'adults',
        'children',
        'infants',
        'adult_price',
        'child_price',
        'infant_price',
        'taxes_fees',
        'total_amount',
        'passenger_details',
        'seat_selections',
        'meal_preferences',
        'special_requests',
        'pnr_code',
        'ticket_numbers',
        'ticket_status',
        'departure_datetime',
        'arrival_datetime',
        'departure_airport',
        'arrival_airport',
        'airline_code',
        'flight_number'
    ];

    protected $casts = [
        'adult_price' => 'decimal:2',
        'child_price' => 'decimal:2',
        'infant_price' => 'decimal:2',
        'taxes_fees' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'passenger_details' => 'array',
        'seat_selections' => 'array',
        'meal_preferences' => 'array',
        'special_requests' => 'array',
        'departure_datetime' => 'datetime',
        'arrival_datetime' => 'datetime',
        'adults' => 'integer',
        'children' => 'integer',
        'infants' => 'integer'
    ];

    /**
     * Get the booking that owns this flight booking.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the flight schedule.
     */
    public function flightSchedule(): BelongsTo
    {
        return $this->belongsTo(FlightSchedule::class);
    }

    /**
     * Get total passengers.
     */
    public function getTotalPassengersAttribute(): int
    {
        return $this->adults + $this->children + $this->infants;
    }

    /**
     * Get formatted total amount.
     */
    public function getFormattedTotalAmountAttribute(): string
    {
        return '৳' . number_format($this->total_amount, 2);
    }

    /**
     * Get ticket status badge.
     */
    public function getTicketStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'issued' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            'refunded' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
        ];

        $color = $colors[$this->ticket_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        $name = ucfirst($this->ticket_status);

        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>',
            $color,
            $name
        );
    }

    /**
     * Get cabin class badge.
     */
    public function getCabinClassBadgeAttribute(): string
    {
        $colors = [
            'economy' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'business' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
            'first' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
        ];

        $color = $colors[$this->cabin_class] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        $name = ucfirst($this->cabin_class);

        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>',
            $color,
            $name
        );
    }
}