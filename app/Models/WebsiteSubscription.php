<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use App\Notifications\NewWebsiteSubscriptionNotification;

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
        'verification_status',
        'verified_at',
        'verified_by',
        'admin_notes',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
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

    // Verification statuses
    const VERIFICATION_PENDING = 'pending';
    const VERIFICATION_VERIFIED = 'verified';
    const VERIFICATION_REJECTED = 'rejected';

    /**
     * Get the user who owns the subscription
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who verified the subscription
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check if subscription is active and verified
     */
    public function isActive(): bool
    {
        if ($this->status !== self::STATUS_ACTIVE) {
            return false;
        }

        if ($this->verification_status !== self::VERIFICATION_VERIFIED) {
            return false;
        }
        
        if (!$this->expires_at) {
            return false;
        }
        
        // Use Bangladesh timezone for comparison
        $now = Carbon::now('Asia/Dhaka');
        $expiresAt = $this->expires_at->setTimezone('Asia/Dhaka');
        
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
            // Use Bangladesh timezone for comparison
            $now = Carbon::now('Asia/Dhaka');
            $expiresAt = $this->expires_at->setTimezone('Asia/Dhaka');
            return $expiresAt->isPast();
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
        
        // Use Bangladesh timezone for calculations
        $now = Carbon::now('Asia/Dhaka');
        $expiresAt = $this->expires_at->setTimezone('Asia/Dhaka');
        
        // If subscription has already expired
        if ($expiresAt->isPast()) {
            return 0;
        }
        
        // Calculate the difference in whole days
        $today = $now->copy()->startOfDay();
        $expiryDay = $expiresAt->copy()->startOfDay();
        
        $daysDifference = $today->diffInDays($expiryDay);
        
        // If expires today, show 1 day remaining (include today)
        // If expires tomorrow, show 2 days remaining (today + tomorrow)
        return $daysDifference + 1;
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
        $bangladeshNow = Carbon::now('Asia/Dhaka');
        return $query->where('status', self::STATUS_ACTIVE)
                    ->where('expires_at', '>', $bangladeshNow);
    }

    /**
     * Scope for expired subscriptions
     */
    public function scopeExpired($query)
    {
        $bangladeshNow = Carbon::now('Asia/Dhaka');
        return $query->where(function($q) use ($bangladeshNow) {
            $q->where('status', self::STATUS_EXPIRED)
              ->orWhere(function($subQuery) use ($bangladeshNow) {
                  $subQuery->where('status', self::STATUS_ACTIVE)
                           ->where('expires_at', '<=', $bangladeshNow);
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
                  ->where('verification_status', self::VERIFICATION_VERIFIED)
                  ->first();
    }

    /**
     * Create subscription for user
     */
    public static function createForUser(int $userId, string $planType): self
    {
        $amount = $planType === self::PLAN_DAILY ? self::DAILY_PRICE : self::WEEKLY_PRICE;
        $bangladeshNow = Carbon::now('Asia/Dhaka');
        $expiresAt = $planType === self::PLAN_DAILY 
            ? $bangladeshNow->copy()->addDay() 
            : $bangladeshNow->copy()->addDays(self::WEEKLY_DAYS);

        return self::create([
            'user_id' => $userId,
            'plan_type' => $planType,
            'amount' => $amount,
            'starts_at' => $bangladeshNow,
            'expires_at' => $expiresAt,
            'status' => self::STATUS_ACTIVE,
            'verification_status' => self::VERIFICATION_PENDING,
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
                  ->where('verification_status', self::VERIFICATION_VERIFIED)
                  ->exists();
    }

    /**
     * Verification status methods
     */
    public function isPending(): bool
    {
        return $this->verification_status === self::VERIFICATION_PENDING;
    }

    public function isVerified(): bool
    {
        return $this->verification_status === self::VERIFICATION_VERIFIED;
    }

    public function isRejected(): bool
    {
        return $this->verification_status === self::VERIFICATION_REJECTED;
    }

    /**
     * Verify subscription
     */
    public function verify(int $adminId, ?string $notes = null): void
    {
        $this->update([
            'verification_status' => self::VERIFICATION_VERIFIED,
            'verified_by' => $adminId,
            'verified_at' => Carbon::now('Asia/Dhaka'),
            'admin_notes' => $notes,
        ]);
    }

    /**
     * Reject subscription
     */
    public function reject(int $adminId, ?string $notes = null): void
    {
        $this->update([
            'verification_status' => self::VERIFICATION_REJECTED,
            'verified_by' => $adminId,
            'verified_at' => Carbon::now('Asia/Dhaka'),
            'admin_notes' => $notes,
        ]);
    }

    /**
     * Get verification status label in Bengali
     */
    public function getVerificationStatusLabelAttribute(): string
    {
        $labels = [
            self::VERIFICATION_PENDING => 'যাচাইকরণ অপেক্ষমান',
            self::VERIFICATION_VERIFIED => 'যাচাইকৃত',
            self::VERIFICATION_REJECTED => 'প্রত্যাখ্যাত',
        ];

        return $labels[$this->verification_status] ?? 'অজানা';
    }

    /**
     * Get verification status badge CSS class
     */
    public function getVerificationStatusBadgeClassAttribute(): string
    {
        $classes = [
            self::VERIFICATION_PENDING => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            self::VERIFICATION_VERIFIED => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            self::VERIFICATION_REJECTED => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
        ];

        return $classes[$this->verification_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
    }

    /**
     * Boot the model and notify admins on new subscription
     */
    protected static function booted(): void
    {
        static::created(function (WebsiteSubscription $subscription) {
            // Notify all admin users
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewWebsiteSubscriptionNotification($subscription));
            }
        });
    }
}
