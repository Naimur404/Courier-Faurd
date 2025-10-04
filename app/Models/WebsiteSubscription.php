<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class WebsiteSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_type',
        'amount',
        'starts_at',
        'expires_at',
        'status',
        'payment_method',
        'transaction_id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_EXPIRED = 'expired';
    const STATUS_CANCELLED = 'cancelled';

    const PLAN_DAILY = 'daily';
    const PLAN_WEEKLY = 'weekly';

    // Plan prices
    const DAILY_PRICE = 20;
    const WEEKLY_PRICE = 50;
    const WEEKLY_DAYS = 15;

    /**
     * Get the user who owns the subscription
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if subscription is active
     */
    public function isActive(): bool
    {
        if ($this->status !== self::STATUS_ACTIVE) {
            return false;
        }
        
        return $this->expires_at && $this->expires_at->isFuture();
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
            return $this->expires_at->isPast();
        }
        
        return false;
    }

    /**
     * Get days remaining
     */
    public function getDaysRemainingAttribute(): int
    {
        if (!$this->isActive()) {
            return 0;
        }
        
        return max(0, Carbon::now()->diffInDays($this->expires_at, false));
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute(): string
    {
        return '৳' . number_format($this->amount, 0);
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
     * Get active subscription for user
     */
    public static function getActiveForUser(int $userId): ?self
    {
        return self::where('user_id', $userId)
                  ->active()
                  ->first();
    }

    /**
     * Create subscription for user
     */
    public static function createForUser(int $userId, string $planType): self
    {
        $amount = $planType === self::PLAN_DAILY ? self::DAILY_PRICE : self::WEEKLY_PRICE;
        $expiresAt = $planType === self::PLAN_DAILY 
            ? now()->addDay() 
            : now()->addDays(self::WEEKLY_DAYS);

        return self::create([
            'user_id' => $userId,
            'plan_type' => $planType,
            'amount' => $amount,
            'starts_at' => now(),
            'expires_at' => $expiresAt,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Get plan details
     */
    public static function getPlanDetails(): array
    {
        return [
            self::PLAN_DAILY => [
                'name' => 'দৈনিক প্ল্যান',
                'name_en' => 'Daily Plan',
                'price' => self::DAILY_PRICE,
                'duration' => '১ দিন',
                'duration_en' => '1 Day',
                'description' => 'একদিনের জন্য সীমাহীন সার্চ',
                'description_en' => 'Unlimited searches for 1 day',
            ],
            self::PLAN_WEEKLY => [
                'name' => '১৫ দিনের প্ল্যান',
                'name_en' => '15 Days Plan',
                'price' => self::WEEKLY_PRICE,
                'duration' => '১৫ দিন',
                'duration_en' => '15 Days',
                'description' => '১৫ দিনের জন্য সীমাহীন সার্চ',
                'description_en' => 'Unlimited searches for 15 days',
            ],
        ];
    }

    /**
     * Check if user has active website subscription
     */
    public static function userHasActiveSubscription(int $userId): bool
    {
        return self::where('user_id', $userId)
                  ->active()
                  ->exists();
    }
}
