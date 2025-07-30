<?php

namespace Modules\Flight\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Location\Models\Airport;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'airline_id',
        'flight_number',
        'departure_airport_id',
        'arrival_airport_id',
        'departure_time',
        'arrival_time',
        'duration_minutes',
        'aircraft_type',
        'operating_days',
        'flight_type',
        'is_active',
        'has_meal',
        'has_wifi',
        'has_entertainment',
        'baggage_allowance',
        'base_price',
        'total_seats',
        'economy_seats',
        'business_seats',
        'first_seats',
        'position'
    ];

    protected $casts = [
        'departure_time' => 'datetime:H:i',
        'arrival_time' => 'datetime:H:i',
        'duration_minutes' => 'integer',
        'operating_days' => 'array',
        'is_active' => 'boolean',
        'has_meal' => 'boolean',
        'has_wifi' => 'boolean',
        'has_entertainment' => 'boolean',
        'baggage_allowance' => 'array',
        'base_price' => 'decimal:2',
        'total_seats' => 'integer',
        'economy_seats' => 'integer',
        'business_seats' => 'integer',
        'first_seats' => 'integer',
        'position' => 'integer',
    ];

    /**
     * Get the airline that owns this flight.
     */
    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }

    /**
     * Get the departure airport.
     */
    public function departureAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id');
    }

    /**
     * Get the arrival airport.
     */
    public function arrivalAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'arrival_airport_id');
    }

    /**
     * Get all schedules for this flight.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(FlightSchedule::class);
    }

    /**
     * Scope for active flights.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for domestic flights.
     */
    public function scopeDomestic($query)
    {
        return $query->where('flight_type', 'domestic');
    }

    /**
     * Scope for international flights.
     */
    public function scopeInternational($query)
    {
        return $query->where('flight_type', 'international');
    }

    /**
     * Scope for ordered flights.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('flight_number');
    }

    /**
     * Get available flight types.
     */
    public static function getAvailableFlightTypes(): array
    {
        return [
            'domestic' => 'Domestic',
            'international' => 'International',
            'regional' => 'Regional',
        ];
    }

    /**
     * Get available aircraft types.
     */
    public static function getAvailableAircraftTypes(): array
    {
        return [
            'boeing_737' => 'Boeing 737',
            'boeing_777' => 'Boeing 777',
            'airbus_a320' => 'Airbus A320',
            'airbus_a330' => 'Airbus A330',
            'dash_8' => 'Dash 8',
            'atr_72' => 'ATR 72',
            'other' => 'Other',
        ];
    }

    /**
     * Get available operating days.
     */
    public static function getAvailableOperatingDays(): array
    {
        return [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday',
        ];
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeAttribute()
    {
        $color = $this->is_active 
            ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
            : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100';

        $status = $this->is_active ? 'Active' : 'Inactive';

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $status . '</span>';
    }

    /**
     * Get flight type badge.
     */
    public function getFlightTypeBadgeAttribute()
    {
        $colors = [
            'domestic' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'international' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
            'regional' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
        ];

        $color = $colors[$this->flight_type] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . ucfirst($this->flight_type) . '</span>';
    }

    /**
     * Get amenities badges.
     */
    public function getAmenitiesBadgesAttribute()
    {
        $badges = '';
        
        if ($this->has_meal) {
            $badges .= '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100 mr-1">Meal</span>';
        }
        
        if ($this->has_wifi) {
            $badges .= '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 mr-1">WiFi</span>';
        }
        
        if ($this->has_entertainment) {
            $badges .= '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100 mr-1">Entertainment</span>';
        }

        return $badges ?: '<span class="text-gray-400 text-sm">-</span>';
    }

    /**
     * Get full flight number with airline code.
     */
    public function getFullFlightNumberAttribute()
    {
        return $this->airline->code . $this->flight_number;
    }

    /**
     * Get route display.
     */
    public function getRouteDisplayAttribute()
    {
        return $this->departureAirport->iata_code . ' → ' . $this->arrivalAirport->iata_code;
    }

    /**
     * Get duration display.
     */
    public function getDurationDisplayAttribute()
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        return $hours . 'h ' . $minutes . 'm';
    }

    /**
     * Get operating days display.
     */
    public function getOperatingDaysDisplayAttribute()
    {
        if (empty($this->operating_days)) {
            return 'No days set';
        }

        $days = array_map(function($day) {
            return ucfirst(substr($day, 0, 3));
        }, $this->operating_days);

        return implode(', ', $days);
    }

    /**
     * Get schedules count.
     */
    public function getSchedulesCountAttribute()
    {
        return $this->schedules()->count();
    }
}