<?php

namespace Modules\Location\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Airport extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'city_id',
        'name',
        'iata_code',
        'icao_code',
        'latitude',
        'longitude',
        'timezone',
        'type',
        'is_active',
        'is_hub',
        'position'
    ];

    protected $casts = [
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
        'is_active' => 'boolean',
        'is_hub' => 'boolean',
        'position' => 'integer',
    ];

    /**
     * Get the country that owns this airport.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the city that owns this airport.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Scope for active airports.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for hub airports.
     */
    public function scopeHub($query)
    {
        return $query->where('is_hub', true);
    }

    /**
     * Scope for international airports.
     */
    public function scopeInternational($query)
    {
        return $query->where('type', 'international');
    }

    /**
     * Scope for domestic airports.
     */
    public function scopeDomestic($query)
    {
        return $query->where('type', 'domestic');
    }

    /**
     * Scope for ordered airports.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('name');
    }

    /**
     * Scope for searching airports by name, IATA code, or city.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhere('iata_code', 'LIKE', "%{$term}%")
              ->orWhereHas('city', function ($cityQuery) use ($term) {
                  $cityQuery->where('name', 'LIKE', "%{$term}%");
              })
              ->orWhereHas('country', function ($countryQuery) use ($term) {
                  $countryQuery->where('name', 'LIKE', "%{$term}%");
              });
        });
    }

    /**
     * Get available airport types.
     */
    public static function getAvailableTypes(): array
    {
        return [
            'international' => 'International',
            'domestic' => 'Domestic',
            'regional' => 'Regional',
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
     * Get type badge color.
     */
    public function getTypeBadgeAttribute()
    {
        $colors = [
            'international' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
            'domestic' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'regional' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
        ];

        $color = $colors[$this->type] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . ucfirst($this->type) . '</span>';
    }

    /**
     * Get hub badge.
     */
    public function getHubBadgeAttribute()
    {
        if (!$this->is_hub) {
            return '';
        }

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100">Hub</span>';
    }

    /**
     * Get full name with city and country.
     */
    public function getFullNameAttribute()
    {
        return $this->name . ' (' . $this->iata_code . '), ' . $this->city->name . ', ' . $this->country->name;
    }

    /**
     * Get display name with IATA code.
     */
    public function getDisplayNameAttribute()
    {
        return $this->name . ' (' . $this->iata_code . ')';
    }
}