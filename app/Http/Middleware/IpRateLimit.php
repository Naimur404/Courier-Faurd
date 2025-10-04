<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class IpRateLimit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $key = 'ip_searches:' . $ip;
        $dailyLimit = 7;
        
        // Get current search count for this IP
        $searchCount = Cache::get($key, 0);
        
        // Check if limit exceeded
        if ($searchCount >= $dailyLimit) {
            return response()->json([
                'success' => false,
                'error' => 'Daily search limit exceeded',
                'message' => 'You have reached your daily limit of ' . $dailyLimit . ' searches. Please try again tomorrow or contact us for API access.',
                'limit' => $dailyLimit,
                'used' => $searchCount,
                'reset_time' => now()->endOfDay()->toISOString()
            ], 429);
        }
        
        // Process the request
        $response = $next($request);
        
        // Only increment counter for successful requests
        if ($response->getStatusCode() === 200) {
            // Increment search count with expiry at end of day
            $expiresAt = now()->endOfDay();
            Cache::put($key, $searchCount + 1, $expiresAt);
        }
        
        // Add rate limit headers to response
        $newCount = Cache::get($key, 0);
        $response->headers->set('X-RateLimit-Limit', $dailyLimit);
        $response->headers->set('X-RateLimit-Remaining', max(0, $dailyLimit - $newCount));
        $response->headers->set('X-RateLimit-Reset', now()->endOfDay()->timestamp);
        
        return $response;
    }
}
