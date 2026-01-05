<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class BlockedIp extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'reason',
        'blocked_by',
        'blocked_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'blocked_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the admin who blocked this IP
     */
    public function blockedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'blocked_by');
    }

    /**
     * Check if the IP block is currently active
     */
    public function isCurrentlyBlocked(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        // If expires_at is null, it's a permanent block
        if ($this->expires_at === null) {
            return true;
        }

        // Check if the block hasn't expired yet
        return $this->expires_at->isFuture();
    }

    /**
     * Check if an IP address is blocked
     */
    public static function isBlocked(string $ipAddress): bool
    {
        $block = self::where('ip_address', $ipAddress)
            ->where('is_active', true)
            ->first();

        if (!$block) {
            return false;
        }

        return $block->isCurrentlyBlocked();
    }

    /**
     * Get active block for IP
     */
    public static function getActiveBlock(string $ipAddress): ?self
    {
        return self::where('ip_address', $ipAddress)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', Carbon::now());
            })
            ->first();
    }

    /**
     * Block an IP address
     */
    public static function blockIp(string $ipAddress, ?string $reason = null, ?int $blockedBy = null, ?Carbon $expiresAt = null): self
    {
        return self::updateOrCreate(
            ['ip_address' => $ipAddress],
            [
                'reason' => $reason,
                'blocked_by' => $blockedBy,
                'blocked_at' => Carbon::now('Asia/Dhaka'),
                'expires_at' => $expiresAt,
                'is_active' => true,
            ]
        );
    }

    /**
     * Unblock an IP address
     */
    public static function unblockIp(string $ipAddress): bool
    {
        return self::where('ip_address', $ipAddress)
            ->update(['is_active' => false]);
    }

    /**
     * Scope for active blocks
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', Carbon::now());
            });
    }

    /**
     * Get block status label
     */
    public function getStatusLabelAttribute(): string
    {
        if (!$this->is_active) {
            return 'Unblocked';
        }

        if ($this->expires_at === null) {
            return 'Permanently Blocked';
        }

        if ($this->expires_at->isFuture()) {
            return 'Temporarily Blocked';
        }

        return 'Expired';
    }
}
