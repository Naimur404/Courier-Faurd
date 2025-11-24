<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKey;
use App\Models\ApiUsage;
use Carbon\Carbon;

class ApiSubscriptionAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $this->extractApiKey($request);
        
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
                'message' => 'API key is required. Include your API key in the Authorization header as "Bearer YOUR_API_KEY".'
            ], 401);
        }

        $apiKeyRecord = ApiKey::where('key', $apiKey)->with(['user.activeSubscription.plan'])->first();
        
        if (!$apiKeyRecord || !$apiKeyRecord->isValid()) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
                'message' => 'Invalid or inactive API key. Please check your API key or subscription status.'
            ], 401);
        }

        $user = $apiKeyRecord->user;
        $activeSubscription = $user->activeSubscription;

        // Check if user has active API subscription
        if (!$activeSubscription || !$activeSubscription->isActive()) {
            return response()->json([
                'success' => false,
                'error' => 'Subscription Required',
                'message' => 'Active API subscription required. Please subscribe to a plan to use this API.',
                'subscription_status' => $activeSubscription ? $activeSubscription->status : 'none',
                'expires_at' => $activeSubscription ? $activeSubscription->expires_at->toISOString() : null
            ], 402);
        }

        // Check subscription expiry
        if ($activeSubscription->isExpired()) {
            return response()->json([
                'success' => false,
                'error' => 'Subscription Expired',
                'message' => 'Your API subscription has expired. Please renew your subscription to continue using the API.',
                'expires_at' => $activeSubscription->expires_at->toISOString(),
                'days_expired' => Carbon::now()->diffInDays($activeSubscription->expires_at, false)
            ], 402);
        }

        $plan = $activeSubscription->plan;
        
        // Get current usage counts
        $todayUsage = $apiKeyRecord->getTodayUsageCount();
        $monthlyUsage = $apiKeyRecord->getMonthlyUsageCount();
        
        // Check daily limit (plan request_limit is per day)
        $dailyLimit = $plan->request_limit;
        if ($todayUsage >= $dailyLimit) {
            return response()->json([
                'success' => false,
                'error' => 'Daily Limit Exceeded',
                'message' => "Daily API request limit of {$dailyLimit} requests exceeded. Limit resets at midnight.",
                'usage' => [
                    'today' => $todayUsage,
                    'daily_limit' => $dailyLimit,
                    'monthly' => $monthlyUsage,
                    'reset_time' => now()->endOfDay()->toISOString()
                ]
            ], 429);
        }

        // Monthly limit (30x daily limit)
        $monthlyLimit = $dailyLimit * 30;
        if ($monthlyUsage >= $monthlyLimit) {
            return response()->json([
                'success' => false,
                'error' => 'Monthly Limit Exceeded',
                'message' => "Monthly API request limit of {$monthlyLimit} requests exceeded. Limit resets next month.",
                'usage' => [
                    'today' => $todayUsage,
                    'daily_limit' => $dailyLimit,
                    'monthly' => $monthlyUsage,
                    'monthly_limit' => $monthlyLimit,
                    'reset_time' => now()->endOfMonth()->toISOString()
                ]
            ], 429);
        }

        // Update last used timestamp
        $apiKeyRecord->updateLastUsed();
        
        // Set authenticated user and API key for the request
        $request->setUserResolver(function () use ($user) {
            return $user;
        });
        
        // Add API key to request for controller access
        $request->merge(['api_key_record' => $apiKeyRecord]);

        $startTime = microtime(true);
        $response = $next($request);
        
        // Log API usage immediately after request processing
        $this->logApiUsage($request, $apiKeyRecord, $startTime, $response->getStatusCode());

        // Add rate limit headers to response
        $remainingDaily = max(0, $dailyLimit - ($todayUsage + 1));
        $remainingMonthly = max(0, $monthlyLimit - ($monthlyUsage + 1));
        
        $response->headers->set('X-RateLimit-Daily-Limit', $dailyLimit);
        $response->headers->set('X-RateLimit-Daily-Remaining', $remainingDaily);
        $response->headers->set('X-RateLimit-Monthly-Limit', $monthlyLimit);
        $response->headers->set('X-RateLimit-Monthly-Remaining', $remainingMonthly);
        $response->headers->set('X-RateLimit-Reset-Daily', now()->endOfDay()->timestamp);
        $response->headers->set('X-RateLimit-Reset-Monthly', now()->endOfMonth()->timestamp);
        $response->headers->set('X-Subscription-Plan', $plan->name);
        $response->headers->set('X-Subscription-Expires', $activeSubscription->expires_at->toISOString());

        return $response;
    }

    /**
     * Extract API key from request
     */
    private function extractApiKey(Request $request): ?string
    {
        // Check Authorization header (Bearer token)
        $authHeader = $request->header('Authorization');
        if ($authHeader && preg_match('/Bearer\s+(.+)/', $authHeader, $matches)) {
            return $matches[1];
        }
        
        // Check X-API-Key header
        $apiKeyHeader = $request->header('X-API-Key');
        if ($apiKeyHeader) {
            return $apiKeyHeader;
        }
        
        // Check query parameter
        return $request->get('api_key');
    }

    /**
     * Log API usage
     */
    private function logApiUsage(Request $request, ApiKey $apiKey, float $startTime, int $responseStatus): void
    {
        $responseTime = (microtime(true) - $startTime) * 1000; // Convert to milliseconds
        
        try {
            ApiUsage::create([
                'user_id' => $apiKey->user_id,
                'api_key_id' => $apiKey->id,
                'endpoint' => $request->path(),
                'method' => $request->method(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'response_status' => $responseStatus,
                'response_time' => round($responseTime),
                'request_data' => $request->except(['password', 'password_confirmation', 'api_key']),
            ]);
            
            // Increment usage count on API key
            $apiKey->increment('usage_count');
            
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('API Usage logging failed: ' . $e->getMessage(), [
                'api_key_id' => $apiKey->id,
                'endpoint' => $request->path(),
                'error' => $e->getMessage()
            ]);
        }
    }
}