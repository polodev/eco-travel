<?php

namespace Modules\Flight\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Location\Models\Country;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Airline extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'code',
        'icao_code',
        'website',
        'headquarters',
        'country_id',
        'founded',
        'alliance',
        'is_active',
        'is_low_cost',
        'operating_countries',
        'position'
    ];

    protected $casts = [
        'founded' => 'integer',
        'is_active' => 'boolean',
        'is_low_cost' => 'boolean',
        'operating_countries' => 'array',
        'position' => 'integer',
    ];

    /**
     * Get the country that owns this airline.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get all flights for this airline.
     */
    public function flights(): HasMany
    {
        return $this->hasMany(Flight::class);
    }

    /**
     * Scope for active airlines.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for low cost airlines.
     */
    public function scopeLowCost($query)
    {
        return $query->where('is_low_cost', true);
    }


    /**
     * Scope for ordered airlines.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('name');
    }

    /**
     * Get available alliances.
     */
    public static function getAvailableAlliances(): array
    {
        return [
            'star_alliance' => 'Star Alliance',
            'oneworld' => 'Oneworld',
            'skyteam' => 'SkyTeam',
            'none' => 'No Alliance',
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
     * Get alliance badge.
     */
    public function getAllianceBadgeAttribute()
    {
        if ($this->alliance === 'none') {
            return '<span class="text-gray-400 text-sm">-</span>';
        }

        $colors = [
            'star_alliance' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
            'oneworld' => 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100',
            'skyteam' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
        ];

        $color = $colors[$this->alliance] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';
        $name = self::getAvailableAlliances()[$this->alliance] ?? ucfirst($this->alliance);

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $name . '</span>';
    }

    /**
     * Get low cost badge.
     */
    public function getLowCostBadgeAttribute()
    {
        if (!$this->is_low_cost) {
            return '';
        }

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">Low Cost</span>';
    }

    /**
     * Get flights count.
     */
    public function getFlightsCountAttribute()
    {
        return $this->flights()->count();
    }

    /**
     * Get full name with code.
     */
    public function getDisplayNameAttribute()
    {
        return $this->name . ' (' . $this->code . ')';
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
    }


    /**
     * Register media conversions.
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10);

        $this->addMediaConversion('medium')
            ->width(300)
            ->height(300)
            ->sharpen(10);
    }

    /**
     * Get the logo URL.
     */
    public function getLogoUrlAttribute()
    {
        return $this->getFirstMediaUrl('logo');
    }

    /**
     * Get the logo thumbnail URL.
     */
    public function getLogoThumbUrlAttribute()
    {
        return $this->getFirstMediaUrl('logo', 'thumb');
    }

    /**
     * Get the logo medium URL.
     */
    public function getLogoMediumUrlAttribute()
    {
        return $this->getFirstMediaUrl('logo', 'medium');
    }

    /**
     * Check if airline has logo.
     */
    public function hasLogo(): bool
    {
        return $this->getMedia('logo')->isNotEmpty();
    }
}