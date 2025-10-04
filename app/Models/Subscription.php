<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'starts_at',
        'ends_at',
        'payment_method',
        'transaction_id',
        'amount_paid',
        'notes',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'amount_paid' => 'decimal:2',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_EXPIRED = 'expired';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get the user who owns the subscription
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan for this subscription
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Check if subscription is active
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE && 
               $this->ends_at->isFuture();
    }

    /**
     * Check if subscription is expired
     */
    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED || 
               ($this->status === self::STATUS_ACTIVE && $this->ends_at->isPast());
    }

    /**
     * Get days remaining
     */
    public function getDaysRemainingAttribute(): int
    {
        if (!$this->isActive()) {
            return 0;
        }
        
        return max(0, Carbon::now()->diffInDays($this->ends_at, false));
    }

    /**
     * Get formatted amount paid
     */
    public function getFormattedAmountAttribute(): string
    {
        return '৳' . number_format($this->amount_paid, 0);
    }

    /**
     * Scope for active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE)
                    ->where('ends_at', '>', now());
    }

    /**
     * Scope for expired subscriptions
     */
    public function scopeExpired($query)
    {
        return $query->where(function($q) {
            $q->where('status', self::STATUS_EXPIRED)
              ->orWhere(function($subQuery) {
                  $subQuery->where('status', self::STATUS_ACTIVE)
                           ->where('ends_at', '<=', now());
              });
        });
    }

    /**
     * Mark subscription as expired
     */
    public function markAsExpired(): void
    {
        $this->update(['status' => self::STATUS_EXPIRED]);
    }

    /**
     * Activate subscription
     */
    public function activate(): void
    {
        $this->update([
            'status' => self::STATUS_ACTIVE,
            'starts_at' => now(),
            'ends_at' => now()->addMonths($this->plan->duration_months),
        ]);
    }
}
