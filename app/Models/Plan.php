<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'duration_months',
        'request_limit',
        'description',
        'features',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Get subscriptions for this plan
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get active subscriptions for this plan
     */
    public function activeSubscriptions(): HasMany
    {
        return $this->subscriptions()->where('status', 'active');
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return '৳' . number_format($this->price, 0);
    }

    /**
     * Get duration in human readable format
     */
    public function getDurationTextAttribute(): string
    {
        return match($this->duration_months) {
            1 => '১ মাস',
            6 => '৬ মাস',
            12 => '১ বছর',
            default => $this->duration_months . ' মাস'
        };
    }

    /**
     * Scope for active plans
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered plans
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
