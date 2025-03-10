<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadTracker extends Model
{
    protected $fillable = [
        'track_id',
        'ip_address',
        'user_agent',
        'format',
        'status',
        'completed_at',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'completed_at' => 'datetime',
    ];
}
