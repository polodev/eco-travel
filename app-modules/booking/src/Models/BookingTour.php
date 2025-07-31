<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Tour\Models\Tour;

class BookingTour extends Model
{
    protected $fillable = [
        'booking_id',
        'tour_id',
        'tour_start_date',
        'tour_end_date',
        'adults',
        'children',
        'adult_price',
        'child_price',
        'single_supplement',
        'total_amount',
        'participant_details',
        'accommodation_type',
        'dietary_requirements',
        'medical_conditions',
        'emergency_contacts',
        'special_requests',
        'optional_activities',
        'tour_voucher',
        'booking_status',
        'tour_guide',
        'pickup_details',
        'tour_inclusions',
        'tour_exclusions',
        'what_to_bring',
        'confirmed_at'
    ];

    protected $casts = [
        'adult_price' => 'decimal:2',
        'child_price' => 'decimal:2',
        'single_supplement' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'participant_details' => 'array',
        'dietary_requirements' => 'array',
        'medical_conditions' => 'array',
        'emergency_contacts' => 'array',
        'special_requests' => 'array',
        'optional_activities' => 'array',
        'pickup_details' => 'array',
        'tour_inclusions' => 'array',
        'tour_exclusions' => 'array',
        'what_to_bring' => 'array',
        'tour_start_date' => 'date',
        'tour_end_date' => 'date',
        'confirmed_at' => 'datetime',
        'adults' => 'integer',
        'children' => 'integer'
    ];

    /**
     * Get the booking that owns this tour booking.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the tour.
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Get total participants.
     */
    public function getTotalParticipantsAttribute(): int
    {
        return $this->adults + $this->children;
    }

    /**
     * Get tour duration in days.
     */
    public function getTourDurationAttribute(): int
    {
        return $this->tour_start_date->diffInDays($this->tour_end_date) + 1;
    }

    /**
     * Get formatted total amount.
     */
    public function getFormattedTotalAmountAttribute(): string
    {
        return '৳' . number_format($this->total_amount, 2);
    }

    /**
     * Get formatted adult price.
     */
    public function getFormattedAdultPriceAttribute(): string
    {
        return '৳' . number_format($this->adult_price, 2);
    }

    /**
     * Get booking status badge.
     */
    public function getBookingStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'in_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'completed' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
        ];

        $color = $colors[$this->booking_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        $name = ucwords(str_replace('_', ' ', $this->booking_status));

        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>',
            $color,
            $name
        );
    }

    /**
     * Get accommodation type badge.
     */
    public function getAccommodationTypeBadgeAttribute(): string
    {
        $colors = [
            'shared' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'single' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'twin' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
            'double' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
        ];

        $color = $colors[$this->accommodation_type] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        $name = ucfirst($this->accommodation_type);

        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>',
            $color,
            $name
        );
    }
}