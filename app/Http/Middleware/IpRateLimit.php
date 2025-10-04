<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use App\Models\WebsiteSubscription;
use Symfony\Component\HttpFoundation\Response;

class IpRateLimit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user has active website subscription (unlimited searches)
        if (Auth::check()) {
            $user = Auth::user();
            $subscription = WebsiteSubscription::getActiveForUser($user->id);
            
            if ($subscription && $subscription->isActive()) {
                // User has active and verified subscription - no rate limit
                $response = $next($request);
                
                // Add headers to show unlimited access
                $response->headers->set('X-RateLimit-Limit', 'unlimited');
                $response->headers->set('X-RateLimit-Remaining', 'unlimited');
                $response->headers->set('X-Subscription-Status', 'active');
                $response->headers->set('X-Subscription-Plan', $subscription->plan_type);
                $response->headers->set('X-Subscription-Expires', $subscription->expires_at->toISOString());
                
                return $response;
            } elseif ($subscription && $subscription->isPending()) {
                // User has pending subscription - show special message
                return response()->json([
                    'success' => false,
                    'error' => 'Subscription pending verification',
                    'message' => 'আপনার সাবস্ক্রিপশন যাচাইকরণের অপেক্ষায় রয়েছে। অনুগ্রহ করে অ্যাডমিনের অনুমোদনের জন্য অপেক্ষা করুন।',
                    'subscription_status' => 'pending',
                    'verification_status' => $subscription->verification_status_label
                ], 403);
            }
        }
        
        // Apply rate limiting for non-subscribed users
        $ip = $request->ip();
        $key = 'ip_searches:' . $ip;
        $dailyLimit = 10;
        
        // Get current search count for this IP
        $searchCount = Cache::get($key, 0);
        
        // Check if limit exceeded
        if ($searchCount >= $dailyLimit) {
            return response()->json([
                'success' => false,
                'error' => 'Daily search limit exceeded',
                'message' => 'You have reached your daily limit of ' . $dailyLimit . ' searches. Please try again tomorrow or subscribe for unlimited access.',
                'limit' => $dailyLimit,
                'used' => $searchCount,
                'reset_time' => now()->endOfDay()->toISOString(),
                'subscription_available' => true,
                'subscription_plans' => WebsiteSubscription::getPlanDetails()
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
        $response->headers->set('X-Subscription-Status', 'none');
        
        return $response;
    }
}
