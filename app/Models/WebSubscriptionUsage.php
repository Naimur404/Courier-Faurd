<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class WebSubscriptionUsage extends Model
{
    use HasFactory;

    protected $table = 'web_subscription_usages';

    protected $fillable = [
        'user_id',
        'website_subscription_id',
        'ip_address',
        'endpoint',
        'usage_date',
        'hit_count',
        'last_hit_at',
    ];

    protected $casts = [
        'usage_date' => 'date',
        'last_hit_at' => 'datetime',
        'hit_count' => 'integer',
    ];

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(WebsiteSubscription::class, 'website_subscription_id');
    }

    /**
     * Record a hit for a user
     */
    public static function recordHit(int $userId, ?int $subscriptionId = null, string $ipAddress = '', string $endpoint = '/courier-check'): self
    {
        $today = Carbon::now('Asia/Dhaka')->toDateString();

        $usage = self::firstOrCreate(
            [
                'user_id' => $userId,
                'usage_date' => $today,
            ],
            [
                'website_subscription_id' => $subscriptionId,
                'ip_address' => $ipAddress,
                'endpoint' => $endpoint,
                'hit_count' => 0,
            ]
        );

        $usage->increment('hit_count');
        $usage->update([
            'last_hit_at' => Carbon::now('Asia/Dhaka'),
            'ip_address' => $ipAddress,
        ]);

        return $usage;
    }

    /**
     * Get today's hit count for a user
     */
    public static function getTodayHitCount(int $userId): int
    {
        $today = Carbon::now('Asia/Dhaka')->toDateString();

        return self::where('user_id', $userId)
            ->where('usage_date', $today)
            ->value('hit_count') ?? 0;
    }

    /**
     * Get hits in the last minute for a user (for rate limiting)
     */
    public static function getLastMinuteHitCount(int $userId): int
    {
        $oneMinuteAgo = Carbon::now('Asia/Dhaka')->subMinute();

        return self::where('user_id', $userId)
            ->where('last_hit_at', '>=', $oneMinuteAgo)
            ->sum('hit_count');
    }

    /**
     * Get daily usage statistics for a user
     */
    public static function getDailyStats(int $userId, int $days = 30): array
    {
        $startDate = Carbon::now('Asia/Dhaka')->subDays($days)->toDateString();

        return self::where('user_id', $userId)
            ->where('usage_date', '>=', $startDate)
            ->orderBy('usage_date', 'desc')
            ->get()
            ->map(function ($usage) {
                return [
                    'date' => $usage->usage_date->format('Y-m-d'),
                    'hit_count' => $usage->hit_count,
                ];
            })
            ->toArray();
    }

    /**
     * Get all users' daily usage for admin panel
     */
    public static function getAllUsersStats(?string $date = null): \Illuminate\Database\Eloquent\Collection
    {
        $date = $date ?? Carbon::now('Asia/Dhaka')->toDateString();

        return self::where('usage_date', $date)
            ->with(['user', 'subscription'])
            ->orderBy('hit_count', 'desc')
            ->get();
    }

    /**
     * Scope for today
     */
    public function scopeToday($query)
    {
        return $query->where('usage_date', Carbon::now('Asia/Dhaka')->toDateString());
    }

    /**
     * Scope for a specific date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('usage_date', [$startDate, $endDate]);
    }
}
