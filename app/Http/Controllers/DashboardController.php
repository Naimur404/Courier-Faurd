<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\SearchHistory;
use App\Models\ApiKey;
use App\Models\ApiUsage;
use App\Models\Plan;
use App\Models\WebsiteSubscription;
use App\Models\WebSubscriptionUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user's API keys
        $apiKeys = $user->apiKeys()->with('apiUsages')->get()->map(function ($key) {
            return [
                'id' => $key->id,
                'name' => $key->name,
                'key' => $key->key,
                'masked_key' => $key->masked_key,
                'is_active' => $key->is_active,
                'created_at' => $key->created_at->toISOString(),
                'last_used_at' => $key->last_used_at?->toISOString(),
                'usage_count' => $key->usage_count,
            ];
        });
        
        // Get usage statistics - combine API usage and website usage
        $today = Carbon::now('Asia/Dhaka')->toDateString();
        $thisMonth = Carbon::now('Asia/Dhaka');
        
        // API usage (from API keys)
        $apiTodayUsage = ApiUsage::where('user_id', $user->id)
                            ->whereDate('created_at', today())
                            ->count();
                            
        $apiMonthlyUsage = ApiUsage::where('user_id', $user->id)
                              ->whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year)
                              ->count();
        
        // Website usage (from web searches)
        $webTodayUsage = WebSubscriptionUsage::where('user_id', $user->id)
                            ->where('usage_date', $today)
                            ->sum('hit_count');
                            
        $webMonthlyUsage = WebSubscriptionUsage::where('user_id', $user->id)
                              ->whereMonth('usage_date', $thisMonth->month)
                              ->whereYear('usage_date', $thisMonth->year)
                              ->sum('hit_count');
        
        // Also count from Customer table for searches
        $customerTodayUsage = Customer::where('user_id', $user->id)
                            ->whereDate('last_searched_at', $today)
                            ->count();
                            
        $customerMonthlyUsage = Customer::where('user_id', $user->id)
                              ->whereMonth('last_searched_at', $thisMonth->month)
                              ->whereYear('last_searched_at', $thisMonth->year)
                              ->count();
        
        // Total usage
        $todayUsage = $apiTodayUsage + $webTodayUsage + $customerTodayUsage;
        $monthlyUsage = $apiMonthlyUsage + $webMonthlyUsage + $customerMonthlyUsage;
        
        // Get current API subscription
        $activeSubscription = $user->activeSubscription;
        
        // Get current website subscription (including pending/rejected)
        // Use Bangladesh timezone for proper date comparison
        $bangladeshNow = Carbon::now('Asia/Dhaka');
        $activeWebsiteSubscription = WebsiteSubscription::where('user_id', $user->id)
                                                       ->where('status', WebsiteSubscription::STATUS_ACTIVE)
                                                       ->where('expires_at', '>', $bangladeshNow)
                                                       ->latest()
                                                       ->first();
        
        // Format subscription data for Inertia
        $subscriptionData = null;
        if ($activeSubscription) {
            $subscriptionData = [
                'id' => $activeSubscription->id,
                'plan' => [
                    'id' => $activeSubscription->plan->id,
                    'name' => $activeSubscription->plan->name,
                    'description' => $activeSubscription->plan->description,
                    'request_limit' => $activeSubscription->plan->request_limit,
                ],
                'expires_at' => $activeSubscription->expires_at?->toISOString(),
                'days_remaining' => $activeSubscription->getDaysRemainingAttribute(),
            ];
        }
        
        $websiteSubscriptionData = null;
        if ($activeWebsiteSubscription) {
            $websiteSubscriptionData = [
                'id' => $activeWebsiteSubscription->id,
                'plan_type' => $activeWebsiteSubscription->plan_type,
                'formatted_amount' => $activeWebsiteSubscription->formatted_amount,
                'verification_status' => $activeWebsiteSubscription->verification_status,
                'expires_at' => $activeWebsiteSubscription->expires_at?->toISOString(),
                'days_remaining' => $activeWebsiteSubscription->days_remaining,
                'admin_notes' => $activeWebsiteSubscription->admin_notes,
            ];
        }
        
        // Get user's search history from SearchHistory table
        $searchHistory = SearchHistory::where('user_id', $user->id)
            ->with('customer')
            ->orderBy('searched_at', 'desc')
            ->take(20)
            ->get()
            ->map(function ($search) {
                $customer = $search->customer;
                $courierBreakdown = [];
                $courierSummary = null;
                $totalParcels = 0;
                $successRatio = 0;
                
                // Get data from the related customer record if available
                if ($customer) {
                    $courierServices = $customer->courier_services;
                    $courierSummary = $customer->courier_summary;
                    $totalParcels = $customer->total_parcels;
                    $successRatio = $customer->success_ratio;
                    
                    if (is_array($courierServices)) {
                        foreach ($courierServices as $courierName => $courierData) {
                            if (is_array($courierData) && isset($courierData['total_parcel'])) {
                                $courierBreakdown[] = [
                                    'name' => $courierName,
                                    'total_parcel' => $courierData['total_parcel'] ?? 0,
                                    'success_parcel' => $courierData['success_parcel'] ?? 0,
                                    'cancelled_parcel' => $courierData['cancelled_parcel'] ?? 0,
                                    'success_ratio' => $courierData['success_ratio'] ?? 0,
                                    'logo' => $courierData['logo'] ?? null,
                                ];
                            }
                        }
                    }
                } elseif ($search->result_summary) {
                    // Use stored summary if customer record not available
                    $courierSummary = $search->result_summary;
                    $totalParcels = $search->result_summary['total_parcel'] ?? 0;
                    $successRatio = $search->result_summary['success_ratio'] ?? 0;
                }
                
                return [
                    'id' => $search->id,
                    'phone' => $search->phone,
                    'customer_id' => $search->customer_id,
                    'courier_summary' => $courierSummary,
                    'total_parcels' => $totalParcels,
                    'success_ratio' => $successRatio,
                    'courier_breakdown' => $courierBreakdown,
                    'searched_at' => $search->searched_at?->toISOString(),
                    'search_by' => $search->search_by,
                ];
            });
        
        return Inertia::render('Dashboard/Index', [
            'apiKeys' => $apiKeys,
            'todayUsage' => $todayUsage,
            'monthlyUsage' => $monthlyUsage,
            'activeSubscription' => $subscriptionData,
            'activeWebsiteSubscription' => $websiteSubscriptionData,
            'searchHistory' => $searchHistory,
            'csrfToken' => csrf_token(),
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
                'new_api_key' => session('new_api_key'),
                'new_api_secret' => session('new_api_secret'),
            ],
        ]);
    }

    /**
     * Generate new API key
     */
    public function generateApiKey(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        
        // Check if user has active subscription
        if (!$user->hasActiveSubscription()) {
            return back()->with('error', 'You need an active subscription to generate API keys.');
        }

        $apiKey = ApiKey::create([
            'user_id' => $user->id,
            'key' => ApiKey::generateKey(),
            'secret' => ApiKey::generateSecret(),
            'name' => $request->name,
            'rate_limit' => 60, // Default 60 requests per minute
            'usage_count' => 0,
            'is_active' => true,
        ]);

        return back()->with('success', 'API key generated successfully!')
                    ->with('new_api_key', $apiKey->key)
                    ->with('new_api_secret', $apiKey->secret);
    }

    /**
     * Toggle API key status
     */
    public function toggleApiKey(ApiKey $apiKey)
    {
        // Check if user owns this API key
        if ($apiKey->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $apiKey->update(['is_active' => !$apiKey->is_active]);

        $status = $apiKey->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "API key {$status} successfully!");
    }

    /**
     * Delete API key
     */
    public function deleteApiKey(ApiKey $apiKey)
    {
        // Check if user owns this API key
        if ($apiKey->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $apiKey->delete();

        return back()->with('success', 'API key deleted successfully!');
    }

    /**
     * Show API documentation
     */
    public function apiDocs()
    {
        return Inertia::render('Dashboard/ApiDocs');
    }
}
