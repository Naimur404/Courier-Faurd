@extends('layouts.app')

@section('title', 'Pricing Plans - Courier Fraud')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-12 sm:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center p-2 bg-blue-100 rounded-full mb-6">
                <i class="fas fa-crown text-blue-600 text-2xl"></i>
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                Choose Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Plan</span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Select the perfect plan for your business needs. All plans include our comprehensive courier tracking API with real-time updates and 24/7 support.
            </p>
        </div>

        <!-- Pricing Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-7xl mx-auto mb-16">
            @foreach($plans as $plan)
                <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 {{ $loop->index === 1 ? 'ring-4 ring-blue-500 transform scale-105 lg:scale-110' : '' }}">
                    @if($loop->index === 1)
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-center py-3">
                            <span class="text-sm font-semibold">
                                <i class="fas fa-star mr-1"></i>Most Popular
                            </span>
                        </div>
                    @endif
                    
                    <div class="p-8">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r {{ $loop->index === 0 ? 'from-green-400 to-emerald-500' : ($loop->index === 1 ? 'from-blue-500 to-indigo-600' : 'from-purple-500 to-pink-600') }} rounded-xl mb-6">
                                <i class="fas {{ $loop->index === 0 ? 'fa-rocket' : ($loop->index === 1 ? 'fa-crown' : 'fa-gem') }} text-white text-2xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                            <p class="text-gray-600 mb-6">{{ $plan->description }}</p>
                            
                            <div class="mb-8">
                                <span class="text-5xl font-bold text-gray-900">{{ $plan->formatted_price }}</span>
                                <span class="text-gray-500 text-lg">/ {{ $plan->duration_text }}</span>
                            </div>
                        </div>

                        <!-- Features -->
                        <ul class="space-y-4 mb-8">
                            @foreach($plan->features as $feature)
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                        <i class="fas fa-check text-green-600 text-sm"></i>
                                    </div>
                                    <span class="text-gray-700 leading-relaxed">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <!-- CTA Button -->
                        <div class="pt-4">
                            @auth
                                @if(auth()->user()->hasActiveSubscription())
                                    <button disabled class="w-full bg-gray-100 text-gray-500 py-4 px-6 rounded-xl font-semibold cursor-not-allowed border border-gray-200">
                                        <i class="fas fa-check-circle mr-2"></i>Already Subscribed
                                    </button>
                                @else
                                    <a href="{{ route('pricing.subscribe', $plan) }}" class="w-full bg-gradient-to-r {{ $loop->index === 0 ? 'from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700' : ($loop->index === 1 ? 'from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700' : 'from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700') }} text-white py-4 px-6 rounded-xl font-semibold block text-center transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                        <i class="fas fa-arrow-right mr-2"></i>Subscribe Now
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="w-full bg-gradient-to-r {{ $loop->index === 0 ? 'from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700' : ($loop->index === 1 ? 'from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700' : 'from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700') }} text-white py-4 px-6 rounded-xl font-semibold block text-center transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    <i class="fas fa-rocket mr-2"></i>Get Started
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Payment Information -->
        <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-12 max-w-6xl mx-auto mb-16">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-pink-500 to-rose-500 rounded-xl mb-4">
                    <i class="fas fa-credit-card text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Payment Information</h2>
                <p class="text-gray-600">Simple and secure payment process with instant activation</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-mobile-alt text-pink-600"></i>
                        </div>
                        Bkash Payment
                    </h3>
                    <div class="bg-gradient-to-r from-pink-50 to-rose-50 border-2 border-pink-200 rounded-xl p-6">
                        <div class="text-center">
                            <p class="text-gray-700 mb-3 font-medium">Send money to:</p>
                            <div class="bg-white rounded-lg p-4 mb-4 shadow-sm">
                                <p class="text-3xl font-bold text-pink-600 mb-2">01309092748</p>
                                <button onclick="copyToClipboard('01309092748')" class="text-sm text-pink-600 hover:text-pink-700 font-medium">
                                    <i class="fas fa-copy mr-1"></i>Copy Number
                                </button>
                            </div>
                            <div class="bg-pink-100 rounded-lg p-4">
                                <p class="text-sm text-pink-800 font-medium">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Send money and provide the transaction ID during subscription.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-clock text-blue-600"></i>
                        </div>
                        Process Timeline
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4">
                                1
                            </div>
                            <div class="pt-1">
                                <p class="text-gray-900 font-medium">Choose Plan & Payment</p>
                                <p class="text-gray-600 text-sm">Select your plan and complete Bkash payment</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4">
                                2
                            </div>
                            <div class="pt-1">
                                <p class="text-gray-900 font-medium">Submit Transaction ID</p>
                                <p class="text-gray-600 text-sm">Provide your Bkash transaction ID</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4">
                                3
                            </div>
                            <div class="pt-1">
                                <p class="text-gray-900 font-medium">Payment Verification</p>
                                <p class="text-gray-600 text-sm">We verify within 2-24 hours</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <div class="pt-1">
                                <p class="text-gray-900 font-medium">Subscription Active</p>
                                <p class="text-gray-600 text-sm">Start using API immediately</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl mb-4">
                    <i class="fas fa-question-circle text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-gray-600">Everything you need to know about our plans and services</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-clock text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">How long does verification take?</h3>
                            <p class="text-gray-600 leading-relaxed">Payment verification typically takes 2-24 hours during business hours. You'll receive an email confirmation once activated.</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-arrow-up text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Can I upgrade my plan?</h3>
                            <p class="text-gray-600 leading-relaxed">Yes, you can upgrade to a higher plan at any time. Contact support for assistance with plan changes and pro-rated billing.</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-gift text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Is there a free trial?</h3>
                            <p class="text-gray-600 leading-relaxed">We offer a limited trial for new users with 100 free API calls. Contact our support team to request trial access.</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-exclamation-triangle text-orange-600"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">What happens if I exceed my limit?</h3>
                            <p class="text-gray-600 leading-relaxed">API requests will be rate-limited once you reach your daily quota. Consider upgrading for higher limits and priority support.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Create a temporary toast notification
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
        toast.innerHTML = '<i class="fas fa-check mr-2"></i>Number copied to clipboard!';
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Animate out and remove
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
    });
}
</script>
@endsection