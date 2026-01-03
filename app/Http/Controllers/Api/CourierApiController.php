<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CourierApiController extends Controller
{
    /**
     * Check customer fraud data via API
     */
    public function check(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|regex:/^01[3-9]\d{8}$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Validation Error',
                'message' => 'Invalid phone number format. Please provide a valid Bangladeshi phone number starting with 01.',
                'errors' => $validator->errors()
            ], 400);
        }

        $phone = $request->input('phone');

        try {
            // Get existing customer data
            $existingCustomer = Customer::where('phone', $phone)->first();
            
            // Configuration: Cache days from .env (default 3 days)
            $cacheDays = (int) env('BDCOURIER_CACHE_DAYS', 3);
            
            // If customer exists and has data, check if data is still fresh
            if ($existingCustomer && $existingCustomer->data && $existingCustomer->updated_at) {
                $oldData = is_array($existingCustomer->data) ? $existingCustomer->data : json_decode($existingCustomer->data, true);
                
                // Check if we have valid courier data
                $hasValidData = isset($oldData['courierData']['summary']);
                
                // Check if last update was within the cache period
                $daysSinceLastUpdate = $existingCustomer->updated_at->diffInDays(now());
                $isWithinCachePeriod = $daysSinceLastUpdate < $cacheDays;
                
                // If we have valid data and within cache period, return cached data
                if ($hasValidData && $isWithinCachePeriod) {
                    // Get subscription context
                    $user = $request->user();
                    $activeSubscription = $user->activeSubscription;
                    
                    // Update customer search count (don't update last_searched_at to preserve cache timer)
                    $existingCustomer->update([
                        'user_id' => $user->id,
                        'subscription_type' => 'api',
                        'subscription_id' => $activeSubscription->id,
                        'count' => $existingCustomer->count + 1,
                        'ip_address' => $request->ip(),
                    ]);
                    
                    // Add logos if missing from cached data
                    $oldData = $this->ensureLogosInData($oldData);
                    
                    Log::info("API: Returning database data for {$phone}. Data is {$daysSinceLastUpdate} days old, valid for {$cacheDays} days.");
                    
                    return response()->json($oldData);
                }
            }

            // Either new customer or cache expired - hit API
            Log::info("API: Hitting external API for {$phone}. Reason: " . (!$existingCustomer ? 'New customer' : 'Cache expired (data older than ' . $cacheDays . ' days)'));
            
            $oldData = null;
            $oldTotalParcel = 0;

            if ($existingCustomer && $existingCustomer->data) {
                $oldData = is_array($existingCustomer->data) ? $existingCustomer->data : json_decode($existingCustomer->data, true);
                $oldTotalParcel = $oldData['courierData']['summary']['total_parcel'] ?? 0;
            }

            // Try primary API first
            $responseData = $this->callCourierApi($phone);
            
            // If primary API fails, try fallback API
            if ($responseData === null) {
                $responseData = $this->callFallbackCourierApi($phone);
            }
            
            // If both APIs fail, return error or old data if available
            if ($responseData === null) {
                if ($oldData) {
                    return response()->json($this->ensureLogosInData($oldData));
                }
                return response()->json([
                    'success' => false,
                    'error' => 'External API Error',
                    'message' => 'Failed to fetch courier data. Please try again later.',
                    'courierData' => [
                        'summary' => [
                            'total_parcel' => 0,
                            'success_parcel' => 0,
                            'cancelled_parcel' => 0,
                            'success_ratio' => 0
                        ]
                    ],
                    'reports' => []
                ], 502);
            }

            $newTotalParcel = $responseData['courierData']['summary']['total_parcel'] ?? 0;

            // Compare API total_parcel with database total_parcel
            // If API has less parcels than database, don't update - return database data
            // If API has more or equal parcels, update database with API data
            if ($oldData && $newTotalParcel < $oldTotalParcel) {
                Log::info("API total_parcel ({$newTotalParcel}) < Database total_parcel ({$oldTotalParcel}) for {$phone}. Keeping database data.");
                
                // Update only search metadata, NOT the data
                if ($existingCustomer) {
                    $user = $request->user();
                    $activeSubscription = $user->activeSubscription;
                    
                    $existingCustomer->update([
                        'user_id' => $user->id,
                        'subscription_type' => 'api',
                        'subscription_id' => $activeSubscription->id,
                        'count' => $existingCustomer->count + 1,
                        'last_searched_at' => \Carbon\Carbon::now('Asia/Dhaka'),
                        'ip_address' => $request->ip(),
                    ]);
                }
                
                // Return database data (with logos)
                return response()->json($this->ensureLogosInData($oldData));
            }

            // API has more or equal parcels - update database with new data
            Log::info("API total_parcel ({$newTotalParcel}) >= Database total_parcel ({$oldTotalParcel}) for {$phone}. Updating with API data.");

            // Get subscription context (user comes from ApiSubscriptionAuth middleware)
            $user = $request->user(); // This comes from middleware
            $apiKeyRecord = $request->get('api_key_record'); // This comes from middleware
            $activeSubscription = $user->activeSubscription;
            
            $userId = $user->id;
            $subscriptionType = 'api';
            $subscriptionId = $activeSubscription->id;

            // Update or create customer record with new API data
            if ($existingCustomer) {
                $existingCustomer->update([
                    'user_id' => $userId,
                    'subscription_type' => $subscriptionType,
                    'subscription_id' => $subscriptionId,
                    'search_by' => 'api',
                    'ip_address' => $request->ip(),
                    'last_searched_at' => \Carbon\Carbon::now('Asia/Dhaka'),
                    'count' => $existingCustomer->count + 1,
                    'data' => $responseData // Update with new API data
                ]);
            } else {
                Customer::create([
                    'phone' => $phone,
                    'user_id' => $userId,
                    'subscription_type' => $subscriptionType,
                    'subscription_id' => $subscriptionId,
                    'search_by' => 'api',
                    'ip_address' => $request->ip(),
                    'last_searched_at' => \Carbon\Carbon::now('Asia/Dhaka'),
                    'count' => 1,
                    'data' => $responseData,
                ]);
            }

            // Process reports from the API response
            $this->processReports($responseData, $phone);

            // Return the new API data
            return response()->json($responseData);

        } catch (\Illuminate\Http\Client\RequestException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Network Error',
                'message' => 'Failed to connect to courier service. Please try again later.'
            ], 503);
        } catch (\Exception $e) {
            Log::error('API Courier Check Error', [
                'phone' => $phone,
                'user_id' => $request->user()->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Server Error',
                'message' => 'An unexpected error occurred while processing your request. Please try again later.'
            ], 500);
        }
    }

    /**
     * Get the active token for API calls
     * Implements token rotation with cooldown
     */
    private function getActiveToken()
    {
        $token1 = env('BDCOURIER_TOKEN_1');
        $token2 = env('BDCOURIER_TOKEN_2');
        $cooldownMinutes = (int) env('BDCOURIER_TOKEN_COOLDOWN_MINUTES', 30);
        
        // Get token status from cache
        $token1Cooldown = Cache::get('bdcourier_token1_cooldown');
        $token2Cooldown = Cache::get('bdcourier_token2_cooldown');
        
        // If token 1 is not on cooldown, use it
        if (!$token1Cooldown && $token1) {
            return ['token' => $token1, 'key' => 'token1'];
        }
        
        // If token 2 is not on cooldown, use it
        if (!$token2Cooldown && $token2) {
            return ['token' => $token2, 'key' => 'token2'];
        }
        
        // Both on cooldown - check which one expires first
        $token1ExpiresAt = Cache::get('bdcourier_token1_cooldown_expires');
        $token2ExpiresAt = Cache::get('bdcourier_token2_cooldown_expires');
        
        if ($token1ExpiresAt && $token2ExpiresAt) {
            if ($token1ExpiresAt < $token2ExpiresAt) {
                return ['token' => $token1, 'key' => 'token1'];
            }
            return ['token' => $token2, 'key' => 'token2'];
        }
        
        return ['token' => $token1, 'key' => 'token1'];
    }

    /**
     * Put a token on cooldown until midnight BDT (Bangladesh Time)
     * Token will be available again at 12:00 AM BDT
     */
    private function putTokenOnCooldown($tokenKey)
    {
        // Get current time in Bangladesh timezone
        $nowBDT = now()->timezone('Asia/Dhaka');
        
        // Calculate midnight BDT (next day at 00:00:00)
        $midnightBDT = $nowBDT->copy()->addDay()->startOfDay();
        
        // Convert to UTC for cache storage
        $expiresAt = $midnightBDT->timezone('UTC');
        
        Cache::put("bdcourier_{$tokenKey}_cooldown", true, $expiresAt);
        Cache::put("bdcourier_{$tokenKey}_cooldown_expires", $expiresAt, $expiresAt);
        
        Log::info("BDCourier {$tokenKey} put on cooldown until midnight BDT ({$midnightBDT->format('Y-m-d H:i:s')} BDT)");
    }

    /**
     * Mark token as working (remove from cooldown)
     */
    private function markTokenAsWorking($tokenKey)
    {
        Cache::forget("bdcourier_{$tokenKey}_cooldown");
        Cache::forget("bdcourier_{$tokenKey}_cooldown_expires");
    }

    /**
     * Call primary courier API with token rotation
     */
    private function callCourierApi($phone)
    {
        $activeToken = $this->getActiveToken();
        $result = $this->makeApiCall($phone, $activeToken['token']);
        
        if ($result !== null) {
            $this->markTokenAsWorking($activeToken['key']);
            return $result;
        }
        
        $this->putTokenOnCooldown($activeToken['key']);
        
        $token1 = env('BDCOURIER_TOKEN_1');
        $token2 = env('BDCOURIER_TOKEN_2');
        $otherToken = $activeToken['key'] === 'token1' 
            ? ['token' => $token2, 'key' => 'token2']
            : ['token' => $token1, 'key' => 'token1'];
        
        if ($otherToken['token']) {
            $result = $this->makeApiCall($phone, $otherToken['token']);
            
            if ($result !== null) {
                $this->markTokenAsWorking($otherToken['key']);
                return $result;
            }
            
            $this->putTokenOnCooldown($otherToken['key']);
        }
        
        return null;
    }

    /**
     * Make the actual API call with a specific token
     */
    private function makeApiCall($phone, $token)
    {
        if (!$token) {
            return null;
        }
        
        try {
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('https://api.bdcourier.com/courier-check', [
                'phone' => $phone,
            ]);

            if ($response->status() === 429 || $response->status() === 401 || $response->status() === 403) {
                Log::warning('BDCourier API token error', [
                    'status' => $response->status(),
                    'phone' => $phone
                ]);
                return null;
            }

            if (!$response->successful()) {
                return null;
            }

            $apiData = $response->json();
            
            if (isset($apiData['status']) && $apiData['status'] === 'error') {
                Log::warning('BDCourier API returned error', [
                    'message' => $apiData['message'] ?? 'Unknown error',
                    'phone' => $phone
                ]);
                return null;
            }
            
            return $this->transformApiResponse($apiData);
        } catch (\Exception $e) {
            Log::warning('BDCourier API call failed', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Call fallback courier API
     * Uses the old API format
     */
    private function callFallbackCourierApi($phone)
    {
        try {
            $token = env('BDCOURIER_FALLBACK_TOKEN');
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => $token,
            ])->post('https://bdcourier.com/api/courier-check', [
                'phone' => $phone,
            ]);

            if (!$response->successful()) {
                return null;
            }

            $apiData = $response->json();
            
            // Check if it's already in old format or needs transformation
            if (isset($apiData['courierData'])) {
                return $this->ensureLogosInData($apiData);
            }
            
            // Transform new format to old format for backward compatibility
            return $this->transformApiResponse($apiData);
        } catch (\Exception $e) {
            Log::warning('Fallback courier API failed', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get default logos for couriers
     */
    private function getDefaultLogos()
    {
        $baseUrl = 'https://fraudshieldbd.site/c-logo';
        return [
            'pathao' => $baseUrl . '/pathao-logo.png',
            'steadfast' => $baseUrl . '/steadfast-logo.png',
            'parceldex' => $baseUrl . '/parceldex-logo.png',
            'redx' => $baseUrl . '/redx-logo.png',
            'paperfly' => $baseUrl . '/paperfly-logo.png',
            'carrybee' => $baseUrl . '/carrybee-logo.webp',
            'sundarban' => $baseUrl . '/sundarban-logo.png',
            'dex' => $baseUrl . '/dex-logo.png',
        ];
    }

    /**
     * Ensure logos are present in data and replace external URLs with our domain
     * Adds default logos if missing, replaces bdcourier URLs with fraudshieldbd.site
     */
    private function ensureLogosInData($data)
    {
        $defaultLogos = $this->getDefaultLogos();
        
        if (isset($data['courierData'])) {
            foreach ($data['courierData'] as $key => &$value) {
                if ($key !== 'summary' && is_array($value)) {
                    if (!isset($value['logo']) || empty($value['logo'])) {
                        $value['logo'] = $defaultLogos[strtolower($key)] ?? '';
                    } else {
                        // Replace bdcourier URLs with our domain
                        $value['logo'] = str_replace(
                            'https://api.bdcourier.com/c-logo',
                            'https://fraudshieldbd.site/c-logo',
                            $value['logo']
                        );
                    }
                    if (!isset($value['name']) || empty($value['name'])) {
                        $value['name'] = ucfirst($key);
                    }
                }
            }
        }
        
        return $data;
    }

    /**
     * Transform new API response format to old format
     * New format has 'data' key, old format has 'courierData' key
     */
    private function transformApiResponse($apiData)
    {
        // Get default logos
        $defaultLogos = $this->getDefaultLogos();

        // If already in old format, add logos if missing
        if (isset($apiData['courierData'])) {
            foreach ($apiData['courierData'] as $key => &$value) {
                if ($key !== 'summary' && is_array($value)) {
                    if (!isset($value['logo']) || empty($value['logo'])) {
                        $value['logo'] = $defaultLogos[strtolower($key)] ?? '';
                    }
                    if (!isset($value['name']) || empty($value['name'])) {
                        $value['name'] = ucfirst($key);
                    }
                }
            }
            return $apiData;
        }

        // Check if it's the new format with 'data' key
        if (isset($apiData['data']) && isset($apiData['status']) && $apiData['status'] === 'success') {
            $data = $apiData['data'];
            
            // Extract summary
            $summary = $data['summary'] ?? [
                'total_parcel' => 0,
                'success_parcel' => 0,
                'cancelled_parcel' => 0,
                'success_ratio' => 0
            ];
            
            // Build courierData in old format
            $courierData = [];
            foreach ($data as $key => $value) {
                if ($key === 'summary') {
                    $courierData['summary'] = [
                        'total_parcel' => (int) ($summary['total_parcel'] ?? 0),
                        'success_parcel' => (int) ($summary['success_parcel'] ?? 0),
                        'cancelled_parcel' => (int) ($summary['cancelled_parcel'] ?? 0),
                        'success_ratio' => (float) ($summary['success_ratio'] ?? 0)
                    ];
                } else {
                    // Courier specific data - ensure numeric values are integers
                    $logo = $value['logo'] ?? '';
                    if (empty($logo)) {
                        $logo = $defaultLogos[strtolower($key)] ?? '';
                    } else {
                        // Replace bdcourier URLs with our domain
                        $logo = str_replace(
                            'https://api.bdcourier.com/c-logo',
                            'https://fraudshieldbd.site/c-logo',
                            $logo
                        );
                    }
                    $courierData[$key] = [
                        'name' => $value['name'] ?? ucfirst($key),
                        'logo' => $logo,
                        'total_parcel' => (int) ($value['total_parcel'] ?? 0),
                        'success_parcel' => (int) ($value['success_parcel'] ?? 0),
                        'cancelled_parcel' => (int) ($value['cancelled_parcel'] ?? 0),
                        'success_ratio' => (float) ($value['success_ratio'] ?? 0)
                    ];
                }
            }
            
            return [
                'courierData' => $courierData,
                'reports' => $apiData['reports'] ?? []
            ];
        }

        // Unknown format, return as-is
        return $apiData;
    }

    /**
     * Process reports from API response and store as customer reviews
     */
    private function processReports($responseData, $searchedPhone)
    {
        // Check if reports exist in the response
        if (!isset($responseData['reports']) || !is_array($responseData['reports']) || empty($responseData['reports'])) {
            return;
        }

        // Find or create the customer record for the searched phone
        $customer = Customer::where('phone', $searchedPhone)->first();
        if (!$customer) {
            // If customer doesn't exist, create one
            $customer = Customer::create([
                'phone' => $searchedPhone,
                'count' => 1,
                'data' => [],
                'search_by' => 'api',
                'ip_address' => request()->ip() ?? '127.0.0.1',
                'last_searched_at' => now(),
            ]);
        }

        // Process each report
        foreach ($responseData['reports'] as $report) {
            // In the report data:
            // - 'phone' field contains the phone number being reported (same as searchedPhone)
            // - 'name' field contains the name of the person being reported
            // - 'user_id' represents the person who made the report
            
            $reportCreatedAt = isset($report['created_at']) ? $report['created_at'] : null;
            $reportId = isset($report['id']) ? $report['id'] : null;
            $reportedPhone = $report['phone']; // This is the phone being reported
            $reportedName = $report['name']; // This is the name of person being reported
            $reporterUserId = $report['user_id'] ?? null; // This is who made the report
            
            // First check if we already have this specific report ID stored
            if ($reportId) {
                $existingReviewWithId = CustomerReview::where('phone', $searchedPhone)
                    ->where('comment', 'LIKE', '%Report ID: ' . $reportId . '%')
                    ->first();
                
                if ($existingReviewWithId) {
                    continue; // Skip this report as it's already stored
                }
            }
            
            // Fallback check: if no report ID, check by content and reporter user ID
            if (!$reportId) {
                $existingReview = CustomerReview::where('phone', $searchedPhone)
                    ->where('commenter_phone', $reporterUserId ? 'user_' . $reporterUserId : 'unknown')
                    ->where('name', $reportedName)
                    ->where('comment', 'LIKE', '%' . substr($report['details'], 0, 50) . '%')
                    ->first();

                if ($existingReview) {
                    continue; // Skip if similar review exists
                }
            }

            // Prepare comment with metadata to ensure uniqueness
            $comment = $report['details'];
            if ($reportId) {
                $comment .= " [Report ID: {$reportId}]";
            }
            if ($reportCreatedAt) {
                $comment .= " [Reported on: {$reportCreatedAt}]";
            }
            if ($reporterUserId) {
                $comment .= " [Reporter User ID: {$reporterUserId}]";
            }

            // Create new customer review from report
            $review = CustomerReview::create([
                'phone' => $searchedPhone, // The phone number being reported (target)
                'commenter_phone' => $reporterUserId ? 'user_' . $reporterUserId : 'unknown', // The person who made the report
                'customer_id' => $customer->id,
                'name' => $reportedName, // Name of the person being reported
                'rating' => 1.0, // Default rating for fraud reports (negative review)
                'comment' => $comment,
            ]);
            
            // If we want to preserve the original report timestamp, update it after creation
            if ($reportCreatedAt) {
                $review->created_at = $reportCreatedAt;
                $review->save();
            }
        }
    }
}