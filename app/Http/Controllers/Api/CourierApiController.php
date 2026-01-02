<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

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
            // Get existing customer data before making API call
            $existingCustomer = Customer::where('phone', $phone)->first();
            $oldData = null;
            $oldTotalParcel = 0;

            if ($existingCustomer && $existingCustomer->data) {
                // Data is already an array due to model casting
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
                    return response()->json($oldData);
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

            // Determine which data to return
            $dataToReturn = $responseData;
            $dataToStore = $responseData; // Store as array, model will handle casting

            // If new total parcel is less than old total parcel, return old data
            if ($oldData && $newTotalParcel < $oldTotalParcel) {
                $dataToReturn = $oldData;
                // Still store the new data but return the old one
            }

            // Get subscription context (user comes from ApiSubscriptionAuth middleware)
            $user = $request->user(); // This comes from middleware
            $apiKeyRecord = $request->get('api_key_record'); // This comes from middleware
            $activeSubscription = $user->activeSubscription;
            
            $userId = $user->id;
            $subscriptionType = 'api';
            $subscriptionId = $activeSubscription->id;

            // Update or create customer record
            if ($existingCustomer) {
                $existingCustomer->update([
                    'user_id' => $userId,
                    'subscription_type' => $subscriptionType,
                    'subscription_id' => $subscriptionId,
                    'search_by' => 'api',
                    'ip_address' => $request->ip(),
                    'last_searched_at' => \Carbon\Carbon::now('Asia/Dhaka'),
                    'count' => $existingCustomer->count + 1,
                    'data' => $dataToStore // Store as array, model casting will handle it
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
                    'data' => $dataToStore,
                ]);
            }

            // Process reports from the API response
            $this->processReports($responseData, $phone);

            // Return the same format as web route but as JSON response
            return response()->json($dataToReturn);

        } catch (\Illuminate\Http\Client\RequestException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Network Error',
                'message' => 'Failed to connect to courier service. Please try again later.'
            ], 503);
        } catch (\Exception $e) {
            \Log::error('API Courier Check Error', [
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
     * Call primary courier API
     * Uses the new API format with bdc_ prefix token
     */
    private function callCourierApi($phone)
    {
        try {
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer bdc_ddsb5DmvKwfaQUHrgfduXahM5u7BZJaT66WsCdGmfqslhESGZEsZVirfVyrI',
            ])->post('https://api.bdcourier.com/courier-check', [
                'phone' => $phone,
            ]);

            if (!$response->successful()) {
                return null;
            }

            $apiData = $response->json();
            
            // Transform new format to old format for backward compatibility
            return $this->transformApiResponse($apiData);
        } catch (\Exception $e) {
            \Log::warning('Primary courier API failed', [
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
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'jcDS13SxRAtm69cANU9J1O0DjFKTlk24reQSFCsCw8EGOSG72lsgCz3R5TyG',
            ])->post('https://bdcourier.com/api/courier-check', [
                'phone' => $phone,
            ]);

            if (!$response->successful()) {
                return null;
            }

            $apiData = $response->json();
            
            // Check if it's already in old format or needs transformation
            if (isset($apiData['courierData'])) {
                return $apiData;
            }
            
            // Transform new format to old format for backward compatibility
            return $this->transformApiResponse($apiData);
        } catch (\Exception $e) {
            \Log::warning('Fallback courier API failed', [
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
        // Define default logos for each courier
        $defaultLogos = [
            'pathao' => 'https://api.bdcourier.com/c-logo/pathao-logo.png',
            'steadfast' => 'https://api.bdcourier.com/c-logo/steadfast-logo.png',
            'parceldex' => 'https://api.bdcourier.com/c-logo/parceldex-logo.png',
            'redx' => 'https://api.bdcourier.com/c-logo/redx-logo.png',
            'paperfly' => 'https://api.bdcourier.com/c-logo/paperfly-logo.png',
            'carrybee' => 'https://api.bdcourier.com/c-logo/carrybee-logo.webp',
            'sundarban' => 'https://api.bdcourier.com/c-logo/sundarban-logo.png',
            'dex' => 'https://api.bdcourier.com/c-logo/dex-logo.png',
        ];

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