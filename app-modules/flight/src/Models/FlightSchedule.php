<?php

namespace Modules\Flight\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class FlightSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_id',
        'flight_date',
        'scheduled_departure',
        'scheduled_arrival',
        'actual_departure',
        'actual_arrival',
        'status',
        'delay_minutes',
        'gate',
        'terminal',
        'economy_price',
        'business_price',
        'first_price',
        'available_economy_seats',
        'available_business_seats',
        'available_first_seats',
        'booked_seats',
        'is_available_for_booking',
        'meal_options',
        'notes'
    ];

    protected $casts = [
        'flight_date' => 'date',
        'scheduled_departure' => 'datetime',
        'scheduled_arrival' => 'datetime',
        'actual_departure' => 'datetime',
        'actual_arrival' => 'datetime',
        'delay_minutes' => 'integer',
        'economy_price' => 'decimal:2',
        'business_price' => 'decimal:2',
        'first_price' => 'decimal:2',
        'available_economy_seats' => 'integer',
        'available_business_seats' => 'integer',
        'available_first_seats' => 'integer',
        'booked_seats' => 'integer',
        'is_available_for_booking' => 'boolean',
        'meal_options' => 'array',
    ];

    /**
     * Get the flight that owns this schedule.
     */
    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }

    /**
     * Scope for available schedules.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available_for_booking', true);
    }

    /**
     * Scope for upcoming schedules.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('flight_date', '>=', now()->toDateString());
    }

    /**
     * Scope for today's schedules.
     */
    public function scopeToday($query)
    {
        return $query->where('flight_date', now()->toDateString());
    }

    /**
     * Scope for scheduled status.
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Scope for delayed status.
     */
    public function scopeDelayed($query)
    {
        return $query->where('status', 'delayed');
    }

    /**
     * Scope for cancelled status.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Get available statuses.
     */
    public static function getAvailableStatuses(): array
    {
        return [
            'scheduled' => 'Scheduled',
            'delayed' => 'Delayed',
            'cancelled' => 'Cancelled',
            'departed' => 'Departed',
            'arrived' => 'Arrived',
            'diverted' => 'Diverted',
        ];
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'scheduled' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'delayed' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
            'departed' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
            'arrived' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100',
            'diverted' => 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100',
        ];

        $color = $colors[$this->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';
        $name = self::getAvailableStatuses()[$this->status] ?? ucfirst($this->status);

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $name . '</span>';
    }

    /**
     * Get delay badge.
     */
    public function getDelayBadgeAttribute()
    {
        if ($this->delay_minutes <= 0) {
            return '';
        }

        $color = $this->delay_minutes > 60 
            ? 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100'
            : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100';

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">+' 
               . $this->delay_minutes . 'min</span>';
    }

    /**
     * Get availability badge.
     */
    public function getAvailabilityBadgeAttribute()
    {
        $color = $this->is_available_for_booking
            ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
            : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100';

        $status = $this->is_available_for_booking ? 'Available' : 'Not Available';

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $status . '</span>';
    }

    /**
     * Get total available seats.
     */
    public function getTotalAvailableSeatsAttribute()
    {
        return $this->available_economy_seats + $this->available_business_seats + $this->available_first_seats;
    }

    /**
     * Get occupancy percentage.
     */
    public function getOccupancyPercentageAttribute()
    {
        $totalSeats = $this->flight->total_seats;
        if ($totalSeats <= 0) {
            return 0;
        }

        return round(($this->booked_seats / $totalSeats) * 100, 2);
    }

    /**
     * Check if flight is full.
     */
    public function isFullAttribute()
    {
        return $this->total_available_seats <= 0;
    }

    /**
     * Get formatted departure time.
     */
    public function getDepartureTimeFormattedAttribute()
    {
        return $this->scheduled_departure->format('H:i');
    }

    /**
     * Get formatted arrival time.
     */
    public function getArrivalTimeFormattedAttribute()
    {
        return $this->scheduled_arrival->format('H:i');
    }

    /**
     * Get formatted flight date.
     */
    public function getFlightDateFormattedAttribute()
    {
        return $this->flight_date->format('M d, Y');
    }

    /**
     * Get time until departure.
     */
    public function getTimeUntilDepartureAttribute()
    {
        $now = now();
        $departure = $this->scheduled_departure;

        if ($departure->isPast()) {
            return 'Departed';
        }

        $diff = $now->diffInHours($departure);
        
        if ($diff < 24) {
            return $now->diffForHumans($departure);
        }

        return $departure->format('M d, H:i');
    }

    /**
     * Check if booking is allowed.
     */
    public function isBookingAllowed(): bool
    {
        return $this->is_available_for_booking 
            && $this->status === 'scheduled' 
            && $this->total_available_seats > 0
            && $this->scheduled_departure->isFuture();
    }
}