<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'phone',
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
     */
    public function getCourierSummaryAttribute(): ?array
    {
        if (is_array($this->data) && isset($this->data['courierData']['summary'])) {
            return $this->data['courierData']['summary'];
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
     */
    public function getCourierServicesAttribute(): array
    {
        if (is_array($this->data) && isset($this->data['courierData'])) {
            $couriers = $this->data['courierData'];
            unset($couriers['summary']); // Remove summary from services list
            return $couriers;
        }
        
        return [];
    }
}
