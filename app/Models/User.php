<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'api_token',
        'monthly_request_limit',
        'current_month_requests',
        'last_request_reset',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_request_reset' => 'datetime',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is API user
     */
    public function isApiUser(): bool
    {
        return $this->role === 'api_user';
    }

    /**
     * Generate API token
     */
    public function generateApiToken(): string
    {
        $token = 'fs_' . Str::random(32);
        $this->update(['api_token' => $token]);
        return $token;
    }

    /**
     * Get user's subscriptions
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get user's website subscriptions
     */
    public function websiteSubscriptions(): HasMany
    {
        return $this->hasMany(WebsiteSubscription::class);
    }

    /**
     * Get user's active subscription
     */
    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')
            ->where('expires_at', '>', now());
    }

    /**
     * Get user's active website subscription
     */
    public function activeWebsiteSubscription(): HasOne
    {
        return $this->hasOne(WebsiteSubscription::class)
            ->where('status', 'active')
            ->where('expires_at', '>', now());
    }

    /**
     * Get user's API keys
     */
    public function apiKeys(): HasMany
    {
        return $this->hasMany(ApiKey::class);
    }

    /**
     * Get user's API usage
     */
    public function apiUsages(): HasMany
    {
        return $this->hasMany(ApiUsage::class);
    }

    /**
     * Check if user has active subscription
     */
    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription()->exists();
    }

    /**
     * Get current month's API usage count
     */
    public function getCurrentMonthUsage(): int
    {
        $lastReset = $this->last_request_reset ?? $this->created_at;
        
        if ($lastReset->month !== now()->month || $lastReset->year !== now()->year) {
            $this->resetMonthlyUsage();
            return 0;
        }
        
        return $this->current_month_requests;
    }

    /**
     * Reset monthly usage counter
     */
    public function resetMonthlyUsage(): void
    {
        $this->update([
            'current_month_requests' => 0,
            'last_request_reset' => now(),
        ]);
    }

    /**
     * Increment API usage
     */
    public function incrementApiUsage(): void
    {
        $this->getCurrentMonthUsage(); // This will reset if needed
        $this->increment('current_month_requests');
    }

    /**
     * Check if user has exceeded request limit
     */
    public function hasExceededLimit(): bool
    {
        return $this->getCurrentMonthUsage() >= $this->monthly_request_limit;
    }

    /**
     * Get today's API usage count
     */
    public function getTodayApiUsage(): int
    {
        return \App\Models\ApiUsage::where('user_id', $this->id)
                      ->whereDate('created_at', today())
                      ->count();
    }

    /**
     * Get monthly API usage count
     */
    public function getMonthlyApiUsage(): int
    {
        return \App\Models\ApiUsage::where('user_id', $this->id)
                      ->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year)
                      ->count();
    }

    /**
     * Get daily request limit based on subscription
     */
    public function getDailyRequestLimit(): int
    {
        if ($this->hasActiveSubscription()) {
            return $this->activeSubscription->plan->request_limit;
        }
        
        return $this->monthly_request_limit;
    }

    /**
     * Get remaining daily requests
     */
    public function getRemainingDailyRequests(): int
    {
        $limit = $this->getDailyRequestLimit();
        $used = $this->getTodayApiUsage();
        
        return max(0, $limit - $used);
    }
}
