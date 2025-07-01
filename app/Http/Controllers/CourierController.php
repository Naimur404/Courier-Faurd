<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
        $oldData = json_decode($existingCustomer->data, true);
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

    // Update or create customer record
    if ($existingCustomer) {
        $existingCustomer->update([
            'search_by' => 'web',
            'ip_address' => $request->ip(),
            'last_searched_at' => now(),
            'count' => $existingCustomer->count + 1,
            'data' => $dataToStore // Always store the latest API response
        ]);
    } else {
        Customer::create([
            'phone' => $phone,
            'search_by' => 'web',
            'ip_address' => $request->ip(),
            'last_searched_at' => now(),
            'count' => 1,
            'data' => $dataToStore,
        ]);
    }

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
        $oldData = json_decode($existingCustomer->data, true);
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

    // Update or create customer record
    if ($existingCustomer) {
        $existingCustomer->update([
            'search_by' => 'app',
            'ip_address' => $request->ip(),
            'last_searched_at' => now(),
            'count' => $existingCustomer->count + 1,
            'data' => $dataToStore // Always store the latest API response
        ]);
    } else {
        Customer::create([
            'phone' => $phone,
            'search_by' => 'app',
            'ip_address' => $request->ip(),
            'last_searched_at' => now(),
            'count' => 1,
            'data' => $dataToStore,
        ]);
    }

    return $dataToReturn; // Return either old or new data based on total_parcel comparison
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
