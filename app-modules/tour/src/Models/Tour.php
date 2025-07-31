<?php

namespace Modules\Tour\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Location\Models\Country;
use Modules\Location\Models\City;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tour extends Model implements HasMedia
{
    use HasFactory, HasSlug, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'detailed_description',
        'country_id',
        'city_id',
        'duration_days',
        'duration_nights',
        'difficulty_level',
        'tour_type',
        'min_group_size',
        'max_group_size',
        'base_price',
        'child_price',
        'single_supplement',
        'included_services',
        'excluded_services',
        'amenities',
        'age_restrictions',
        'physical_requirements',
        'what_to_bring',
        'meeting_point',
        'meeting_time',
        'cancellation_policy',
        'images',
        'featured_image',
        'rating',
        'total_reviews',
        'is_featured',
        'is_active',
        'availability_status',
        'tour_operator',
        'contact_person',
        'contact_phone',
        'contact_email',
        'pickup_locations',
        'languages',
        'special_notes'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'child_price' => 'decimal:2',
        'single_supplement' => 'decimal:2',
        'included_services' => 'array',
        'excluded_services' => 'array',
        'amenities' => 'array',
        'age_restrictions' => 'array',
        'physical_requirements' => 'array',
        'what_to_bring' => 'array',
        'meeting_time' => 'datetime',
        'cancellation_policy' => 'array',
        'images' => 'array',
        'rating' => 'decimal:1',
        'total_reviews' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'pickup_locations' => 'array',
        'languages' => 'array',
        'duration_days' => 'integer',
        'duration_nights' => 'integer',
        'min_group_size' => 'integer',
        'max_group_size' => 'integer',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Get the country where this tour takes place.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the city where this tour takes place.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the tour itineraries.
     */
    public function itineraries(): HasMany
    {
        return $this->hasMany(TourItinerary::class)->orderBy('day_number');
    }


    /**
     * Scope for active tours.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured tours.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for tour type.
     */
    public function scopeType($query, $type)
    {
        return $query->where('tour_type', $type);
    }

    /**
     * Scope for difficulty level.
     */
    public function scopeDifficulty($query, $level)
    {
        return $query->where('difficulty_level', $level);
    }

    /**
     * Scope for duration range.
     */
    public function scopeDuration($query, $minDays, $maxDays = null)
    {
        $query->where('duration_days', '>=', $minDays);
        
        if ($maxDays) {
            $query->where('duration_days', '<=', $maxDays);
        }
        
        return $query;
    }

    /**
     * Scope for price range.
     */
    public function scopePriceRange($query, $minPrice, $maxPrice = null)
    {
        $query->where('base_price', '>=', $minPrice);
        
        if ($maxPrice) {
            $query->where('base_price', '<=', $maxPrice);
        }
        
        return $query;
    }

    /**
     * Get available tour types.
     */
    public static function getAvailableTourTypes(): array
    {
        return [
            'cultural' => 'Cultural',
            'adventure' => 'Adventure',
            'wildlife' => 'Wildlife',
            'historical' => 'Historical',
            'religious' => 'Religious',
            'beach' => 'Beach',
            'city' => 'City Tour',
            'nature' => 'Nature',
        ];
    }

    /**
     * Get available difficulty levels.
     */
    public static function getAvailableDifficultyLevels(): array
    {
        return [
            'easy' => 'Easy',
            'moderate' => 'Moderate',
            'challenging' => 'Challenging',
            'expert' => 'Expert',
        ];
    }

    /**
     * Get available availability statuses.
     */
    public static function getAvailableStatuses(): array
    {
        return [
            'available' => 'Available',
            'limited' => 'Limited Availability',
            'sold_out' => 'Sold Out',
            'suspended' => 'Suspended',
        ];
    }

    /**
     * Get tour type badge.
     */
    public function getTourTypeBadgeAttribute()
    {
        $colors = [
            'cultural' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
            'adventure' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            'wildlife' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'historical' => 'bg-brown-100 text-brown-800 dark:bg-brown-900 dark:text-brown-200',
            'religious' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'beach' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-200',
            'city' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200',
            'nature' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
        ];

        $color = $colors[$this->tour_type] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        $name = self::getAvailableTourTypes()[$this->tour_type] ?? ucfirst($this->tour_type);

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $name . '</span>';
    }

    /**
     * Get difficulty badge.
     */
    public function getDifficultyBadgeAttribute()
    {
        $colors = [
            'easy' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'moderate' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'challenging' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
            'expert' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
        ];

        $color = $colors[$this->difficulty_level] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        $name = self::getAvailableDifficultyLevels()[$this->difficulty_level] ?? ucfirst($this->difficulty_level);

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $name . '</span>';
    }

    /**
     * Get availability status badge.
     */
    public function getAvailabilityBadgeAttribute()
    {
        $colors = [
            'available' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'limited' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'sold_out' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            'suspended' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200',
        ];

        $color = $colors[$this->availability_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        $name = self::getAvailableStatuses()[$this->availability_status] ?? ucfirst($this->availability_status);

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $name . '</span>';
    }

    /**
     * Get tour duration formatted.
     */
    public function getFormattedDurationAttribute()
    {
        if ($this->duration_nights > 0) {
            return $this->duration_days . ' Days / ' . $this->duration_nights . ' Nights';
        }
        
        return $this->duration_days . ' Days';
    }

    /**
     * Check if tour has availability.
     */
    public function hasAvailability(): bool
    {
        return $this->is_active 
            && $this->availability_status !== 'suspended';
    }

    /**
     * Get tour rating stars.
     */
    public function getRatingStarsAttribute()
    {
        $fullStars = floor($this->rating);
        $halfStar = ($this->rating - $fullStars) >= 0.5 ? 1 : 0;
        $emptyStars = 5 - $fullStars - $halfStar;

        $stars = str_repeat('★', $fullStars);
        if ($halfStar) {
            $stars .= '☆';
        }
        $stars .= str_repeat('☆', $emptyStars);

        return $stars;
    }
}