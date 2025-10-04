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
use Yajra\DataTables\Facades\DataTables;


class CourierController extends Controller
{
    public function check(Request $request)
    {
        $phone = $request->input('phone');

        // Get existing customer data before making API call
        $existingCustomer = Customer::where('phone', $phone)->first();
        $oldData = null;
        $oldTotalParcel = 0;

        if ($existingCustomer && $existingCustomer->data) {
            // Data is already an array due to model casting
            $oldData = is_array($existingCustomer->data) ? $existingCustomer->data : json_decode($existingCustomer->data, true);
            $oldTotalParcel = $oldData['courierData']['summary']['total_parcel'] ?? 0;
        }

        $response = Http::withHeaders([
            'Authorization' => 'jcDS13SxRAtm69cANU9J1O0DjFKTlk24reQSFCsCw8EGOSG72lsgCz3R5TyG',
        ])->post('https://bdcourier.com/api/courier-check', [
            'phone' => $phone,
        ]);

        $responseData = $response->json(); // Get response as array
        $newTotalParcel = $responseData['courierData']['summary']['total_parcel'] ?? 0;

        // Determine which data to return
        $dataToReturn = $responseData;
        $dataToStore = $responseData; // Store as array, model will handle casting

        // If new total parcel is less than old total parcel, return old data
        if ($oldData && $newTotalParcel < $oldTotalParcel) {
            $dataToReturn = $oldData;
            // Still store the new data but return the old one
        }

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

        // Update or create customer record
        if ($existingCustomer) {
            $existingCustomer->update([
                'user_id' => $userId,
                'subscription_type' => $subscriptionType,
                'subscription_id' => $subscriptionId,
                'search_by' => 'web',
                'ip_address' => $request->ip(),
                'last_searched_at' => now(),
                'count' => $existingCustomer->count + 1,
                'data' => $dataToStore // Store as array, model casting will handle it
            ]);
        } else {
            Customer::create([
                'phone' => $phone,
                'user_id' => $userId,
                'subscription_type' => $subscriptionType,
                'subscription_id' => $subscriptionId,
                'search_by' => 'web',
                'ip_address' => $request->ip(),
                'last_searched_at' => now(),
                'count' => 1,
                'data' => $dataToStore,
            ]);
        }

        // Process reports from the API response
        $this->processReports($responseData, $phone);

        return $dataToReturn; // Return either old or new data based on total_parcel comparison
    }

    public function checkFromApi(Request $request)
    {
        $phone = $request->input('phone');

        // Get existing customer data before making API call
        $existingCustomer = Customer::where('phone', $phone)->first();
        $oldData = null;
        $oldTotalParcel = 0;

        if ($existingCustomer && $existingCustomer->data) {
            // Data is already an array due to model casting
            $oldData = is_array($existingCustomer->data) ? $existingCustomer->data : json_decode($existingCustomer->data, true);
            $oldTotalParcel = $oldData['courierData']['summary']['total_parcel'] ?? 0;
        }

        $response = Http::withHeaders([
            'Authorization' => 'jcDS13SxRAtm69cANU9J1O0DjFKTlk24reQSFCsCw8EGOSG72lsgCz3R5TyG',
        ])->post('https://bdcourier.com/api/courier-check', [
            'phone' => $phone,
        ]);

        $responseData = $response->json(); // Get response as array
        $newTotalParcel = $responseData['courierData']['summary']['total_parcel'] ?? 0;

        // Determine which data to return
        $dataToReturn = $responseData;
        $dataToStore = json_encode($responseData);

        // If new total parcel is less than old total parcel, return old data
        if ($oldData && $newTotalParcel < $oldTotalParcel) {
            $dataToReturn = $oldData;
            // Still store the new data but return the old one
        }

        // Get subscription context (for API calls, we'll try to get from request or auth)
        $userId = null;
        $subscriptionType = null;
        $subscriptionId = null;
        
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;
            
            // For API calls, prioritize API subscription
            $apiSubscription = $user->activeSubscription;
            if ($apiSubscription) {
                $subscriptionType = 'api';
                $subscriptionId = $apiSubscription->id;
            } else {
                // Check for website subscription as fallback
                $websiteSubscription = WebsiteSubscription::getActiveForUser($user->id);
                if ($websiteSubscription && $websiteSubscription->isActive()) {
                    $subscriptionType = 'website';
                    $subscriptionId = $websiteSubscription->id;
                }
            }
        }

        // Update or create customer record
        if ($existingCustomer) {
            $existingCustomer->update([
                'user_id' => $userId,
                'subscription_type' => $subscriptionType,
                'subscription_id' => $subscriptionId,
                'search_by' => 'app',
                'ip_address' => $request->ip(),
                'last_searched_at' => now(),
                'count' => $existingCustomer->count + 1,
                'data' => $dataToStore // Always store the latest API response
            ]);
        } else {
            Customer::create([
                'phone' => $phone,
                'user_id' => $userId,
                'subscription_type' => $subscriptionType,
                'subscription_id' => $subscriptionId,
                'search_by' => 'app',
                'ip_address' => $request->ip(),
                'last_searched_at' => now(),
                'count' => 1,
                'data' => $dataToStore,
            ]);
        }

        // Process reports from the API response
        $this->processReports($responseData, $phone);

        return $dataToReturn; // Return either old or new data based on total_parcel comparison
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
