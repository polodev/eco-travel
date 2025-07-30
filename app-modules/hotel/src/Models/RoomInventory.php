<?php

namespace Modules\Hotel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class RoomInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_room_id',
        'date',
        'total_rooms',
        'available_rooms',
        'booked_rooms',
        'blocked_rooms',
        'price',
        'discount_percentage',
        'final_price',
        'is_available',
        'rate_plan',
        'inclusions',
        'minimum_stay',
        'maximum_stay',
        'stop_sell',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'total_rooms' => 'integer',
        'available_rooms' => 'integer',
        'booked_rooms' => 'integer',
        'blocked_rooms' => 'integer',
        'price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'final_price' => 'decimal:2',
        'is_available' => 'boolean',
        'inclusions' => 'array',
        'minimum_stay' => 'integer',
        'maximum_stay' => 'integer',
        'stop_sell' => 'boolean',
    ];

    /**
     * Get the hotel room that owns this inventory.
     */
    public function hotelRoom(): BelongsTo
    {
        return $this->belongsTo(HotelRoom::class);
    }

    /**
     * Scope for available inventory.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)
                    ->where('stop_sell', false)
                    ->where('available_rooms', '>', 0);
    }

    /**
     * Scope for upcoming dates.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString());
    }

    /**
     * Scope for today's inventory.
     */
    public function scopeToday($query)
    {
        return $query->where('date', now()->toDateString());
    }

    /**
     * Scope for date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Get available rate plans.
     */
    public static function getAvailableRatePlans(): array
    {
        return [
            'room_only' => 'Room Only',
            'standard' => 'Standard Rate',
            'breakfast_included' => 'Breakfast Included',
            'half_board' => 'Half Board (Breakfast + Dinner)',
            'full_board' => 'Full Board (All Meals)',
            'all_inclusive' => 'All Inclusive',
        ];
    }

    /**
     * Get available inclusions.
     */
    public static function getAvailableInclusions(): array
    {
        return [
            'breakfast' => 'Breakfast',
            'lunch' => 'Lunch',
            'dinner' => 'Dinner',
            'drinks' => 'Beverages',
            'wifi' => 'Free WiFi',
            'parking' => 'Free Parking',
            'airport_transfer' => 'Airport Transfer',
            'spa_credit' => 'Spa Credit',
            'minibar' => 'Minibar',
            'room_service' => 'Room Service',
        ];
    }

    /**
     * Get availability badge.
     */
    public function getAvailabilityBadgeAttribute()
    {
        if ($this->stop_sell) {
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">Stop Sell</span>';
        }

        if (!$this->is_available) {
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">Unavailable</span>';
        }

        if ($this->available_rooms <= 0) {
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">Sold Out</span>';
        }

        $color = $this->available_rooms > 5 
            ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
            : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100';

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">Available (' . $this->available_rooms . ')</span>';
    }

    /**
     * Get rate plan badge.
     */
    public function getRatePlanBadgeAttribute()
    {
        $colors = [
            'room_only' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100',
            'breakfast_included' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
            'all_inclusive' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
        ];

        $color = $colors[$this->rate_plan] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';
        $name = self::getAvailableRatePlans()[$this->rate_plan] ?? ucfirst(str_replace('_', ' ', $this->rate_plan));

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $name . '</span>';
    }

    /**
     * Get discount badge.
     */
    public function getDiscountBadgeAttribute()
    {
        if ($this->discount_percentage <= 0) {
            return '';
        }

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">' 
               . $this->discount_percentage . '% OFF</span>';
    }

    /**
     * Get price display.
     */
    public function getPriceDisplayAttribute()
    {
        if ($this->discount_percentage > 0) {
            return '<div class="text-sm">
                <span class="line-through text-gray-500">৳' . number_format($this->price, 2) . '</span>
                <span class="text-green-600 font-medium ml-2">৳' . number_format($this->final_price, 2) . '</span>
            </div>';
        }

        return '<span class="font-medium">৳' . number_format($this->final_price, 2) . '</span>';
    }

    /**
     * Get occupancy percentage.
     */
    public function getOccupancyPercentageAttribute()
    {
        if ($this->total_rooms <= 0) {
            return 0;
        }

        return round(($this->booked_rooms / $this->total_rooms) * 100, 2);
    }

    /**
     * Get date formatted.
     */
    public function getDateFormattedAttribute()
    {
        return $this->date->format('M d, Y');
    }

    /**
     * Get stay requirements display.
     */
    public function getStayRequirementsAttribute()
    {
        $requirements = [];
        
        if ($this->minimum_stay > 1) {
            $requirements[] = 'Min ' . $this->minimum_stay . ' nights';
        }
        
        if ($this->maximum_stay) {
            $requirements[] = 'Max ' . $this->maximum_stay . ' nights';
        }

        return empty($requirements) ? 'No restrictions' : implode(', ', $requirements);
    }

    /**
     * Get inclusions display.
     */
    public function getInclusionsDisplayAttribute()
    {
        if (empty($this->inclusions)) {
            return '<span class="text-gray-400 text-sm">No inclusions</span>';
        }

        $availableInclusions = self::getAvailableInclusions();
        $badges = '';
        
        foreach (array_slice($this->inclusions, 0, 3) as $inclusion) {
            $name = $availableInclusions[$inclusion] ?? ucfirst(str_replace('_', ' ', $inclusion));
            $badges .= '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 mr-1 mb-1">' 
                      . $name . '</span>';
        }

        if (count($this->inclusions) > 3) {
            $badges .= '<span class="text-xs text-gray-500">+' . (count($this->inclusions) - 3) . ' more</span>';
        }

        return $badges;
    }

    /**
     * Check if booking is allowed.
     */
    public function isBookingAllowed(): bool
    {
        return $this->is_available 
            && !$this->stop_sell 
            && $this->available_rooms > 0
            && $this->date->isFuture();
    }

    /**
     * Reserve rooms.
     */
    public function reserveRooms(int $quantity): bool
    {
        if ($this->available_rooms < $quantity) {
            return false;
        }

        $this->available_rooms -= $quantity;
        $this->booked_rooms += $quantity;
        
        return $this->save();
    }

    /**
     * Release rooms.
     */
    public function releaseRooms(int $quantity): bool
    {
        $this->available_rooms += $quantity;
        $this->booked_rooms = max(0, $this->booked_rooms - $quantity);
        
        return $this->save();
    }
}