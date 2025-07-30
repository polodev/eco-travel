<?php

namespace Modules\Tour\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class TourDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'start_date',
        'end_date',
        'price_per_person',
        'child_price',
        'single_supplement',
        'available_spots',
        'booked_spots',
        'min_participants',
        'status',
        'tour_guide',
        'seasonal_adjustments',
        'special_offers',
        'special_notes',
        'is_peak_season',
        'is_guaranteed',
        'booking_deadline',
        'cancellation_deadline',
        'deposit_amount',
        'deposit_percentage',
        'weather_info',
        'local_events'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price_per_person' => 'decimal:2',
        'child_price' => 'decimal:2',
        'single_supplement' => 'decimal:2',
        'available_spots' => 'integer',
        'booked_spots' => 'integer',
        'min_participants' => 'integer',
        'seasonal_adjustments' => 'array',
        'special_offers' => 'array',
        'is_peak_season' => 'boolean',
        'is_guaranteed' => 'boolean',
        'booking_deadline' => 'datetime',
        'cancellation_deadline' => 'datetime',
        'deposit_amount' => 'decimal:2',
        'deposit_percentage' => 'integer',
        'weather_info' => 'array',
        'local_events' => 'array',
    ];

    /**
     * Get the tour that owns this date.
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Scope for available dates.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
                    ->where('start_date', '>=', now()->startOfDay());
    }

    /**
     * Scope for upcoming dates.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->startOfDay())
                    ->orderBy('start_date');
    }

    /**
     * Scope for past dates.
     */
    public function scopePast($query)
    {
        return $query->where('end_date', '<', now()->startOfDay())
                    ->orderBy('start_date', 'desc');
    }

    /**
     * Scope for current/ongoing tours.
     */
    public function scopeCurrent($query)
    {
        $now = now()->startOfDay();
        return $query->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now);
    }

    /**
     * Scope for guaranteed departures.
     */
    public function scopeGuaranteed($query)
    {
        return $query->where('is_guaranteed', true);
    }

    /**
     * Scope for peak season.
     */
    public function scopePeakSeason($query)
    {
        return $query->where('is_peak_season', true);
    }

    /**
     * Scope for date range.
     */
    public function scopeDateRange($query, $startDate, $endDate = null)
    {
        $query->where('start_date', '>=', $startDate);
        
        if ($endDate) {
            $query->where('start_date', '<=', $endDate);
        }
        
        return $query;
    }

    /**
     * Get available tour date statuses.
     */
    public static function getAvailableStatuses(): array
    {
        return [
            'available' => 'Available',
            'limited' => 'Limited Spots',
            'fully_booked' => 'Fully Booked',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
        ];
    }

    /**
     * Get status badge.
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'available' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'limited' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
            'fully_booked' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
            'cancelled' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100',
            'completed' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
        ];

        $color = $colors[$this->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';
        $name = self::getAvailableStatuses()[$this->status] ?? ucfirst($this->status);

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $name . '</span>';
    }

    /**
     * Get remaining spots.
     */
    public function getRemainingSpotsAttribute()
    {
        return max(0, $this->available_spots - $this->booked_spots);
    }

    /**
     * Get occupancy percentage.
     */
    public function getOccupancyPercentageAttribute()
    {
        if ($this->available_spots <= 0) {
            return 0;
        }

        return round(($this->booked_spots / $this->available_spots) * 100, 1);
    }

    /**
     * Check if tour date is bookable.
     */
    public function isBookable(): bool
    {
        $now = now();
        
        return $this->status === 'available'
            && $this->start_date->isFuture()
            && $this->remaining_spots > 0
            && (!$this->booking_deadline || $this->booking_deadline->isFuture());
    }

    /**
     * Check if tour date is cancellable.
     */
    public function isCancellable(): bool
    {
        return in_array($this->status, ['available', 'limited'])
            && $this->start_date->isFuture()
            && (!$this->cancellation_deadline || $this->cancellation_deadline->isFuture());
    }

    /**
     * Check if tour is in past.
     */
    public function isPast(): bool
    {
        return $this->end_date->isPast();
    }

    /**
     * Check if tour is current/ongoing.
     */
    public function isCurrent(): bool
    {
        $now = now()->startOfDay();
        return $this->start_date->lte($now) && $this->end_date->gte($now);
    }

    /**
     * Check if tour is upcoming.
     */
    public function isUpcoming(): bool
    {
        return $this->start_date->isFuture();
    }

    /**
     * Get formatted date range.
     */
    public function getFormattedDateRangeAttribute()
    {
        if ($this->start_date->isSameDay($this->end_date)) {
            return $this->start_date->format('M j, Y');
        }

        if ($this->start_date->isSameMonth($this->end_date)) {
            return $this->start_date->format('M j') . ' - ' . $this->end_date->format('j, Y');
        }

        return $this->start_date->format('M j, Y') . ' - ' . $this->end_date->format('M j, Y');
    }

    /**
     * Get tour duration in days.
     */
    public function getDurationDaysAttribute()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    /**
     * Get days until tour starts.
     */
    public function getDaysUntilStartAttribute()
    {
        if ($this->start_date->isPast()) {
            return 0;
        }

        return now()->startOfDay()->diffInDays($this->start_date);
    }

    /**
     * Get discounted price if special offers exist.
     */
    public function getDiscountedPriceAttribute()
    {
        if (!$this->special_offers || empty($this->special_offers)) {
            return $this->price_per_person;
        }

        $price = $this->price_per_person;

        foreach ($this->special_offers as $offer) {
            if (isset($offer['type']) && isset($offer['value'])) {
                if ($offer['type'] === 'percentage') {
                    $price -= ($price * $offer['value'] / 100);
                } elseif ($offer['type'] === 'fixed') {
                    $price -= $offer['value'];
                }
            }
        }

        return max(0, $price);
    }

    /**
     * Get savings amount.
     */
    public function getSavingsAmountAttribute()
    {
        return $this->price_per_person - $this->discounted_price;
    }

    /**
     * Check if there are special offers.
     */
    public function hasSpecialOffers(): bool
    {
        return $this->special_offers && !empty($this->special_offers) && $this->savings_amount > 0;
    }

    /**
     * Update booking spots.
     */
    public function updateBookingSpots(int $spots)
    {
        $this->booked_spots += $spots;
        
        // Update status based on availability
        if ($this->remaining_spots <= 0) {
            $this->status = 'fully_booked';
        } elseif ($this->remaining_spots <= 3) {
            $this->status = 'limited';
        } else {
            $this->status = 'available';
        }
        
        $this->save();
    }

    /**
     * Release booking spots.
     */
    public function releaseBookingSpots(int $spots)
    {
        $this->booked_spots = max(0, $this->booked_spots - $spots);
        
        // Update status based on availability
        if ($this->remaining_spots > 3) {
            $this->status = 'available';
        } elseif ($this->remaining_spots > 0) {
            $this->status = 'limited';
        }
        
        $this->save();
    }
}