<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'key',
        'name',
        'last_used_at',
        'is_active',
    ];

    protected $casts = [
        'last_used_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected $hidden = [
        'key',
    ];

    /**
     * Get the user who owns the API key
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get API usage records for this key
     */
    public function apiUsages(): HasMany
    {
        return $this->hasMany(ApiUsage::class);
    }

    /**
     * Generate a new API key
     */
    public static function generateKey(): string
    {
        return 'cf_' . Str::random(32);
    }

    /**
     * Get masked API key for display
     */
    public function getMaskedKeyAttribute(): string
    {
        return substr($this->key, 0, 8) . '...' . substr($this->key, -4);
    }

    /**
     * Update last used timestamp
     */
    public function updateLastUsed(): void
    {
        $this->update(['last_used_at' => now()]);
    }

    /**
     * Check if key is active and valid
     */
    public function isValid(): bool
    {
        return $this->is_active && $this->user->hasActiveSubscription();
    }

    /**
     * Get usage count for today
     */
    public function getTodayUsageCount(): int
    {
        return $this->apiUsages()
                   ->whereDate('created_at', today())
                   ->count();
    }

    /**
     * Get usage count for current month
     */
    public function getMonthlyUsageCount(): int
    {
        return $this->apiUsages()
                   ->whereMonth('created_at', now()->month)
                   ->whereYear('created_at', now()->year)
                   ->count();
    }

    /**
     * Check if daily limit is exceeded
     */
    public function isDailyLimitExceeded(): bool
    {
        if (!$this->user->hasActiveSubscription()) {
            return true;
        }

        $dailyLimit = $this->user->activeSubscription->plan->request_limit;
        return $this->getTodayUsageCount() >= $dailyLimit;
    }

    /**
     * Scope for active keys
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for keys with recent activity
     */
    public function scopeRecentlyUsed($query, $days = 30)
    {
        return $query->where('last_used_at', '>=', now()->subDays($days));
    }
}
