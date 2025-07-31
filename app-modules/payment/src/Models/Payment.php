<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Booking\Models\Booking;
use App\Models\User;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'custom_payment_id',
        'amount',
        'status',
        'payment_method',
        'transaction_id',
        'gateway_payment_id',
        'gateway_response',
        'gateway_reference',
        'payment_date',
        'processed_at',
        'failed_at',
        'refunded_at',
        'notes',
        'receipt_number',
        'payment_details'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
        'payment_details' => 'array',
        'payment_date' => 'datetime',
        'processed_at' => 'datetime',
        'failed_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    /**
     * Get the booking that owns this payment.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the custom payment that owns this payment.
     */
    public function customPayment(): BelongsTo
    {
        return $this->belongsTo(CustomPayment::class);
    }

    /**
     * Scope for payments by status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for completed payments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for pending payments.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for failed payments.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope for booking payments.
     */
    public function scopeForBookings($query)
    {
        return $query->whereNotNull('booking_id');
    }

    /**
     * Scope for custom payments.
     */
    public function scopeForCustomPayments($query)
    {
        return $query->whereNotNull('custom_payment_id');
    }

    /**
     * Get available payment methods.
     */
    public static function getAvailablePaymentMethods(): array
    {
        return [
            'sslcommerz' => 'SSLCommerz',
            'bkash' => 'bKash',
            'nagad' => 'Nagad',
            'city_bank' => 'City Bank Gateway',
            'brac_bank' => 'BRAC Bank Gateway',
            'bank_transfer' => 'Bank Transfer',
            'cash' => 'Cash Payment',
            'other' => 'Other'
        ];
    }

    /**
     * Get available payment statuses.
     */
    public static function getAvailableStatuses(): array
    {
        return [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'failed' => 'Failed',
            'cancelled' => 'Cancelled',
            'refunded' => 'Refunded'
        ];
    }

    /**
     * Get payment status badge.
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'failed' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            'cancelled' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200',
            'refunded' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
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
     * Get payment method badge.
     */
    public function getPaymentMethodBadgeAttribute(): string
    {
        if (!$this->payment_method) {
            return '<span class="text-gray-500 dark:text-gray-400">Not specified</span>';
        }

        $colors = [
            'sslcommerz' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'bkash' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200',
            'nagad' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
            'city_bank' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
            'brac_bank' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        ];

        $color = $colors[$this->payment_method] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        $name = self::getAvailablePaymentMethods()[$this->payment_method] ?? ucfirst($this->payment_method);

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
     * Check if payment is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if payment is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment is failed.
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Check if payment is refunded.
     */
    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }
}