<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKey;
use App\Models\ApiUsage;

class ApiAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
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

        // Log API usage
        $this->logApiUsage($request, $apiKeyRecord);
        
        // Update last used timestamp
        $apiKeyRecord->updateLastUsed();
        
        // Set authenticated user for the request
        $request->setUserResolver(function () use ($apiKeyRecord) {
            return $apiKeyRecord->user;
        });

        return $next($request);
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
    private function logApiUsage(Request $request, ApiKey $apiKey): void
    {
        $startTime = microtime(true);
        
        register_shutdown_function(function () use ($request, $apiKey, $startTime) {
            $responseTime = (microtime(true) - $startTime) * 1000; // Convert to milliseconds
            
            ApiUsage::create([
                'user_id' => $apiKey->user_id,
                'api_key_id' => $apiKey->id,
                'endpoint' => $request->path(),
                'method' => $request->method(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'response_status' => http_response_code() ?: 200,
                'response_time' => round($responseTime),
                'request_data' => $request->except(['password', 'password_confirmation']),
            ]);
        });
    }
}
