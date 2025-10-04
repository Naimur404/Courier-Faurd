<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PricingController extends Controller
{
    /**
     * Show pricing plans
     */
    public function index()
    {
        $plans = Plan::active()->ordered()->get();
        
        return view('pricing.index', compact('plans'));
    }

    /**
     * Show subscription form for a specific plan
     */
    public function subscribe(Plan $plan)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                           ->with('message', 'Please login to subscribe to a plan.');
        }

        $user = Auth::user();
        
        // Check if user already has an active subscription
        if ($user->hasActiveSubscription()) {
            return redirect()->route('dashboard')
                           ->with('error', 'You already have an active subscription.');
        }

        return view('pricing.subscribe', compact('plan'));
    }

    /**
     * Process subscription with manual payment
     */
    public function processSubscription(Request $request, Plan $plan)
    {
        $request->validate([
            'transaction_id' => 'required|string|max:255|unique:subscriptions,transaction_id',
            'payment_method' => 'required|in:bkash',
        ]);

        $user = Auth::user();

        // Create pending subscription
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => Subscription::STATUS_PENDING,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'amount_paid' => $plan->price,
            'admin_notes' => 'Manual payment verification required',
        ]);

        return redirect()->route('dashboard')
                       ->with('success', 'Subscription request submitted! We will verify your payment and activate your subscription within 24 hours.');
    }
}
