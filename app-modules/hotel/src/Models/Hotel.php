<?php

namespace Modules\Hotel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Location\Models\Country;
use Modules\Location\Models\City;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Hotel extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'country_id',
        'city_id',
        'address',
        'latitude',
        'longitude',
        'phone',
        'email',
        'website',
        'star_rating',
        'amenities',
        'images',
        'checkin_time',
        'checkout_time',
        'policies',
        'is_active',
        'is_featured',
        'average_rating',
        'total_reviews',
        'distance_from_airport',
        'distance_from_city_center',
        'position'
    ];

    protected $casts = [
        'star_rating' => 'integer',
        'amenities' => 'array',
        'images' => 'array',
        'policies' => 'array',
        'checkin_time' => 'datetime:H:i',
        'checkout_time' => 'datetime:H:i',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'average_rating' => 'decimal:2',
        'total_reviews' => 'integer',
        'distance_from_airport' => 'decimal:2',
        'distance_from_city_center' => 'decimal:2',
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
        'position' => 'integer',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the country that owns this hotel.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the city that owns this hotel.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get all rooms for this hotel.
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(HotelRoom::class);
    }

    /**
     * Scope for active hotels.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured hotels.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for ordered hotels.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('name');
    }

    /**
     * Scope by star rating.
     */
    public function scopeByStarRating($query, $rating)
    {
        return $query->where('star_rating', $rating);
    }

    /**
     * Get available amenities.
     */
    public static function getAvailableAmenities(): array
    {
        return [
            'wifi' => 'Free WiFi',
            'pool' => 'Swimming Pool',
            'gym' => 'Fitness Center',
            'spa' => 'Spa',
            'restaurant' => 'Restaurant',
            'bar' => 'Bar',
            'parking' => 'Free Parking',
            'airport_shuttle' => 'Airport Shuttle',
            'room_service' => '24hr Room Service',
            'concierge' => 'Concierge Service',
            'laundry' => 'Laundry Service',
            'business_center' => 'Business Center',
            'conference_room' => 'Conference Room',
            'pet_friendly' => 'Pet Friendly',
            'air_conditioning' => 'Air Conditioning',
        ];
    }

    /**
     * Get star rating options.
     */
    public static function getStarRatingOptions(): array
    {
        return [
            1 => '1 Star',
            2 => '2 Stars',
            3 => '3 Stars',
            4 => '4 Stars',
            5 => '5 Stars',
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
     * Get star rating display.
     */
    public function getStarRatingDisplayAttribute()
    {
        return str_repeat('★', $this->star_rating) . str_repeat('☆', 5 - $this->star_rating);
    }

    /**
     * Get featured badge.
     */
    public function getFeaturedBadgeAttribute()
    {
        if (!$this->is_featured) {
            return '';
        }

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">Featured</span>';
    }

    /**
     * Get rating badge.
     */
    public function getRatingBadgeAttribute()
    {
        if ($this->total_reviews === 0) {
            return '<span class="text-gray-400 text-sm">No ratings</span>';
        }

        $color = $this->average_rating >= 4.0 
            ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
            : ($this->average_rating >= 3.0 
                ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100'
                : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100');

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $this->average_rating . '/5 (' . $this->total_reviews . ')</span>';
    }

    /**
     * Get amenities display.
     */
    public function getAmenitiesDisplayAttribute()
    {
        if (empty($this->amenities)) {
            return '<span class="text-gray-400 text-sm">No amenities listed</span>';
        }

        $availableAmenities = self::getAvailableAmenities();
        $badges = '';
        
        foreach (array_slice($this->amenities, 0, 5) as $amenity) {
            $name = $availableAmenities[$amenity] ?? ucfirst(str_replace('_', ' ', $amenity));
            $badges .= '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 mr-1 mb-1">' 
                      . $name . '</span>';
        }

        if (count($this->amenities) > 5) {
            $badges .= '<span class="text-xs text-gray-500">+' . (count($this->amenities) - 5) . ' more</span>';
        }

        return $badges;
    }

    /**
     * Get rooms count.
     */
    public function getRoomsCountAttribute()
    {
        return $this->rooms()->count();
    }

    /**
     * Get minimum room price.
     */
    public function getMinimumPriceAttribute()
    {
        return $this->rooms()->min('base_price') ?? 0;
    }

    /**
     * Get full address.
     */
    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->city->name . ', ' . $this->country->name;
    }

    /**
     * Get primary image.
     */
    public function getPrimaryImageAttribute()
    {
        return $this->images[0] ?? null;
    }
}