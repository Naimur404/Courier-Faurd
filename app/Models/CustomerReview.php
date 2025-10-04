<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerReview extends Model
{
    protected $table = 'customer_reviews';

    protected $fillable = [
        'phone',
        'commenter_phone',
        'customer_id',
        'name',
        'rating',
        'comment',
    ];

    /**
     * Get the customer that this review belongs to
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Check if this is a report (rating 1-2)
     */
    public function isReport(): bool
    {
        return $this->rating <= 2;
    }

    /**
     * Get the review type
     */
    public function getReviewTypeAttribute(): string
    {
        return match (true) {
            $this->rating == 1 => 'Report/Complaint',
            $this->rating == 2 => 'Poor Review',
            $this->rating == 3 => 'Average Review',
            $this->rating == 4 => 'Good Review',
            $this->rating == 5 => 'Excellent Review',
            default => 'Unknown',
        };
    }

    /**
     * Get formatted phone numbers
     */
    public function getFormattedPhoneAttribute(): string
    {
        return $this->phone;
    }

    public function getFormattedCommenterPhoneAttribute(): string
    {
        return $this->commenter_phone;
    }
}
