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
        'expires_at', // Changed from ends_at to match migration
        'activated_at',
        'payment_method',
        'transaction_id',
        'amount_paid',
        'admin_notes', // Changed from notes to match migration
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime', // Changed from ends_at
        'activated_at' => 'datetime',
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
     * Get the API keys for the subscription user
     */
    public function userApiKeys()
    {
        return $this->hasMany(ApiKey::class, 'user_id', 'user_id');
    }

    /**
     * Check if subscription is active
     */
    public function isActive(): bool
    {
        if ($this->status !== self::STATUS_ACTIVE || !$this->expires_at) {
            return false;
        }
        
        $expiresAt = $this->expires_at instanceof Carbon 
            ? $this->expires_at 
            : Carbon::parse($this->expires_at);
            
        return $expiresAt->isFuture();
    }

    /**
     * Check if subscription is expired
     */
    public function isExpired(): bool
    {
        if ($this->status === self::STATUS_EXPIRED) {
            return true;
        }
        
        if ($this->status === self::STATUS_ACTIVE && $this->expires_at) {
            $expiresAt = $this->expires_at instanceof Carbon 
                ? $this->expires_at 
                : Carbon::parse($this->expires_at);
                
            return $expiresAt->isPast();
        }
        
        return false;
    }

    /**
     * Get days remaining
     */
    public function getDaysRemainingAttribute(): int
    {
        if (!$this->isActive() || !$this->expires_at) {
            return 0;
        }
        
        $expiresAt = $this->expires_at instanceof Carbon 
            ? $this->expires_at 
            : Carbon::parse($this->expires_at);
        
        return max(0, Carbon::now()->diffInDays($expiresAt, false));
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
                    ->where('expires_at', '>', now());
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
                           ->where('expires_at', '<=', now());
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
            'expires_at' => now()->addMonths($this->plan->duration_months),
            'activated_at' => now(),
        ]);
    }
}
