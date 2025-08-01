<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CustomPayment extends Model
{
    use LogsActivity;
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'amount',
        'purpose',
        'description',
        'reference_number',
        'payment_method',
        'status',
        'form_data',
        'ip_address',
        'user_agent',
        'admin_notes',
        'user_id',
        'processed_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'form_data' => 'array',
    ];

    /**
     * Get the payments for this custom payment.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the user who created this custom payment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the admin who processed this payment.
     */
    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Scope for payments by status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for submitted payments.
     */
    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    /**
     * Scope for processing payments.
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    /**
     * Scope for completed payments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for cancelled payments.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Get available statuses.
     */
    public static function getAvailableStatuses(): array
    {
        return [
            'submitted' => 'Submitted',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];
    }

    /**
     * Get status badge.
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'submitted' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'processing' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
        ];

        $color = $colors[$this->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        $name = self::getAvailableStatuses()[$this->status] ?? ucfirst($this->status);

        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>',
            $color,
            $name
        );
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return '৳' . number_format($this->amount, 2);
    }

    /**
     * Get total paid amount from associated payments.
     */
    public function getTotalPaidAttribute(): float
    {
        return (float) $this->payments()->completed()->sum('amount');
    }

    /**
     * Get remaining amount.
     */
    public function getRemainingAmountAttribute(): float
    {
        return (float) ($this->amount - $this->total_paid);
    }

    /**
     * Get formatted total paid.
     */
    public function getFormattedTotalPaidAttribute(): string
    {
        return '৳' . number_format($this->total_paid, 2);
    }

    /**
     * Get formatted remaining amount.
     */
    public function getFormattedRemainingAmountAttribute(): string
    {
        return '৳' . number_format($this->remaining_amount, 2);
    }

    /**
     * Check if payment is fully paid.
     */
    public function isFullyPaid(): bool
    {
        return $this->remaining_amount <= 0;
    }

    /**
     * Check if payment is partially paid.
     */
    public function isPartiallyPaid(): bool
    {
        return $this->total_paid > 0 && $this->remaining_amount > 0;
    }

    /**
     * Check if payment is submitted.
     */
    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    /**
     * Check if payment is processing.
     */
    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    /**
     * Check if payment is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if payment is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Configure activity logging.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'email', 
                'mobile',
                'amount',
                'purpose',
                'description',
                'reference_number',
                'status',
                'admin_notes'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at']);
    }

    /**
     * Determine if the given event should be logged.
     */
    public function shouldLogEvent(string $eventName): bool
    {
        return in_array($eventName, ['updated', 'deleted']);
    }

    /**
     * Get description for activity log.
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        $customerInfo = $this->name;
        if ($this->reference_number) {
            $customerInfo .= " (Ref: {$this->reference_number})";
        }

        return match($eventName) {
            'created' => "Custom payment request of {$this->formatted_amount} created for {$customerInfo}",
            'updated' => "Custom payment request #{$this->id} updated for {$customerInfo}",
            'deleted' => "Custom payment request #{$this->id} deleted for {$customerInfo}",
            default => "Custom payment {$eventName} for {$customerInfo}"
        };
    }
}