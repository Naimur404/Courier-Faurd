<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\BlockedIp;
use App\Models\ApiKey;
use Symfony\Component\HttpFoundation\Response;

class ApiRateLimit
{
    /**
     * Handle an incoming request.
     * Check if IP is blocked and apply rate limiting based on API key settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        // Step 1: Check if IP is blocked
        if (BlockedIp::isBlocked($ip)) {
            return $this->blockedResponse($ip);
        }

        // Step 2: Get API key from request
        $apiKeyString = $request->header('X-API-Key') ?? $request->bearerToken();
        
        if (!$apiKeyString) {
            return response()->json([
                'success' => false,
                'error' => 'missing_api_key',
                'message' => 'API key is required.',
                'message_bn' => 'API কী প্রয়োজন।',
            ], 401);
        }

        // Step 3: Find and validate API key
        $apiKey = ApiKey::where('key', $apiKeyString)->first();
        
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'error' => 'invalid_api_key',
                'message' => 'Invalid API key.',
                'message_bn' => 'অবৈধ API কী।',
            ], 401);
        }

        if (!$apiKey->is_active) {
            return response()->json([
                'success' => false,
                'error' => 'api_key_inactive',
                'message' => 'API key is inactive.',
                'message_bn' => 'API কী নিষ্ক্রিয়।',
            ], 403);
        }

        // Step 4: Apply rate limiting based on API key's rate_limit
        $rateLimit = $apiKey->rate_limit ?? 60; // Default 60 requests per minute
        $key = 'api_rate_limit:' . $apiKey->id;

        if (RateLimiter::tooManyAttempts($key, $rateLimit)) {
            return $this->rateLimitExceededResponse($key, $rateLimit);
        }

        // Increment the rate limiter (1 minute decay)
        RateLimiter::hit($key, 60);

        // Update API key usage
        $apiKey->increment('usage_count');
        $apiKey->update(['last_used_at' => now()]);

        // Add API key to request for use in controllers
        $request->attributes->set('api_key', $apiKey);

        // Add rate limit headers to response
        $response = $next($request);
        
        return $this->addRateLimitHeaders(
            $response,
            $key,
            $rateLimit,
            RateLimiter::remaining($key, $rateLimit)
        );
    }

    /**
     * Return blocked IP response
     */
    protected function blockedResponse(string $ip): Response
    {
        $block = BlockedIp::getActiveBlock($ip);
        
        return response()->json([
            'success' => false,
            'error' => 'ip_blocked',
            'message' => 'Your IP address has been blocked.',
            'message_bn' => 'আপনার আইপি ঠিকানা ব্লক করা হয়েছে।',
            'reason' => $block?->reason ?? 'Policy violation',
            'expires_at' => $block?->expires_at?->toISOString(),
        ], 403);
    }

    /**
     * Return rate limit exceeded response
     */
    protected function rateLimitExceededResponse(string $key, int $rateLimit): Response
    {
        $retryAfter = RateLimiter::availableIn($key);
        
        return response()->json([
            'success' => false,
            'error' => 'rate_limit_exceeded',
            'message' => 'Too many requests. Please try again later.',
            'message_bn' => 'অনেক বেশি অনুরোধ। অনুগ্রহ করে কিছুক্ষণ পর আবার চেষ্টা করুন।',
            'retry_after' => $retryAfter,
            'limit' => $rateLimit,
        ], 429)->withHeaders([
            'Retry-After' => $retryAfter,
            'X-RateLimit-Limit' => $rateLimit,
            'X-RateLimit-Remaining' => 0,
        ]);
    }

    /**
     * Add rate limit headers to response
     */
    protected function addRateLimitHeaders(Response $response, string $key, int $rateLimit, int $remaining): Response
    {
        $response->headers->set('X-RateLimit-Limit', $rateLimit);
        $response->headers->set('X-RateLimit-Remaining', max(0, $remaining));
        
        return $response;
    }
}
