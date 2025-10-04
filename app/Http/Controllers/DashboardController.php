<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\ApiUsage;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user's API keys
        $apiKeys = $user->apiKeys()->with('apiUsages')->get();
        
        // Get usage statistics
        $todayUsage = ApiUsage::where('user_id', $user->id)
                            ->whereDate('created_at', today())
                            ->count();
                            
        $monthlyUsage = ApiUsage::where('user_id', $user->id)
                              ->whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year)
                              ->count();
        
        // Get current subscription
        $activeSubscription = $user->activeSubscription;
        
        // Get available plans for upgrade
        $plans = Plan::active()->ordered()->get();
        
        // Get recent API usage
        $recentUsage = ApiUsage::where('user_id', $user->id)
                             ->with('apiKey')
                             ->latest()
                             ->take(10)
                             ->get();
        
        return view('dashboard.index', compact(
            'user', 
            'apiKeys', 
            'todayUsage', 
            'monthlyUsage', 
            'activeSubscription', 
            'plans',
            'recentUsage'
        ));
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
        return view('dashboard.api-docs');
    }
}
