<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerReview;
use App\Models\WebsiteSubscription;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;


class CourierController extends Controller
{
    public function check(Request $request)
    {
        $phone = $request->input('phone');

        // Get existing customer data
        $existingCustomer = Customer::where('phone', $phone)->first();
        
        // Configuration
        $cacheDays = 3; // Data is valid for 3 days
        $maxSearchesBeforeApiCall = 3; // Hit API on 3rd search within the period
        
        // If customer exists and has data, check if we should return cached data
        if ($existingCustomer && $existingCustomer->data) {
            $oldData = is_array($existingCustomer->data) ? $existingCustomer->data : json_decode($existingCustomer->data, true);
            
            // Check if we have valid courier data
            $hasValidData = isset($oldData['courierData']['summary']);
            
            // Check if last API call was within the cache period (3 days)
            $lastApiCall = Cache::get("customer_{$phone}_last_api_call");
            $searchCountInPeriod = (int) Cache::get("customer_{$phone}_search_count", 0);
            
            // If no record of last API call, check last_searched_at from database
            if (!$lastApiCall && $existingCustomer->last_searched_at) {
                $daysSinceLastSearch = $existingCustomer->last_searched_at->diffInDays(now());
                $isWithinCachePeriod = $daysSinceLastSearch < $cacheDays;
            } else {
                $isWithinCachePeriod = $lastApiCall !== null;
            }
            
            // Increment search count for this period
            $searchCountInPeriod++;
            
            // If we have valid data, within cache period, and haven't reached max searches
            if ($hasValidData && $isWithinCachePeriod && $searchCountInPeriod < $maxSearchesBeforeApiCall) {
                // Update search count in cache (expires at end of cache period)
                $cacheExpiry = now()->addDays($cacheDays);
                Cache::put("customer_{$phone}_search_count", $searchCountInPeriod, $cacheExpiry);
                
                // Update customer record
                $existingCustomer->update([
                    'count' => $existingCustomer->count + 1,
                    'last_searched_at' => \Carbon\Carbon::now('Asia/Dhaka'),
                    'ip_address' => $request->ip(),
                ]);
                
                // Add logos if missing from cached data
                $oldData = $this->ensureLogosInData($oldData);
                
                Log::info("Returning cached data for {$phone}. Search {$searchCountInPeriod} of {$maxSearchesBeforeApiCall} in {$cacheDays} day period.");
                
                return $oldData;
            }
            
            // Reset search count as we're hitting API
            Cache::forget("customer_{$phone}_search_count");
        }
        
        // Either new customer, data older than 3 days, or 3rd search - hit API
        Log::info("Hitting API for {$phone}. Reason: " . (!$existingCustomer ? 'New customer' : 'Cache expired or max searches reached'));
        
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
                return $oldData;
            }
            return [
                'status' => 'error',
                'message' => 'Unable to fetch courier data. Please try again later.',
                'courierData' => [
                    'summary' => [
                        'total_parcel' => 0,
                        'success_parcel' => 0,
                        'cancelled_parcel' => 0,
                        'success_ratio' => 0
                    ]
                ],
                'reports' => []
            ];
        }

        $newTotalParcel = $responseData['courierData']['summary']['total_parcel'] ?? 0;

        // Compare API total_parcel with database total_parcel
        // If API has less parcels than database, don't update - return database data
        // If API has more or equal parcels, update database with API data
        if ($oldData && $newTotalParcel < $oldTotalParcel) {
            Log::info("API total_parcel ({$newTotalParcel}) < Database total_parcel ({$oldTotalParcel}) for {$phone}. Keeping database data.");
            
            // Update only search metadata, NOT the data
            if ($existingCustomer) {
                $existingCustomer->update([
                    'count' => $existingCustomer->count + 1,
                    'last_searched_at' => \Carbon\Carbon::now('Asia/Dhaka'),
                    'ip_address' => $request->ip(),
                ]);
            }
            
            // Set cache for search tracking
            $cacheDays = 3;
            $cacheExpiry = now()->addDays($cacheDays);
            Cache::put("customer_{$phone}_last_api_call", now(), $cacheExpiry);
            Cache::put("customer_{$phone}_search_count", 1, $cacheExpiry);
            
            // Return database data (with logos)
            return $this->ensureLogosInData($oldData);
        }

        // API has more or equal parcels - update database with new data
        Log::info("API total_parcel ({$newTotalParcel}) >= Database total_parcel ({$oldTotalParcel}) for {$phone}. Updating with API data.");

        // Get subscription context for logged-in users
        $userId = null;
        $subscriptionType = null;
        $subscriptionId = null;
        
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;
            
            // Check for active website subscription first
            $websiteSubscription = WebsiteSubscription::getActiveForUser($user->id);
            if ($websiteSubscription && $websiteSubscription->isActive()) {
                $subscriptionType = 'website';
                $subscriptionId = $websiteSubscription->id;
            } else {
                // Check for API subscription as fallback
                $apiSubscription = $user->activeSubscription;
                if ($apiSubscription) {
                    $subscriptionType = 'api';
                    $subscriptionId = $apiSubscription->id;
                }
            }
        }

        // Update or create customer record with new API data
        if ($existingCustomer) {
            $existingCustomer->update([
                'user_id' => $userId,
                'subscription_type' => $subscriptionType,
                'subscription_id' => $subscriptionId,
                'search_by' => 'web',
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
                'search_by' => 'web',
                'ip_address' => $request->ip(),
                'last_searched_at' => \Carbon\Carbon::now('Asia/Dhaka'),
                'count' => 1,
                'data' => $responseData,
            ]);
        }

        // Set cache to track API call time and reset search count
        $cacheDays = 3;
        $cacheExpiry = now()->addDays($cacheDays);
        Cache::put("customer_{$phone}_last_api_call", now(), $cacheExpiry);
        Cache::put("customer_{$phone}_search_count", 1, $cacheExpiry); // This is the 1st search after API call

        // Process reports from the API response
        $this->processReports($responseData, $phone);

        return $responseData; // Return new API data
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
                'data' => json_encode([]),
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
            // Return the one that expires first
            if ($token1ExpiresAt < $token2ExpiresAt) {
                return ['token' => $token1, 'key' => 'token1'];
            }
            return ['token' => $token2, 'key' => 'token2'];
        }
        
        // Default to token 1
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
     * Uses the new API format with bdc_ prefix token
     */
    private function callCourierApi($phone)
    {
        // Try with first available token
        $activeToken = $this->getActiveToken();
        $result = $this->makeApiCall($phone, $activeToken['token']);
        
        if ($result !== null) {
            // Success - mark token as working
            $this->markTokenAsWorking($activeToken['key']);
            return $result;
        }
        
        // First token failed - put on cooldown and try the other
        $this->putTokenOnCooldown($activeToken['key']);
        
        // Get the other token
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
            
            // Both tokens failed
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

            // Check for rate limit or auth errors
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
            
            // Check for error in response body
            if (isset($apiData['status']) && $apiData['status'] === 'error') {
                Log::warning('BDCourier API returned error', [
                    'message' => $apiData['message'] ?? 'Unknown error',
                    'phone' => $phone
                ]);
                return null;
            }
            
            // Transform new format to old format for backward compatibility
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
     * Ensure logos are present in data
     * Adds default logos if missing
     */
    private function ensureLogosInData($data)
    {
        $defaultLogos = $this->getDefaultLogos();
        
        if (isset($data['courierData'])) {
            foreach ($data['courierData'] as $key => &$value) {
                if ($key !== 'summary' && is_array($value)) {
                    if (!isset($value['logo']) || empty($value['logo'])) {
                        $value['logo'] = $defaultLogos[strtolower($key)] ?? '';
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
     * Get default logos for couriers
     */
    private function getDefaultLogos()
    {
        return [
            'pathao' => 'https://api.bdcourier.com/c-logo/pathao-logo.png',
            'steadfast' => 'https://api.bdcourier.com/c-logo/steadfast-logo.png',
            'parceldex' => 'https://api.bdcourier.com/c-logo/parceldex-logo.png',
            'redx' => 'https://api.bdcourier.com/c-logo/redx-logo.png',
            'paperfly' => 'https://api.bdcourier.com/c-logo/paperfly-logo.png',
            'carrybee' => 'https://api.bdcourier.com/c-logo/carrybee-logo.webp',
            'sundarban' => 'https://api.bdcourier.com/c-logo/sundarban-logo.png',
            'dex' => 'https://api.bdcourier.com/c-logo/dex-logo.png',
        ];
    }

    /**
     * Authenticate user by token
     */
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Token is required',
                'errors' => $validator->errors()
            ], 422);
        }

        $token = $request->input('token');
        $hashedToken = '$2y$10$uOsq1UWVr/t1oX7jxW0fseLRJI6mWbR6VQfCP5r0NJVVqgXkpi09C';

        // Check if the provided token matches the hashed token
        if (!Hash::check($token, $hashedToken)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token. Access denied.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Authentication successful'
        ]);
    }

    /**
     * Process DataTables ajax request for customer data
     */
    public function getCustomerData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Token is required',
                'errors' => $validator->errors()
            ], 422);
        }

        $token = $request->input('token');
        $hashedToken = '$2y$10$uOsq1UWVr/t1oX7jxW0fseLRJI6mWbR6VQfCP5r0NJVVqgXkpi09C';

        // Check if the provided token matches the hashed token
        if (!Hash::check($token, $hashedToken)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token. Access denied.'
            ], 403);
        }

        // Process DataTables request
        return DataTables::of(Customer::query())
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * Original list method (kept for reference)
     */
    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Token is required',
                'errors' => $validator->errors()
            ], 422);
        }

        $token = $request->input('token');
        $hashedToken = '$2y$10$uOsq1UWVr/t1oX7jxW0fseLRJI6mWbR6VQfCP5r0NJVVqgXkpi09C';

        // Check if the provided token matches the hashed token
        if (!Hash::check($token, $hashedToken)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Fetch customer data
        $customers = Customer::all();

        // Transform the data if needed
        $customers = $customers->map(function ($customer) {
            return [
                'id' => $customer->id,
                'phone' => $customer->phone,
                'count' => $customer->count,
                'data' => $customer->data
            ];
        });

        return response()->json([
            'success' => true,
            'customers' => $customers
        ]);
    }


    public function showTokenForm()
    {
        return view('list');
    }
}
