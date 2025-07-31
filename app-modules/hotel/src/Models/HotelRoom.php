<?php

namespace Modules\Hotel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HotelRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'room_type',
        'name',
        'description',
        'max_occupancy',
        'max_adults',
        'max_children',
        'room_size',
        'bed_type',
        'bed_count',
        'amenities',
        'images',
        'base_price',
        'is_active',
        'is_refundable',
        'cancellation_policy',
        'total_rooms',
        'position'
    ];

    protected $casts = [
        'max_occupancy' => 'integer',
        'max_adults' => 'integer',
        'max_children' => 'integer',
        'room_size' => 'decimal:2',
        'bed_count' => 'integer',
        'amenities' => 'array',
        'images' => 'array',
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_refundable' => 'boolean',
        'cancellation_policy' => 'array',
        'total_rooms' => 'integer',
        'position' => 'integer',
    ];

    /**
     * Get the hotel that owns this room.
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Get all inventories for this room.
     */
    public function inventories(): HasMany
    {
        return $this->hasMany(RoomInventory::class);
    }

    /**
     * Scope for active rooms.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for refundable rooms.
     */
    public function scopeRefundable($query)
    {
        return $query->where('is_refundable', true);
    }

    /**
     * Scope for ordered rooms.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('base_price');
    }

    /**
     * Get available room types.
     */
    public static function getAvailableRoomTypes(): array
    {
        return [
            'standard' => 'Standard Room',
            'deluxe' => 'Deluxe Room',
            'suite' => 'Suite',
            'junior_suite' => 'Junior Suite',
            'executive' => 'Executive Room',
            'presidential' => 'Presidential Suite',
            'penthouse' => 'Penthouse',
            'villa' => 'Villa',
        ];
    }

    /**
     * Get available bed types.
     */
    public static function getAvailableBedTypes(): array
    {
        return [
            'single' => 'Single Bed',
            'double' => 'Double Bed',
            'queen' => 'Queen Bed',
            'king' => 'King Bed',
            'twin' => 'Twin Beds',
            'sofa_bed' => 'Sofa Bed',
        ];
    }

    /**
     * Get available room amenities.
     */
    public static function getAvailableAmenities(): array
    {
        return [
            'ac' => 'Air Conditioning',
            'tv' => 'Flat Screen TV',
            'wifi' => 'Free WiFi',
            'minibar' => 'Minibar',
            'safe' => 'In-room Safe',
            'balcony' => 'Private Balcony',
            'sea_view' => 'Sea View',
            'city_view' => 'City View',
            'mountain_view' => 'Mountain View',
            'garden_view' => 'Garden View',
            'bathtub' => 'Bathtub',
            'shower' => 'Private Shower',
            'hairdryer' => 'Hair Dryer',
            'iron' => 'Iron & Ironing Board',
            'coffee_maker' => 'Coffee/Tea Maker',
            'desk' => 'Work Desk',
            'sofa' => 'Seating Area',
            'kitchenette' => 'Kitchenette',
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
     * Get room type badge.
     */
    public function getRoomTypeBadgeAttribute()
    {
        $colors = [
            'standard' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
            'deluxe' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'suite' => 'bg-violet-100 text-violet-800 dark:bg-violet-900 dark:text-violet-200',
            'junior_suite' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
            'executive' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
            'presidential' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'penthouse' => 'bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-200',
            'villa' => 'bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-200',
        ];

        $color = $colors[$this->room_type] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
        $name = self::getAvailableRoomTypes()[$this->room_type] ?? ucfirst($this->room_type);

        return '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ' . $color . '">' 
               . $name . '</span>';
    }

    /**
     * Get refundable badge.
     */
    public function getRefundableBadgeAttribute()
    {
        $color = $this->is_refundable
            ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
            : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100';

        $status = $this->is_refundable ? 'Refundable' : 'Non-refundable';

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $status . '</span>';
    }

    /**
     * Get occupancy display.
     */
    public function getOccupancyDisplayAttribute()
    {
        $display = $this->max_adults . ' Adult';
        if ($this->max_adults > 1) $display .= 's';
        
        if ($this->max_children > 0) {
            $display .= ', ' . $this->max_children . ' Child';
            if ($this->max_children > 1) $display .= 'ren';
        }

        return $display;
    }

    /**
     * Get bed display.
     */
    public function getBedDisplayAttribute()
    {
        $bedType = self::getAvailableBedTypes()[$this->bed_type] ?? ucfirst($this->bed_type);
        
        if ($this->bed_count > 1) {
            return $this->bed_count . ' ' . $bedType . 's';
        }

        return $bedType;
    }

    /**
     * Get amenities display.
     */
    public function getAmenitiesDisplayAttribute()
    {
        if (empty($this->amenities)) {
            return '<span class="text-gray-400 text-sm">No amenities</span>';
        }

        $availableAmenities = self::getAvailableAmenities();
        $badges = '<div class="flex flex-wrap gap-1">';
        
        // Show top 3 amenities with better styling
        foreach (array_slice($this->amenities, 0, 3) as $amenity) {
            $name = $availableAmenities[$amenity] ?? ucfirst(str_replace('_', ' ', $amenity));
            $badges .= '<span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900 dark:text-blue-200 border border-blue-200 dark:border-blue-700">' 
                      . $name . '</span>';
        }

        if (count($this->amenities) > 3) {
            $badges .= '<span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-50 text-gray-600 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">+' . (count($this->amenities) - 3) . ' more</span>';
        }
        
        $badges .= '</div>';

        return $badges;
    }

    /**
     * Get room size display.
     */
    public function getRoomSizeDisplayAttribute()
    {
        return $this->room_size ? $this->room_size . ' m²' : 'Size not specified';
    }

    /**
     * Get inventories count.
     */
    public function getInventoriesCountAttribute()
    {
        return $this->inventories()->count();
    }

    /**
     * Get primary image.
     */
    public function getPrimaryImageAttribute()
    {
        return $this->images[0] ?? null;
    }

    /**
     * Get availability for a specific date.
     */
    public function getAvailabilityForDate($date)
    {
        return $this->inventories()->where('date', $date)->first();
    }
}