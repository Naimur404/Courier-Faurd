<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use App\Models\Customer;
use App\Models\CustomerReview;
use App\Models\WebsiteSubscription;
use App\Models\BdCourierToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;


class CourierController extends Controller
{
    public function check(Request $request)
    {
        $phone = $request->input('phone');

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
                // Update customer search count (don't update last_searched_at to preserve cache timer)
                $existingCustomer->update([
                    'count' => $existingCustomer->count + 1,
                    'ip_address' => $request->ip(),
                ]);

                // Add logos if missing from cached data
                $oldData = $this->ensureLogosInData($oldData);

                Log::info("Returning database data for {$phone}. Data is {$daysSinceLastUpdate} days old, valid for {$cacheDays} days.");

                return $oldData;
            }
        }

        // Either new customer or cache expired - hit API
        Log::info("Hitting API for {$phone}. Reason: " . (!$existingCustomer ? 'New customer' : 'Cache expired (data older than ' . $cacheDays . ' days)'));

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
                    'last_searched_at' => Carbon::now('Asia/Dhaka'),
                    'ip_address' => $request->ip(),
                ]);
            }

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
                'last_searched_at' => Carbon::now('Asia/Dhaka'),
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
                'last_searched_at' => Carbon::now('Asia/Dhaka'),
                'count' => 1,
                'data' => $responseData,
            ]);
        }

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
     * Get the active token for API calls from database
     * Implements token rotation with cooldown until midnight BDT
     */
    private function getActiveToken()
    {
        $token = BdCourierToken::getAvailableToken();
        
        if ($token) {
            return ['token' => $token->token, 'model' => $token];
        }
        
        // No tokens available - all on cooldown
        Log::warning("All BDCourier tokens are on cooldown!");
        return ['token' => null, 'model' => null];
    }

    /**
     * Put a token on cooldown until midnight BDT (Bangladesh Time)
     */
    private function putTokenOnCooldown($tokenModel)
    {
        if ($tokenModel instanceof BdCourierToken) {
            $tokenModel->putOnCooldown();
        }
    }

    /**
     * Record successful usage of token
     */
    private function markTokenAsWorking($tokenModel)
    {
        if ($tokenModel instanceof BdCourierToken) {
            $tokenModel->recordUsage();
        }
    }

    /**
     * Call primary courier API with token rotation
     * Uses database-based token management
     */
    private function callCourierApi($phone)
    {
        // Get all available tokens and try them one by one
        $maxAttempts = BdCourierToken::where('is_active', true)->count();
        $attemptedTokenIds = [];
        
        for ($i = 0; $i < $maxAttempts; $i++) {
            $activeToken = $this->getActiveToken();
            
            if (!$activeToken['token'] || !$activeToken['model']) {
                Log::warning("No available tokens for API call");
                break;
            }
            
            // Skip if we already tried this token
            if (in_array($activeToken['model']->id, $attemptedTokenIds)) {
                break;
            }
            $attemptedTokenIds[] = $activeToken['model']->id;
            
            $result = $this->makeApiCall($phone, $activeToken['token']);
            
            if ($result !== null) {
                // Success - record usage
                $this->markTokenAsWorking($activeToken['model']);
                return $result;
            }
            
            // Token failed - put on cooldown and try next
            $this->putTokenOnCooldown($activeToken['model']);
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
