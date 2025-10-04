@extends('layouts.app')

@section('title', 'Pricing Plans - Courier Fraud')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Choose Your Plan</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Select the perfect plan for your business needs. All plans include our comprehensive courier tracking API with real-time updates.
            </p>
        </div>

        <!-- Pricing Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">
            @foreach($plans as $plan)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden {{ $loop->index === 1 ? 'ring-2 ring-blue-500 transform scale-105' : '' }}">
                    @if($loop->index === 1)
                        <div class="bg-blue-500 text-white text-center py-2">
                            <span class="font-semibold">Most Popular</span>
                        </div>
                    @endif
                    
                    <div class="p-8">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $plan->name }}</h3>
                            <p class="text-gray-600 mt-2">{{ $plan->description }}</p>
                            
                            <div class="mt-6">
                                <span class="text-4xl font-bold text-gray-900">{{ $plan->formatted_price }}</span>
                                <span class="text-gray-500">/ {{ $plan->duration_text }}</span>
                            </div>
                        </div>

                        <!-- Features -->
                        <ul class="mt-8 space-y-4">
                            @foreach($plan->features as $feature)
                                <li class="flex items-start">
                                    <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <!-- CTA Button -->
                        <div class="mt-8">
                            @auth
                                @if(auth()->user()->hasActiveSubscription())
                                    <button disabled class="w-full bg-gray-300 text-gray-500 py-3 px-6 rounded-lg font-semibold cursor-not-allowed">
                                        Already Subscribed
                                    </button>
                                @else
                                    <a href="{{ route('pricing.subscribe', $plan) }}" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold block text-center transition duration-200">
                                        Subscribe Now
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold block text-center transition duration-200">
                                    Get Started
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Payment Information -->
        <div class="mt-16 bg-white rounded-lg shadow-lg p-8 max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Payment Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-mobile-alt text-pink-500 mr-2"></i>
                        Bkash Payment
                    </h3>
                    <div class="bg-pink-50 border border-pink-200 rounded-lg p-4">
                        <p class="text-gray-700 mb-2"><strong>Bkash Number:</strong></p>
                        <p class="text-2xl font-bold text-pink-600 mb-4">01309092748</p>
                        <p class="text-sm text-gray-600">
                            Send money to this number and provide the transaction ID during subscription.
                        </p>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-clock text-blue-500 mr-2"></i>
                        Process Timeline
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</div>
                            <span class="text-gray-700">Choose your plan and complete payment</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</div>
                            <span class="text-gray-700">Provide transaction ID in subscription form</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">3</div>
                            <span class="text-gray-700">We verify payment within 24 hours</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">4</div>
                            <span class="text-gray-700">Your subscription is activated</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-16 max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Frequently Asked Questions</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">How long does verification take?</h3>
                    <p class="text-gray-600">Payment verification typically takes 2-24 hours during business hours. You'll receive an email confirmation once activated.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I upgrade my plan?</h3>
                    <p class="text-gray-600">Yes, you can upgrade to a higher plan at any time. Contact support for assistance with plan changes.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Is there a free trial?</h3>
                    <p class="text-gray-600">We offer a limited trial for new users. Contact our support team to request trial access.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What happens if I exceed my limit?</h3>
                    <p class="text-gray-600">API requests will be rate-limited once you reach your daily quota. Consider upgrading for higher limits.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection