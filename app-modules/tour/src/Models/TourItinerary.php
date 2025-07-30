<?php

namespace Modules\Tour\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourItinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'day_number',
        'day_title',
        'day_description',
        'activities',
        'meals_included',
        'accommodation',
        'accommodation_type',
        'accommodation_rating',
        'location',
        'start_time',
        'end_time',
        'transportation',
        'estimated_distance',
        'estimated_duration',
        'optional_activities',
        'meal_options',
        'special_notes',
        'images',
        'is_rest_day',
        'sort_order'
    ];

    protected $casts = [
        'day_number' => 'integer',
        'activities' => 'array',
        'meals_included' => 'array',
        'accommodation_rating' => 'integer',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'transportation' => 'array',
        'estimated_distance' => 'decimal:2',
        'estimated_duration' => 'integer',
        'optional_activities' => 'array',
        'meal_options' => 'array',
        'images' => 'array',
        'is_rest_day' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the tour that owns this itinerary.
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Scope for ordering by day number.
     */
    public function scopeOrderedByDay($query)
    {
        return $query->orderBy('day_number');
    }

    /**
     * Scope for ordering by sort order.
     */
    public function scopeOrderedBySort($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Scope for rest days.
     */
    public function scopeRestDays($query)
    {
        return $query->where('is_rest_day', true);
    }

    /**
     * Scope for activity days.
     */
    public function scopeActivityDays($query)
    {
        return $query->where('is_rest_day', false);
    }

    /**
     * Get available accommodation types.
     */
    public static function getAvailableAccommodationTypes(): array
    {
        return [
            'hotel' => 'Hotel',
            'resort' => 'Resort',
            'guesthouse' => 'Guesthouse',
            'camping' => 'Camping',
            'homestay' => 'Homestay',
            'lodge' => 'Lodge',
            'hostel' => 'Hostel',
            'tent' => 'Tent',
            'boat' => 'Boat/Cruise',
        ];
    }

    /**
     * Get meals included formatted.
     */
    public function getFormattedMealsAttribute()
    {
        if (!$this->meals_included || empty($this->meals_included)) {
            return 'No meals included';
        }

        $meals = [];
        if (in_array('breakfast', $this->meals_included)) {
            $meals[] = 'Breakfast';
        }
        if (in_array('lunch', $this->meals_included)) {
            $meals[] = 'Lunch';
        }
        if (in_array('dinner', $this->meals_included)) {
            $meals[] = 'Dinner';
        }

        return implode(', ', $meals);
    }

    /**
     * Get transportation formatted.
     */
    public function getFormattedTransportationAttribute()
    {
        if (!$this->transportation || empty($this->transportation)) {
            return 'Not specified';
        }

        return is_array($this->transportation) 
            ? implode(', ', $this->transportation)
            : $this->transportation;
    }

    /**
     * Get duration formatted.
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->estimated_duration) {
            return 'Duration not specified';
        }

        $hours = floor($this->estimated_duration / 60);
        $minutes = $this->estimated_duration % 60;

        if ($hours > 0 && $minutes > 0) {
            return $hours . 'h ' . $minutes . 'm';
        } elseif ($hours > 0) {
            return $hours . ' hours';
        } else {
            return $minutes . ' minutes';
        }
    }

    /**
     * Get distance formatted.
     */
    public function getFormattedDistanceAttribute()
    {
        if (!$this->estimated_distance) {
            return 'Distance not specified';
        }

        return $this->estimated_distance . ' km';
    }

    /**
     * Get accommodation with rating formatted.
     */
    public function getFormattedAccommodationAttribute()
    {
        if (!$this->accommodation) {
            return 'Accommodation not specified';
        }

        $formatted = $this->accommodation;
        
        if ($this->accommodation_rating) {
            $formatted .= ' (' . $this->accommodation_rating . '★)';
        }

        if ($this->accommodation_type) {
            $formatted .= ' - ' . ucfirst($this->accommodation_type);
        }

        return $formatted;
    }

    /**
     * Get day type badge.
     */
    public function getDayTypeBadgeAttribute()
    {
        if ($this->is_rest_day) {
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">Rest Day</span>';
        }

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">Activity Day</span>';
    }

    /**
     * Check if day includes breakfast.
     */
    public function includesBreakfast(): bool
    {
        return $this->meals_included && in_array('breakfast', $this->meals_included);
    }

    /**
     * Check if day includes lunch.
     */
    public function includesLunch(): bool
    {
        return $this->meals_included && in_array('lunch', $this->meals_included);
    }

    /**
     * Check if day includes dinner.
     */
    public function includesDinner(): bool
    {
        return $this->meals_included && in_array('dinner', $this->meals_included);
    }

    /**
     * Get activities formatted as list.
     */
    public function getFormattedActivitiesAttribute()
    {
        if (!$this->activities || empty($this->activities)) {
            return [];
        }

        return is_array($this->activities) ? $this->activities : [$this->activities];
    }

    /**
     * Get optional activities formatted as list.
     */
    public function getFormattedOptionalActivitiesAttribute()
    {
        if (!$this->optional_activities || empty($this->optional_activities)) {
            return [];
        }

        return is_array($this->optional_activities) ? $this->optional_activities : [$this->optional_activities];
    }
}