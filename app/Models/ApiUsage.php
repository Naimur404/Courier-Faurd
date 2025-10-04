<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'api_key_id',
        'endpoint',
        'method',
        'ip_address',
        'user_agent',
        'response_status',
        'response_time',
        'request_data',
        'response_data',
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
        'response_time' => 'integer',
    ];

    /**
     * Get the user who made the API request
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the API key used for the request
     */
    public function apiKey(): BelongsTo
    {
        return $this->belongsTo(ApiKey::class);
    }

    /**
     * Check if request was successful
     */
    public function isSuccessful(): bool
    {
        return $this->response_status >= 200 && $this->response_status < 300;
    }

    /**
     * Get formatted response time
     */
    public function getFormattedResponseTimeAttribute(): string
    {
        if ($this->response_time < 1000) {
            return $this->response_time . 'ms';
        }
        
        return number_format($this->response_time / 1000, 2) . 's';
    }

    /**
     * Scope for successful requests
     */
    public function scopeSuccessful($query)
    {
        return $query->whereBetween('response_status', [200, 299]);
    }

    /**
     * Scope for failed requests
     */
    public function scopeFailed($query)
    {
        return $query->where('response_status', '>=', 400);
    }

    /**
     * Scope for today's usage
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope for this month's usage
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    /**
     * Scope for specific endpoint
     */
    public function scopeEndpoint($query, $endpoint)
    {
        return $query->where('endpoint', $endpoint);
    }

    /**
     * Scope for specific method
     */
    public function scopeMethod($query, $method)
    {
        return $query->where('method', strtoupper($method));
    }

    /**
     * Get usage statistics for a period
     */
    public static function getStatsForPeriod($startDate, $endDate, $userId = null)
    {
        $query = static::whereBetween('created_at', [$startDate, $endDate]);
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        return [
            'total_requests' => $query->count(),
            'successful_requests' => $query->successful()->count(),
            'failed_requests' => $query->failed()->count(),
            'avg_response_time' => $query->avg('response_time'),
            'endpoints' => $query->groupBy('endpoint')
                                ->selectRaw('endpoint, count(*) as count')
                                ->pluck('count', 'endpoint')
                                ->toArray(),
        ];
    }
}
