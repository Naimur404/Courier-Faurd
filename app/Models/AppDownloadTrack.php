<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AppDownloadTrack extends Model
{
    protected $fillable = ['ip_address', 'status', 'completed_at'];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public static function track($ipAddress)
    {
        return self::create([
            'ip_address' => $ipAddress,
            'status' => 'complete',
            'completed_at' => now(),
        ]);
    }

    /**
     * Check if download is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'complete' && $this->completed_at !== null;
    }

    /**
     * Get download duration in seconds
     */
    public function getDurationInSeconds(): ?int
    {
        if (!$this->completed_at) {
            return null;
        }

        // Calculate duration, ensuring it's positive
        $duration = abs($this->created_at->diffInSeconds($this->completed_at));
        return $duration;
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDurationAttribute(): string
    {
        $duration = $this->getDurationInSeconds();
        
        if ($duration === null) {
            return 'In progress...';
        }
        
        if ($duration < 60) {
            return $duration . 's';
        } elseif ($duration < 3600) {
            return round($duration / 60, 1) . 'm';
        } else {
            return round($duration / 3600, 1) . 'h';
        }
    }
}
