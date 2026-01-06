<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKey;
use App\Models\ApiUsage;

class ApiAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request):Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $this->extractApiKey($request);
        
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
                'message' => 'API key is required'
            ], 401);
        }

        $apiKeyRecord = ApiKey::where('key', $apiKey)->with('user')->first();
        
        if (!$apiKeyRecord || !$apiKeyRecord->isValid()) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
                'message' => 'Invalid or inactive API key'
            ], 401);
        }

        // Check rate limiting
        if ($apiKeyRecord->isDailyLimitExceeded()) {
            return response()->json([
                'success' => false,
                'error' => 'Rate limit exceeded',
                'message' => 'Daily API request limit exceeded'
            ], 429);
        }

        // Update last used timestamp
        $apiKeyRecord->updateLastUsed();
        
        // Set authenticated user for the request
        $request->setUserResolver(function () use ($apiKeyRecord) {
            return $apiKeyRecord->user;
        });

        $startTime = microtime(true);
        
        $response = $next($request);
        
        // Log API usage after response is generated
        $this->logApiUsage($request, $apiKeyRecord, $startTime, $response);

        return $response;
    }

    /**
     * Extract API key from request
     */
    private function extractApiKey(Request $request): ?string
    {
        // Check Authorization header
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
    private function logApiUsage(Request $request, ApiKey $apiKey, float $startTime, Response $response): void
    {
        $responseTime = (microtime(true) - $startTime) * 1000; // Convert to milliseconds
        
        // Extract response data if available
        $responseData = null;
        try {
            $content = $response->getContent();
            $decoded = json_decode($content, true);
            // Only store if it's valid JSON and not too large (limit to 64KB)
            if ($decoded !== null && strlen($content) < 65536) {
                $responseData = $decoded;
            }
        } catch (Exception $e) {
            // If we can't decode, skip storing response data
        }
        
        try {
            ApiUsage::create([
                'user_id' => $apiKey->user_id,
                'api_key_id' => $apiKey->id,
                'endpoint' => $request->path(),
                'method' => $request->method(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'response_code' => $response->getStatusCode(),
                'response_time' => round($responseTime),
                'request_data' => $request->except(['password', 'password_confirmation']),
                'response_data' => $responseData,
                'requested_at' => now(),
            ]);
            
            // Increment usage count on API key
            $apiKey->increment('usage_count');
        } catch (Exception $e) {
            // Silently fail - don't break the API response
        }
    }
}
