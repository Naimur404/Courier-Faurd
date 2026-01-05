<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\WebsiteSubscription;
use App\Models\BlockedIp;
use App\Models\WebSubscriptionUsage;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class WebRateLimit
{
    /**
     * Rate limits configuration
     */
    const SUBSCRIBER_HITS_PER_MINUTE = 5;
    const NON_SUBSCRIBER_DAILY_LIMIT = 5;

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        // Step 1: Check if IP is blocked
        if (BlockedIp::isBlocked($ip)) {
            $block = BlockedIp::getActiveBlock($ip);
            return response()->json([
                'success' => false,
                'error' => 'IP blocked',
                'message' => 'আপনার আইপি ঠিকানা ব্লক করা হয়েছে।',
                'reason' => $block?->reason ?? 'Policy violation',
                'expires_at' => $block?->expires_at?->toISOString(),
            ], 403);
        }

        // Step 2: Verify request origin (must come from our website)
        if (!$this->verifyRequestOrigin($request)) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid request origin',
                'message' => 'এই API শুধুমাত্র আমাদের ওয়েবসাইট থেকে অ্যাক্সেস করা যাবে।',
            ], 403);
        }

        // Step 3: Check authentication and subscription status
        if (Auth::check()) {
            $user = Auth::user();
            $subscription = WebsiteSubscription::getActiveForUser($user->id);

            if ($subscription && $subscription->isActive()) {
                // User has active subscription - apply rate limit (5 hits per minute)
                return $this->handleSubscribedUser($request, $next, $user, $subscription, $ip);
            } elseif ($subscription && $subscription->isPending()) {
                // User has pending subscription
                return response()->json([
                    'success' => false,
                    'error' => 'Subscription pending verification',
                    'message' => 'আপনার সাবস্ক্রিপশন যাচাইকরণের অপেক্ষায় রয়েছে। অনুগ্রহ করে অ্যাডমিনের অনুমোদনের জন্য অপেক্ষা করুন।',
                    'subscription_status' => 'pending',
                ], 403);
            }
        }

        // Step 4: Non-subscribed user - apply daily limit (5 searches per day)
        return $this->handleNonSubscribedUser($request, $next, $ip);
    }

    /**
     * Verify that the request comes from our website
     */
    private function verifyRequestOrigin(Request $request): bool
    {
        // Get allowed origins from config
        $allowedOrigins = $this->getAllowedOrigins();

        // Check Referer header
        $referer = $request->header('Referer');
        if ($referer) {
            $refererHost = parse_url($referer, PHP_URL_HOST);
            foreach ($allowedOrigins as $origin) {
                $originHost = parse_url($origin, PHP_URL_HOST);
                if ($refererHost === $originHost) {
                    return true;
                }
            }
        }

        // Check Origin header
        $origin = $request->header('Origin');
        if ($origin) {
            foreach ($allowedOrigins as $allowed) {
                $allowedHost = parse_url($allowed, PHP_URL_HOST);
                $originHost = parse_url($origin, PHP_URL_HOST);
                if ($originHost === $allowedHost) {
                    return true;
                }
            }
        }

        // Check X-Requested-With header (for AJAX requests)
        $xRequestedWith = $request->header('X-Requested-With');
        if ($xRequestedWith === 'XMLHttpRequest') {
            // Additional check: must have either Referer or Origin from our domain
            if ($referer || $origin) {
                // Already checked above, if we're here it means headers don't match
                return false;
            }
        }

        // Check for Inertia requests (SPA navigation)
        if ($request->header('X-Inertia')) {
            return true;
        }

        // Allow requests from localhost in development
        if (app()->environment('local', 'development')) {
            $host = $request->getHost();
            if (in_array($host, ['localhost', '127.0.0.1', '::1']) || str_contains($host, '.test')) {
                return true;
            }
        }

        // Check for same-origin requests
        $requestHost = $request->getHost();
        foreach ($allowedOrigins as $allowed) {
            $allowedHost = parse_url($allowed, PHP_URL_HOST);
            if ($requestHost === $allowedHost) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get allowed origins
     */
    private function getAllowedOrigins(): array
    {
        $appUrl = config('app.url');
        
        return array_filter([
            $appUrl,
            env('ALLOWED_ORIGIN'),
            'https://courierfaurd.com',
            'https://www.courierfaurd.com',
            'http://localhost:8000',
            'http://localhost:5173',
            'http://127.0.0.1:8000',
            'http://127.0.0.1:5173',
        ]);
    }

    /**
     * Handle subscribed user with per-minute rate limiting
     */
    private function handleSubscribedUser(Request $request, Closure $next, $user, $subscription, string $ip): Response
    {
        $userId = $user->id;
        $minuteKey = "web_rate_limit:{$userId}:minute:" . Carbon::now('Asia/Dhaka')->format('Y-m-d-H-i');
        
        // Get current minute's hit count
        $minuteHits = Cache::get($minuteKey, 0);

        // Check if per-minute limit exceeded (5 hits per minute)
        if ($minuteHits >= self::SUBSCRIBER_HITS_PER_MINUTE) {
            $secondsRemaining = 60 - Carbon::now('Asia/Dhaka')->second;
            
            return response()->json([
                'success' => false,
                'error' => 'Rate limit exceeded',
                'message' => 'প্রতি মিনিটে সর্বোচ্চ ' . self::SUBSCRIBER_HITS_PER_MINUTE . ' বার সার্চ করা যাবে। অনুগ্রহ করে ' . $secondsRemaining . ' সেকেন্ড পর আবার চেষ্টা করুন।',
                'limit' => self::SUBSCRIBER_HITS_PER_MINUTE,
                'used' => $minuteHits,
                'retry_after' => $secondsRemaining,
            ], 429);
        }

        // Process the request
        $response = $next($request);

        // Only increment counters for successful requests
        if ($response->getStatusCode() === 200) {
            // Increment minute counter (expires after 60 seconds)
            Cache::put($minuteKey, $minuteHits + 1, 60);

            // Record usage in database for tracking
            WebSubscriptionUsage::recordHit($userId, $subscription->id, $ip);
        }

        // Add rate limit headers
        $newMinuteHits = Cache::get($minuteKey, 0);
        $response->headers->set('X-RateLimit-Limit', self::SUBSCRIBER_HITS_PER_MINUTE);
        $response->headers->set('X-RateLimit-Remaining', max(0, self::SUBSCRIBER_HITS_PER_MINUTE - $newMinuteHits));
        $response->headers->set('X-RateLimit-Reset', Carbon::now('Asia/Dhaka')->addMinute()->startOfMinute()->timestamp);
        $response->headers->set('X-Subscription-Status', 'active');
        $response->headers->set('X-Subscription-Plan', $subscription->plan_type);
        $response->headers->set('X-Daily-Limit', 'unlimited');

        return $response;
    }

    /**
     * Handle non-subscribed user with daily limit
     */
    private function handleNonSubscribedUser(Request $request, Closure $next, string $ip): Response
    {
        $key = 'ip_searches:' . $ip;
        $dailyLimit = self::NON_SUBSCRIBER_DAILY_LIMIT;

        // Get current search count for this IP
        $searchCount = Cache::get($key, 0);

        // Check if limit exceeded
        if ($searchCount >= $dailyLimit) {
            return response()->json([
                'success' => false,
                'error' => 'Daily search limit exceeded',
                'message' => 'আপনি আজকের জন্য ' . $dailyLimit . ' টি সার্চ সীমা পৌঁছে গেছেন। আগামীকাল আবার চেষ্টা করুন অথবা সাবস্ক্রিপশন নিন।',
                'limit' => $dailyLimit,
                'used' => $searchCount,
                'reset_time' => Carbon::now('Asia/Dhaka')->endOfDay()->toISOString(),
                'subscription_available' => true,
                'subscription_plans' => WebsiteSubscription::getPlanDetails()
            ], 429);
        }

        // Process the request
        $response = $next($request);

        // Only increment counter for successful requests
        if ($response->getStatusCode() === 200) {
            // Increment search count with expiry at end of day
            $expiresAt = Carbon::now('Asia/Dhaka')->endOfDay();
            Cache::put($key, $searchCount + 1, $expiresAt);
        }

        // Add rate limit headers
        $newCount = Cache::get($key, 0);
        $response->headers->set('X-RateLimit-Limit', $dailyLimit);
        $response->headers->set('X-RateLimit-Remaining', max(0, $dailyLimit - $newCount));
        $response->headers->set('X-RateLimit-Reset', Carbon::now('Asia/Dhaka')->endOfDay()->timestamp);
        $response->headers->set('X-Subscription-Status', 'none');

        return $response;
    }
}
