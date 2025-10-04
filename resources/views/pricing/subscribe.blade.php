@extends('layouts.app')

@section('title', 'Subscribe to ' . $plan->name . ' - Courier Fraud')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-12 sm:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl mb-6">
                    <i class="fas fa-credit-card text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                    Subscribe to <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">{{ $plan->name }}</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Complete your subscription with our secure manual payment verification process
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Plan Summary Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6">
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-white bg-opacity-20 rounded-lg mb-4">
                                    <i class="fas fa-crown text-white text-xl"></i>
                                </div>
                                <h2 class="text-2xl font-bold mb-2">{{ $plan->name }}</h2>
                                <p class="text-blue-100 text-sm">{{ $plan->description }}</p>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="text-center mb-6">
                                <div class="text-4xl font-bold text-gray-900 mb-1">{{ $plan->formatted_price }}</div>
                                <div class="text-gray-500">for {{ $plan->duration_text }}</div>
                            </div>
                            
                            <!-- Plan Features -->
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    What's included:
                                </h3>
                                <ul class="space-y-3">
                                    @foreach($plan->features as $feature)
                                        <li class="flex items-start text-gray-700">
                                            <div class="flex-shrink-0 w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                                <i class="fas fa-check text-green-600 text-xs"></i>
                                            </div>
                                            <span class="text-sm leading-relaxed">{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment & Form Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <!-- Payment Instructions -->
                        <div class="bg-gradient-to-r from-pink-50 to-rose-50 p-6 sm:p-8 border-b border-gray-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-mobile-alt text-pink-600"></i>
                                </div>
                                Payment Instructions
                            </h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="bg-white border-2 border-pink-200 rounded-xl p-6 text-center">
                                    <div class="mb-4">
                                        <div class="inline-flex items-center justify-center w-12 h-12 bg-pink-100 rounded-lg mb-3">
                                            <i class="fas fa-money-bill-wave text-pink-600 text-xl"></i>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-2">Send exactly</p>
                                        <div class="text-3xl font-bold text-pink-600 mb-1">{{ $plan->formatted_price }}</div>
                                        <p class="text-sm text-gray-500">via Bkash</p>
                                    </div>
                                </div>
                                
                                <div class="bg-white border-2 border-pink-200 rounded-xl p-6 text-center">
                                    <div class="mb-4">
                                        <div class="inline-flex items-center justify-center w-12 h-12 bg-pink-100 rounded-lg mb-3">
                                            <i class="fas fa-phone text-pink-600 text-xl"></i>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-2">Send money to</p>
                                        <div class="text-2xl font-bold text-pink-600 mb-1">01309092748</div>
                                        <button onclick="copyToClipboard('01309092748')" class="text-sm text-pink-600 hover:text-pink-700 font-medium">
                                            <i class="fas fa-copy mr-1"></i>Copy Number
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-xl p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-yellow-800 mb-1">Important Instructions:</p>
                                        <p class="text-sm text-yellow-700">After sending the payment, you'll receive a transaction ID. Enter this ID in the form below to complete your subscription.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Subscription Form -->
                        <form action="{{ route('pricing.process-subscription', $plan) }}" method="POST" class="p-6 sm:p-8">
                            @csrf
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="payment_method" class="block text-sm font-semibold text-gray-700 mb-3">
                                        <i class="fas fa-credit-card text-blue-500 mr-2"></i>
                                        Payment Method
                                    </label>
                                    <select id="payment_method" name="payment_method" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-gray-50">
                                        <option value="bkash">🏦 Bkash Mobile Banking</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="transaction_id" class="block text-sm font-semibold text-gray-700 mb-3">
                                        <i class="fas fa-receipt text-green-500 mr-2"></i>
                                        Transaction ID
                                    </label>
                                    <input 
                                        type="text" 
                                        id="transaction_id" 
                                        name="transaction_id" 
                                        required 
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('transaction_id') border-red-300 ring-red-500 @enderror"
                                        placeholder="Enter your Bkash transaction ID (e.g., 9A1B2C3D4E)"
                                        value="{{ old('transaction_id') }}"
                                    >
                                    @error('transaction_id')
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg p-3">
                                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                    <p class="mt-2 text-sm text-gray-500 bg-blue-50 border border-blue-200 rounded-lg p-3">
                                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                        You'll receive this ID after completing the Bkash payment
                                    </p>
                                </div>

                                <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-4">
                                    <div class="flex items-start">
                                        <input 
                                            id="terms" 
                                            name="terms" 
                                            type="checkbox" 
                                            required
                                            class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-0.5 flex-shrink-0"
                                        >
                                        <label for="terms" class="ml-3 block text-sm text-gray-700 leading-relaxed">
                                            <span class="font-medium">I confirm that:</span>
                                            <ul class="mt-2 space-y-1 text-gray-600">
                                                <li>• I have completed the payment of <strong class="text-gray-900">{{ $plan->formatted_price }}</strong> to the provided Bkash number</li>
                                                <li>• I agree to the <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Privacy Policy</a></li>
                                            </ul>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('pricing') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-4 px-6 rounded-xl text-center font-semibold transition-all duration-200 border-2 border-gray-200 hover:border-gray-300">
                                    <i class="fas fa-arrow-left mr-2"></i>Back to Plans
                                </a>
                                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white py-4 px-6 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i class="fas fa-check-circle mr-2"></i>Complete Subscription
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Verification Timeline -->
            <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg mb-4">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">What happens next?</h3>
                    <p class="text-gray-600">Your subscription journey in simple steps</p>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-6">
                            1
                        </div>
                        <div class="pt-2">
                            <h4 class="font-semibold text-gray-900 mb-1">Submit Form</h4>
                            <p class="text-gray-600">You submit this form with your transaction ID and payment confirmation</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-6">
                            2
                        </div>
                        <div class="pt-2">
                            <h4 class="font-semibold text-gray-900 mb-1">Payment Verification</h4>
                            <p class="text-gray-600">Our team verifies your payment within 2-24 hours during business hours</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-full flex items-center justify-center mr-6">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                        <div class="pt-2">
                            <h4 class="font-semibold text-gray-900 mb-1">Subscription Active</h4>
                            <p class="text-gray-600">Your subscription is activated and you can start using the API immediately</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-6">
                    <div class="flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-headset text-blue-600 text-2xl mb-3"></i>
                            <p class="text-sm text-blue-800 font-medium">
                                Need help? Contact our support team at <a href="mailto:support@fraudshield.com" class="text-blue-600 hover:text-blue-700 underline">support@fraudshield.com</a>
                            </p>
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
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 transform translate-x-full transition-transform duration-300';
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
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        
        // Show fallback notification
        alert('Phone number copied: ' + text);
    });
}
</script>
@endsection