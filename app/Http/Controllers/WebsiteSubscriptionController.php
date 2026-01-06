<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WebsiteSubscription;
use Inertia\Inertia;

class WebsiteSubscriptionController extends Controller
{
    /**
     * Show subscription plans
     */
    public function index()
    {
        $plans = WebsiteSubscription::getPlanDetails();
        $activeSubscription = null;
        
        if (Auth::check()) {
            $activeSubscription = WebsiteSubscription::getActiveForUser(Auth::id());
        }
        
        return Inertia::render('WebsiteSubscriptions/Index', [
            'plans' => $plans,
            'activeSubscription' => $activeSubscription,
        ]);
    }

    /**
     * Show subscription purchase form
     */
    public function subscribe(Request $request, $plan)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to subscribe');
        }

        $plans = WebsiteSubscription::getPlanDetails();
        
        if (!array_key_exists($plan, $plans)) {
            return redirect()->route('website.subscriptions')->with('error', 'Invalid plan selected');
        }

        $selectedPlan = $plans[$plan];
        $selectedPlan['type'] = $plan;

        return Inertia::render('WebsiteSubscriptions/Subscribe', [
            'selectedPlan' => $selectedPlan,
        ]);
    }

    /**
     * Process subscription purchase
     */
    public function processSubscription(Request $request, $plan)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login first']);
        }

        $request->validate([
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
        ]);

        $user = Auth::user();
        
        // Check if user already has active subscription
        $existingSubscription = WebsiteSubscription::getActiveForUser($user->id);
        if ($existingSubscription) {
            return response()->json([
                'success' => false, 
                'message' => 'You already have an active subscription'
            ]);
        }

        $plans = WebsiteSubscription::getPlanDetails();
        if (!array_key_exists($plan, $plans)) {
            return response()->json(['success' => false, 'message' => 'Invalid plan selected']);
        }

        try {
            $subscription = WebsiteSubscription::createForUser($user->id, $plan);
            
            // Update with payment information
            $subscription->update([
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Subscription activated successfully!',
                'subscription' => [
                    'plan' => $plans[$plan]['name'],
                    'expires_at' => $subscription->expires_at->format('d M Y, h:i A'),
                    'amount' => $subscription->formatted_amount,
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process subscription. Please try again.'
            ]);
        }
    }

    /**
     * Get user subscription status
     */
    public function getStatus()
    {
        if (!Auth::check()) {
            return response()->json(['subscribed' => false]);
        }

        $subscription = WebsiteSubscription::getActiveForUser(Auth::id());
        
        return response()->json([
            'subscribed' => $subscription ? true : false,
            'subscription' => $subscription ? [
                'plan' => $subscription->plan_type,
                'expires_at' => $subscription->expires_at->format('d M Y, h:i A'),
                'days_remaining' => $subscription->days_remaining,
                'amount' => $subscription->formatted_amount,
            ] : null
        ]);
    }

    /**
     * Get subscription plans for AJAX
     */
    public function getPlans()
    {
        return response()->json([
            'plans' => WebsiteSubscription::getPlanDetails()
        ]);
    }
}
