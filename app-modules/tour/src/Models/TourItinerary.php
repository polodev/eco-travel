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
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Rest Day</span>';
        }

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Activity Day</span>';
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

    /**
     * Get meal badge for a specific meal type.
     */
    public static function getMealBadge(string $meal): string
    {
        $colors = [
            'breakfast' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'lunch' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'dinner' => 'bg-purple-100 text-purple-800 dark:bg-indigo-900 dark:text-indigo-200'
        ];
        
        $color = $colors[$meal] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        
        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium %s">%s</span>',
            $color,
            ucfirst($meal)
        );
    }

    /**
     * Get meals badges HTML for multiple meals.
     */
    public function getMealsBadgesAttribute(): string
    {
        $meals = $this->meals_included ?? [];
        if (empty($meals)) {
            return '<span class="text-gray-500 dark:text-gray-400">No meals</span>';
        }
        
        $badges = array_map(function($meal) {
            return self::getMealBadge($meal);
        }, $meals);
        
        return sprintf('<div class="flex flex-wrap gap-1">%s</div>', implode('', $badges));
    }

    /**
     * Get available meal types.
     */
    public static function getAvailableMealTypes(): array
    {
        return [
            'breakfast' => 'Breakfast',
            'lunch' => 'Lunch', 
            'dinner' => 'Dinner'
        ];
    }

    /**
     * Get action buttons HTML for DataTable.
     */
    public function getActionButtonsAttribute(): string
    {
        $viewButton = sprintf(
            '<a href="%s" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200" title="View">%s</a>',
            route('tour::admin.itineraries.show', $this),
            '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>'
        );

        $editButton = sprintf(
            '<a href="%s" class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200" title="Edit">%s</a>',
            route('tour::admin.itineraries.edit', $this),
            '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>'
        );

        return sprintf(
            '<div class="flex items-center justify-center space-x-1">%s%s</div>',
            $viewButton,
            $editButton
        );
    }
}