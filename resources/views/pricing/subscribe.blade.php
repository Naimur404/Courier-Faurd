@extends('layouts.app')

@section('title', 'Subscribe to ' . $plan->name . ' - Courier Fraud')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Subscribe to {{ $plan->name }}</h1>
                <p class="text-gray-600 mt-2">Complete your subscription with manual payment verification</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Plan Summary -->
                <div class="bg-blue-50 px-6 py-4 border-b">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">{{ $plan->name }}</h2>
                            <p class="text-gray-600">{{ $plan->description }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">{{ $plan->formatted_price }}</div>
                            <div class="text-sm text-gray-500">for {{ $plan->duration_text }}</div>
                        </div>
                    </div>
                </div>

                <!-- Plan Features -->
                <div class="px-6 py-4 border-b">
                    <h3 class="font-semibold text-gray-900 mb-3">What's included:</h3>
                    <ul class="space-y-2">
                        @foreach($plan->features as $feature)
                            <li class="flex items-center text-gray-700">
                                <i class="fas fa-check text-green-500 mr-3"></i>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Payment Instructions -->
                <div class="px-6 py-6 bg-pink-50 border-b">
                    <h3 class="font-semibold text-gray-900 mb-4">
                        <i class="fas fa-mobile-alt text-pink-500 mr-2"></i>
                        Payment Instructions
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="bg-white border border-pink-200 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-2">Send <strong>{{ $plan->formatted_price }}</strong> to:</p>
                            <div class="text-2xl font-bold text-pink-600 mb-2">01309092748</div>
                            <p class="text-sm text-gray-600">via Bkash</p>
                        </div>
                        
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                            <div class="flex">
                                <i class="fas fa-exclamation-triangle mt-1 mr-3"></i>
                                <div>
                                    <p class="font-medium">Important:</p>
                                    <p class="text-sm">After sending the payment, you'll receive a transaction ID. Enter this ID in the form below to complete your subscription.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subscription Form -->
                <form action="{{ route('pricing.process-subscription', $plan) }}" method="POST" class="px-6 py-6">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                            <select id="payment_method" name="payment_method" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="bkash">Bkash</option>
                            </select>
                        </div>

                        <div>
                            <label for="transaction_id" class="block text-sm font-medium text-gray-700 mb-2">Transaction ID</label>
                            <input 
                                type="text" 
                                id="transaction_id" 
                                name="transaction_id" 
                                required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('transaction_id') border-red-300 @enderror"
                                placeholder="Enter your Bkash transaction ID"
                                value="{{ old('transaction_id') }}"
                            >
                            @error('transaction_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">You'll receive this ID after completing the Bkash payment</p>
                        </div>

                        <div class="flex items-start">
                            <input 
                                id="terms" 
                                name="terms" 
                                type="checkbox" 
                                required
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1"
                            >
                            <label for="terms" class="ml-2 block text-sm text-gray-900">
                                I confirm that I have completed the payment of {{ $plan->formatted_price }} to the provided Bkash number and agree to the 
                                <a href="#" class="text-blue-600 hover:text-blue-500">Terms of Service</a> 
                                and 
                                <a href="#" class="text-blue-600 hover:text-blue-500">Privacy Policy</a>
                            </label>
                        </div>
                    </div>

                    <div class="mt-8 flex space-x-4">
                        <a href="{{ route('pricing') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 py-3 px-6 rounded-lg text-center font-semibold transition duration-200">
                            Back to Plans
                        </a>
                        <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold transition duration-200">
                            Complete Subscription
                        </button>
                    </div>
                </form>
            </div>

            <!-- Verification Timeline -->
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">What happens next?</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</div>
                        <span class="text-gray-700">You submit this form with your transaction ID</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</div>
                        <span class="text-gray-700">Our team verifies your payment (within 24 hours)</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">3</div>
                        <span class="text-gray-700">Your subscription is activated and you can start using the API</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection