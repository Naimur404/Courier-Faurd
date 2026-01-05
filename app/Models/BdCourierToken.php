<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BdCourierToken extends Model
{
    protected $table = 'api_tokens';
    
    protected $fillable = [
        'name',
        'token',
        'is_active',
        'cooldown_until',
        'usage_count',
        'last_used_at',
        'priority',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'cooldown_until' => 'datetime',
        'last_used_at' => 'datetime',
    ];

    /**
     * Get the next available token (not on cooldown)
     */
    public static function getAvailableToken()
    {
        $now = Carbon::now('Asia/Dhaka');
        
        // First, clear any expired cooldowns (past midnight BDT)
        self::where('cooldown_until', '<=', $now)
            ->update(['cooldown_until' => null, 'usage_count' => 0]);
        
        // Get an active token that's not on cooldown
        return self::where('is_active', true)
            ->where(function ($query) use ($now) {
                $query->whereNull('cooldown_until')
                      ->orWhere('cooldown_until', '<=', $now);
            })
            ->orderBy('priority', 'asc')
            ->orderBy('usage_count', 'asc')
            ->first();
    }

    /**
     * Put this token on cooldown until midnight BDT
     */
    public function putOnCooldown()
    {
        // Get current time in Bangladesh timezone
        $nowBDT = Carbon::now('Asia/Dhaka');
        
        // Calculate midnight BDT (next day at 00:00:00)
        $midnightBDT = $nowBDT->copy()->addDay()->startOfDay();
        
        $this->update([
            'cooldown_until' => $midnightBDT,
        ]);
        
        \Illuminate\Support\Facades\Log::info("BdCourier token '{$this->name}' (ID: {$this->id}) put on cooldown until midnight BDT ({$midnightBDT->format('Y-m-d H:i:s')} BDT)");
    }

    /**
     * Record successful usage of this token
     */
    public function recordUsage()
    {
        $this->increment('usage_count');
        $this->update(['last_used_at' => Carbon::now()]);
    }

    /**
     * Check if token is currently on cooldown
     */
    public function isOnCooldown()
    {
        if (!$this->cooldown_until) {
            return false;
        }
        
        return Carbon::now('Asia/Dhaka')->lt($this->cooldown_until);
    }

    /**
     * Clear cooldown for this token
     */
    public function clearCooldown()
    {
        $this->update([
            'cooldown_until' => null,
            'usage_count' => 0,
        ]);
    }
}
