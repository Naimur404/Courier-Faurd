<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'phone',
        'user_id',
        'subscription_type',
        'subscription_id',
        'count',
        'data',
        'search_by',
        'ip_address',
        'last_searched_at',
    ];

    protected $casts = [
        'data' => 'array',
        'last_searched_at' => 'datetime',
    ];

    /**
     * Get the user who performed this search
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription used for this search
     * This is a polymorphic relationship that can point to either Subscription or WebsiteSubscription
     */
    public function subscription()
    {
        if ($this->subscription_type === 'api') {
            return $this->belongsTo(Subscription::class, 'subscription_id');
        } elseif ($this->subscription_type === 'website') {
            return $this->belongsTo(WebsiteSubscription::class, 'subscription_id');
        }
        
        return null;
    }

    /**
     * Get the API subscription if this search was made with API subscription
     */
    public function apiSubscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    /**
     * Get the website subscription if this search was made with website subscription
     */
    public function websiteSubscription(): BelongsTo
    {
        return $this->belongsTo(WebsiteSubscription::class, 'subscription_id');
    }

    /**
     * Get the reviews for this customer
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(CustomerReview::class);
    }

    /**
     * Get reviews where this customer is the target
     */
    public function reviewsAsTarget(): HasMany
    {
        return $this->hasMany(CustomerReview::class, 'phone', 'phone');
    }

    /**
     * Get formatted JSON data for display
     */
    public function getFormattedDataAttribute(): string
    {
        if (is_array($this->data)) {
            return json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        
        return $this->data ?: 'No data available';
    }

    /**
     * Get courier summary from data
     * Handles both old format (courierData) and new format (data)
     */
    public function getCourierSummaryAttribute(): ?array
    {
        if (!is_array($this->data)) {
            return null;
        }

        // Check for old format with 'courierData' key
        if (isset($this->data['courierData']['summary'])) {
            return $this->data['courierData']['summary'];
        }

        // Check for new format with 'data' key
        if (isset($this->data['data']['summary'])) {
            return $this->data['data']['summary'];
        }
        
        return null;
    }

    /**
     * Get total parcels count
     */
    public function getTotalParcelsAttribute(): int
    {
        $summary = $this->courier_summary;
        return $summary['total_parcel'] ?? 0;
    }

    /**
     * Get success ratio
     */
    public function getSuccessRatioAttribute(): int
    {
        $summary = $this->courier_summary;
        return $summary['success_ratio'] ?? 0;
    }

    /**
     * Get courier services data
     * Handles both old format (courierData) and new format (data)
     */
    public function getCourierServicesAttribute(): array
    {
        if (!is_array($this->data)) {
            return [];
        }

        // Check for old format with 'courierData' key
        if (isset($this->data['courierData'])) {
            $couriers = $this->data['courierData'];
            unset($couriers['summary']); // Remove summary from services list
            return $couriers;
        }

        // Check for new format with 'data' key
        if (isset($this->data['data'])) {
            $couriers = $this->data['data'];
            unset($couriers['summary']); // Remove summary from services list
            return $couriers;
        }
        
        return [];
    }
}
