<?php

namespace Modules\VisaProcessing\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\User;
use Modules\Payment\Models\Payment;

class VisaApplication extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'visa_processing_id',
        'payment_id',
        'application_number',
        'applicant_name',
        'email',
        'mobile',
        'passport_number',
        'travel_date',
        'customer_notes',
        'application_status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
        'submission_date',
        'completion_date',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'travel_date' => 'date',
        'reviewed_at' => 'datetime',
        'submission_date' => 'datetime',
        'completion_date' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($visaApplication) {
            if (empty($visaApplication->application_number)) {
                $visaApplication->application_number = static::generateApplicationNumber();
            }
        });
    }

    /**
     * Generate unique application number.
     */
    public static function generateApplicationNumber(): string
    {
        do {
            $number = 'VA' . date('Ymd') . rand(1000, 9999);
        } while (static::where('application_number', $number)->exists());

        return $number;
    }

    /**
     * Get the visa processing that owns this application.
     */
    public function visaProcessing(): BelongsTo
    {
        return $this->belongsTo(VisaProcessing::class);
    }

    /**
     * Get the payment for this application.
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Get the user who reviewed this application.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope for applications by status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('application_status', $status);
    }

    /**
     * Scope for pending applications.
     */
    public function scopePending($query)
    {
        return $query->where('application_status', 'pending');
    }

    /**
     * Scope for under review applications.
     */
    public function scopeUnderReview($query)
    {
        return $query->where('application_status', 'under_review');
    }

    /**
     * Scope for approved applications.
     */
    public function scopeApproved($query)
    {
        return $query->where('application_status', 'approved');
    }

    /**
     * Scope for completed applications.
     */
    public function scopeCompleted($query)
    {
        return $query->where('application_status', 'completed');
    }

    /**
     * Get available application statuses.
     */
    public static function getAvailableStatuses(): array
    {
        return [
            'pending' => 'Pending',
            'under_review' => 'Under Review',
            'documents_requested' => 'Documents Requested',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'completed' => 'Completed',
        ];
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
            'under_review' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
            'documents_requested' => 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100',
            'approved' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
            'completed' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100',
        ];

        $color = $colors[$this->application_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . ucfirst($this->application_status ?? 'N/A') . '</span>';
    }

    /**
     * Check if application is pending.
     */
    public function isPending(): bool
    {
        return $this->application_status === 'pending';
    }

    /**
     * Check if application is under review.
     */
    public function isUnderReview(): bool
    {
        return $this->application_status === 'under_review';
    }

    /**
     * Check if application is approved.
     */
    public function isApproved(): bool
    {
        return $this->application_status === 'approved';
    }

    /**
     * Check if application is completed.
     */
    public function isCompleted(): bool
    {
        return $this->application_status === 'completed';
    }

    /**
     * Check if application is rejected.
     */
    public function isRejected(): bool
    {
        return $this->application_status === 'rejected';
    }

    /**
     * Register media collections for document uploads.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('bank_statement')
            ->singleFile()
;

        $this->addMediaCollection('passport')
            ->singleFile()
;

        $this->addMediaCollection('nid_card')
            ->singleFile()
;

        $this->addMediaCollection('trade_licence')
            ->singleFile()
;

        $this->addMediaCollection('tin_certificate')
            ->singleFile()
;

        $this->addMediaCollection('noc')
            ->singleFile()
;
    }

    /**
     * Register media conversions.
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->performOnCollections('passport', 'nid_card')
            ->nonOptimized();
    }

    /**
     * Get all document collections.
     */
    public static function getDocumentCollections(): array
    {
        return [
            'bank_statement' => 'Bank Statement',
            'passport' => 'Passport Copy',
            'nid_card' => 'National ID Card',
            'trade_licence' => 'Trade License',
            'tin_certificate' => 'TIN Certificate',
            'noc' => 'NOC (No Objection Certificate)',
        ];
    }

    /**
     * Check if all required documents are uploaded.
     */
    public function hasAllRequiredDocuments(): bool
    {
        $requiredCollections = ['passport', 'nid_card']; // Basic required documents
        
        foreach ($requiredCollections as $collection) {
            if ($this->getMedia($collection)->isEmpty()) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get uploaded documents count.
     */
    public function getUploadedDocumentsCountAttribute(): int
    {
        $collections = array_keys(static::getDocumentCollections());
        $count = 0;
        
        foreach ($collections as $collection) {
            if ($this->getMedia($collection)->isNotEmpty()) {
                $count++;
            }
        }
        
        return $count;
    }

    /**
     * Get total documents count.
     */
    public function getTotalDocumentsCountAttribute(): int
    {
        return count(static::getDocumentCollections());
    }
}