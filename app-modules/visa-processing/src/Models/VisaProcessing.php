<?php

namespace Modules\VisaProcessing\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;
use App\Models\User;
use Modules\Payment\Models\Payment;

class VisaProcessing extends Model
{
    use HasFactory, HasSlug, HasTranslations;

    protected $fillable = [
        'english_title',
        'slug',
        'title',
        'content',
        'country',
        'visa_type',
        'visa_fees',
        'processing_fee',
        'processing_days',
        'required_documents',
        'meta_title',
        'meta_description',
        'keywords',
        'status',
        'published_at',
        'position',
        'is_featured',
        'estimated_processing_time',
        'embassy_info',
        'difficulty_level',
        'user_id'
    ];

    protected $translatable = [
        'title',
        'content',
        'meta_title',
        'meta_description',
        'keywords'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'position' => 'integer',
        'visa_fees' => 'decimal:2',
        'processing_fee' => 'decimal:2',
        'processing_days' => 'integer',
        'estimated_processing_time' => 'integer',
        'is_featured' => 'boolean',
        'title' => 'array',
        'content' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'keywords' => 'array',
        'required_documents' => 'array',
        'embassy_info' => 'array',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('english_title')
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
     * Scope for published visa processings.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope for draft visa processings.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope for featured visa processings.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope by country.
     */
    public function scopeByCountry($query, string $country)
    {
        return $query->where('country', $country);
    }

    /**
     * Scope by visa type.
     */
    public function scopeByVisaType($query, string $visaType)
    {
        return $query->where('visa_type', $visaType);
    }

    /**
     * Scope by difficulty level.
     */
    public function scopeByDifficulty($query, string $difficulty)
    {
        return $query->where('difficulty_level', $difficulty);
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'published' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
        ];

        $color = $colors[$this->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . ucfirst($this->status ?? 'N/A') . '</span>';
    }

    /**
     * Get difficulty badge color.
     */
    public function getDifficultyBadgeAttribute()
    {
        $colors = [
            'easy' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
            'hard' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
        ];

        $color = $colors[$this->difficulty_level] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . ucfirst($this->difficulty_level ?? 'N/A') . '</span>';
    }

    /**
     * Get total price (visa_fees + processing_fee).
     */
    public function getPriceAttribute()
    {
        return $this->visa_fees + $this->processing_fee;
    }

    /**
     * Get formatted price in BDT.
     */
    public function getFormattedPriceAttribute()
    {
        return '৳ ' . number_format($this->price, 0);
    }

    /**
     * Get formatted total price in BDT (same as formatted_price since price is now total).
     */
    public function getFormattedTotalPriceAttribute()
    {
        return $this->formatted_price;
    }

    /**
     * Get available statuses.
     */
    public static function getAvailableStatuses(): array
    {
        return [
            'draft' => 'Draft',
            'published' => 'Published',
        ];
    }

    /**
     * Get available visa types.
     */
    public static function getAvailableVisaTypes(): array
    {
        return [
            'tourist' => 'Tourist Visa',
            'business' => 'Business Visa',
            'student' => 'Student Visa',
            'work' => 'Work Visa',
            'medical' => 'Medical Visa',
            'transit' => 'Transit Visa',
            'family' => 'Family Visit Visa',
            'other' => 'Other',
        ];
    }

    /**
     * Get available difficulty levels.
     */
    public static function getAvailableDifficultyLevels(): array
    {
        return [
            'easy' => 'Easy',
            'medium' => 'Medium',
            'hard' => 'Hard',
        ];
    }

    /**
     * Get available countries mapping.
     */
    public static function getCountries(): array
    {
        return [
            'australia' => ['name' => __('messages.australia'), 'flag' => '🇦🇺'],
            'thailand' => ['name' => __('messages.thailand'), 'flag' => '🇹🇭'],
            'china' => ['name' => __('messages.china'), 'flag' => '🇨🇳'],
            'japan' => ['name' => __('messages.japan'), 'flag' => '🇯🇵'],
            'singapore' => ['name' => __('messages.singapore'), 'flag' => '🇸🇬'],
            'malaysia' => ['name' => __('messages.malaysia'), 'flag' => '🇲🇾'],
            'indonesia' => ['name' => __('messages.indonesia'), 'flag' => '🇮🇩'],
            'philippines' => ['name' => __('messages.philippines'), 'flag' => '🇵🇭'],
            'vietnam' => ['name' => __('messages.vietnam'), 'flag' => '🇻🇳'],
            'cambodia' => ['name' => __('messages.cambodia'), 'flag' => '🇰🇭'],
            'hong_kong' => ['name' => __('messages.hong_kong'), 'flag' => '🇭🇰'],
            'sri_lanka' => ['name' => __('messages.sri_lanka'), 'flag' => '🇱🇰'],
            'nepal' => ['name' => __('messages.nepal'), 'flag' => '🇳🇵'],
            'india' => ['name' => __('messages.india'), 'flag' => '🇮🇳'],
            'maldives' => ['name' => __('messages.maldives'), 'flag' => '🇲🇻'],
            'united_arab_emirates' => ['name' => __('messages.united_arab_emirates'), 'flag' => '🇦🇪'],
            'qatar' => ['name' => __('messages.qatar'), 'flag' => '🇶🇦'],
            'turkey' => ['name' => __('messages.turkey'), 'flag' => '🇹🇷'],
            'egypt' => ['name' => __('messages.egypt'), 'flag' => '🇪🇬'],
            'morocco' => ['name' => __('messages.morocco'), 'flag' => '🇲🇦'],
            'ethiopia' => ['name' => __('messages.ethiopia'), 'flag' => '🇪🇹'],
            'tanzania' => ['name' => __('messages.tanzania'), 'flag' => '🇹🇿'],
            'kenya' => ['name' => __('messages.kenya'), 'flag' => '🇰🇪'],
            'kazakhstan' => ['name' => __('messages.kazakhstan'), 'flag' => '🇰🇿'],
            'uzbekistan' => ['name' => __('messages.uzbekistan'), 'flag' => '🇺🇿'],
            'kyrgyzstan' => ['name' => __('messages.kyrgyzstan'), 'flag' => '🇰🇬'],
            'south_korea' => ['name' => __('messages.south_korea'), 'flag' => '🇰🇷'],
            'france' => ['name' => __('messages.france'), 'flag' => '🇫🇷'],
            'italy' => ['name' => __('messages.italy'), 'flag' => '🇮🇹'],
            'canada' => ['name' => __('messages.canada'), 'flag' => '🇨🇦'],
            'brunei' => ['name' => __('messages.brunei'), 'flag' => '🇧🇳'],
        ];
    }

    /**
     * Get country key from URL slug.
     */
    public static function getCountryKeyFromSlug(string $slug): ?string
    {
        $slugToKeyMap = [
            'australia' => 'australia',
            'thailand' => 'thailand',
            'china' => 'china',
            'japan' => 'japan',
            'singapore' => 'singapore',
            'malaysia' => 'malaysia',
            'indonesia' => 'indonesia',
            'philippines' => 'philippines',
            'vietnam' => 'vietnam',
            'cambodia' => 'cambodia',
            'hong-kong' => 'hong_kong',
            'sri-lanka' => 'sri_lanka',
            'nepal' => 'nepal',
            'india' => 'india',
            'maldives' => 'maldives',
            'united-arab-emirates' => 'united_arab_emirates',
            'qatar' => 'qatar',
            'turkey' => 'turkey',
            'egypt' => 'egypt',
            'morocco' => 'morocco',
            'ethiopia' => 'ethiopia',
            'tanzania' => 'tanzania',
            'kenya' => 'kenya',
            'kazakhstan' => 'kazakhstan',
            'uzbekistan' => 'uzbekistan',
            'kyrgyzstan' => 'kyrgyzstan',
            'south-korea' => 'south_korea',
            'france' => 'france',
            'italy' => 'italy',
            'canada' => 'canada',
            'brunei' => 'brunei',
        ];

        return $slugToKeyMap[$slug] ?? null;
    }

    /**
     * Get URL slug from country key.
     */
    public static function getSlugFromCountryKey(string $countryKey): string
    {
        $keyToSlugMap = [
            'australia' => 'australia',
            'thailand' => 'thailand',
            'china' => 'china',
            'japan' => 'japan',
            'singapore' => 'singapore',
            'malaysia' => 'malaysia',
            'indonesia' => 'indonesia',
            'philippines' => 'philippines',
            'vietnam' => 'vietnam',
            'cambodia' => 'cambodia',
            'hong_kong' => 'hong-kong',
            'sri_lanka' => 'sri-lanka',
            'nepal' => 'nepal',
            'india' => 'india',
            'maldives' => 'maldives',
            'united_arab_emirates' => 'united-arab-emirates',
            'qatar' => 'qatar',
            'turkey' => 'turkey',
            'egypt' => 'egypt',
            'morocco' => 'morocco',
            'ethiopia' => 'ethiopia',
            'tanzania' => 'tanzania',
            'kenya' => 'kenya',
            'kazakhstan' => 'kazakhstan',
            'uzbekistan' => 'uzbekistan',
            'kyrgyzstan' => 'kyrgyzstan',
            'south_korea' => 'south-korea',
            'france' => 'france',
            'italy' => 'italy',
            'canada' => 'canada',
            'brunei' => 'brunei',
        ];

        return $keyToSlugMap[$countryKey] ?? $countryKey;
    }

    /**
     * Get country URL slug attribute.
     */
    public function getCountrySlugAttribute(): string
    {
        return static::getSlugFromCountryKey($this->country);
    }

    /**
     * Check if visa processing is published and live.
     */
    public function isLive(): bool
    {
        return $this->status === 'published' 
               && $this->published_at !== null 
               && $this->published_at <= now();
    }

    /**
     * Get the user that created this visa processing.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get payments for this visa processing.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'visa_processing_id');
    }

    /**
     * Get country name using translation.
     */
    public function getCountryNameAttribute()
    {
        return __('messages.' . $this->country);
    }

    /**
     * Get country flag emoji.
     */
    public function getCountryFlagAttribute()
    {
        $countries = static::getCountries();
        return $countries[$this->country]['flag'] ?? '🌍';
    }
}