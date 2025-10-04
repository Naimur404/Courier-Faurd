@extends('layouts.app')

@section('title', 'ওয়েবসাইট সাবস্ক্রিপশন - সীমাহীন সার্চ | Courier Fraud')

@section('description', 'আমাদের ওয়েবসাইটে সীমাহীন কুরিয়ার ভেরিফিকেশন সার্চের জন্য সাবস্ক্রাইব করুন। দৈনিক ২০ টাকা বা ১৫ দিনের জন্য ৫০ টাকা।')

@section('keywords', 'unlimited search, কুরিয়ার সার্চ, সীমাহীন সার্চ, কুরিয়ার সাবস্ক্রিপশন, courier subscription bangladesh')

@section('content')
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">
                <i class="fas fa-infinity mr-3"></i>
                সীমাহীন সার্চ প্ল্যান
            </h1>
            <p class="text-xl md:text-2xl text-indigo-100 max-w-3xl mx-auto">
                আমাদের ওয়েবসাইটে সীমাহীন কুরিয়ার ভেরিফিকেশন সার্চের জন্য সাবস্ক্রাইব করুন
            </p>
        </div>
    </div>

    <!-- Current Subscription Status -->
    @if($activeSubscription)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-3 mr-4">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-green-800">সক্রিয় সাবস্ক্রিপশন</h3>
                        <p class="text-green-600">
                            প্ল্যান: {{ $plans[$activeSubscription->plan_type]['name'] }} | 
                            মেয়াদ শেষ: {{ $activeSubscription->expires_at->format('d M Y, h:i A') }}
                        </p>
                        <p class="text-sm text-green-500 mt-1">
                            <i class="fas fa-infinity mr-1"></i>
                            আপনার বর্তমানে সীমাহীন সার্চ সুবিধা আছে
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-green-600">{{ $activeSubscription->formatted_amount }}</div>
                    <div class="text-sm text-green-500">{{ $activeSubscription->days_remaining }} দিন বাকি</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Subscription Plans -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                সাবস্ক্রিপশন প্ল্যান
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                আপনার প্রয়োজন অনুযায়ী উপযুক্ত প্ল্যান বেছে নিন এবং সীমাহীন সার্চ করুন
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            @foreach($plans as $planType => $plan)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition duration-300 {{ $planType === 'weekly' ? 'ring-4 ring-indigo-500 ring-opacity-50' : '' }}">
                @if($planType === 'weekly')
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-center py-3">
                    <span class="font-bold text-sm uppercase tracking-wide">
                        <i class="fas fa-star mr-1"></i> সবচেয়ে জনপ্রিয়
                    </span>
                </div>
                @endif
                
                <div class="p-8">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $plan['name'] }}</h3>
                        <div class="text-5xl font-bold text-indigo-600 mb-2">
                            ৳{{ number_format($plan['price']) }}
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">{{ $plan['duration'] }}</p>
                        
                        <div class="text-gray-600 dark:text-gray-300 mb-8">
                            <p class="text-lg">{{ $plan['description'] }}</p>
                        </div>

                        <!-- Features -->
                        <div class="space-y-4 mb-8">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-infinity text-indigo-500 mr-2"></i>
                                <span class="dark:text-gray-300">সীমাহীন সার্চ</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <i class="fas fa-shield-check text-green-500 mr-2"></i>
                                <span class="dark:text-gray-300">ভেরিফাইড ডেটা</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <i class="fas fa-clock text-blue-500 mr-2"></i>
                                <span class="dark:text-gray-300">তাৎক্ষণিক ফলাফল</span>
                            </div>
                            @if($planType === 'weekly')
                            <div class="flex items-center justify-center">
                                <i class="fas fa-crown text-yellow-500 mr-2"></i>
                                <span class="dark:text-gray-300">সাশ্রয়ী মূল্য</span>
                            </div>
                            @endif
                        </div>

                        @auth
                            @if($activeSubscription)
                                <button disabled class="w-full bg-gray-300 text-gray-500 py-3 px-6 rounded-xl font-bold cursor-not-allowed">
                                    <i class="fas fa-check mr-2"></i>
                                    ইতিমধ্যে সাবস্ক্রাইব করা আছে
                                </button>
                            @else
                                <button onclick="subscribeToPlan('{{ $planType }}')" 
                                        class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-3 px-6 rounded-xl font-bold transform hover:scale-105 transition duration-200 shadow-lg">
                                    <i class="fas fa-credit-card mr-2"></i>
                                    এখনই সাবস্ক্রাইব করুন
                                </button>
                            @endif
                        @else
                            <a href="/login" class="block w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-3 px-6 rounded-xl font-bold text-center transform hover:scale-105 transition duration-200 shadow-lg">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                লগইন করে সাবস্ক্রাইব করুন
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white dark:bg-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">সাবস্ক্রিপশনের সুবিধা</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400">আমাদের সাবস্ক্রিপশন নিয়ে পান এই সব বিশেষ সুবিধা</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-indigo-100 dark:bg-indigo-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-infinity text-indigo-600 dark:text-indigo-300 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">সীমাহীন সার্চ</h3>
                    <p class="text-gray-600 dark:text-gray-400">দৈনিক সীমা ছাড়াই যতবার খুশি কুরিয়ার ভেরিফাই করুন</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 dark:bg-green-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-check text-green-600 dark:text-green-300 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">নির্ভরযোগ্য ডেটা</h3>
                    <p class="text-gray-600 dark:text-gray-400">১০০% সঠিক এবং আপডেটেড কুরিয়ার তথ্য</p>
                </div>

                <div class="text-center">
                    <div class="bg-blue-100 dark:bg-blue-800 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-blue-600 dark:text-blue-300 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">তাৎক্ষণিক ফলাফল</h3>
                    <p class="text-gray-600 dark:text-gray-400">কোন অপেক্ষা ছাড়াই তুরন্ত ফলাফল পান</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscription Modal -->
    <div id="subscriptionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 max-w-md w-full mx-4 shadow-2xl">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-800 mb-4">
                    <i class="fas fa-credit-card text-indigo-600 dark:text-indigo-300 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4" id="modalPlanName">সাবস্ক্রিপশন</h3>
                
                <form id="subscriptionForm">
                    <input type="hidden" id="selectedPlan" name="plan">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">পেমেন্ট মেথড</label>
                        <select name="payment_method" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
                            <option value="">পেমেন্ট মেথড নির্বাচন করুন</option>
                            <option value="bkash">বিকাশ</option>
                            <option value="nagad">নগদ</option>
                            <option value="rocket">রকেট</option>
                            <option value="manual">ম্যানুয়াল</option>
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ট্রানজেকশন আইডি (ঐচ্ছিক)</label>
                        <input type="text" name="transaction_id" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="ট্রানজেকশন আইডি">
                    </div>
                    
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeSubscriptionModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-white py-2 px-4 rounded-lg font-medium transition duration-200">
                            বাতিল
                        </button>
                        <button type="submit" class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white py-2 px-4 rounded-lg font-medium transition duration-200">
                            সাবস্ক্রাইব করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const plans = @json($plans);

        function subscribeToPlan(planType) {
            const plan = plans[planType];
            document.getElementById('modalPlanName').textContent = plan.name + ' - ৳' + plan.price;
            document.getElementById('selectedPlan').value = planType;
            document.getElementById('subscriptionModal').classList.remove('hidden');
        }

        function closeSubscriptionModal() {
            document.getElementById('subscriptionModal').classList.add('hidden');
        }

        document.getElementById('subscriptionForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const planType = formData.get('plan');
            
            try {
                const response = await fetch(`/website-subscriptions/subscribe/${planType}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        payment_method: formData.get('payment_method'),
                        transaction_id: formData.get('transaction_id'),
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('সাবস্ক্রিপশন সফলভাবে সক্রিয় হয়েছে!');
                    location.reload();
                } else {
                    alert(result.message || 'সাবস্ক্রিপশন প্রক্রিয়ায় সমস্যা হয়েছে।');
                }
            } catch (error) {
                alert('সাবস্ক্রিপশন প্রক্রিয়ায় সমস্যা হয়েছে।');
            }
            
            closeSubscriptionModal();
        });
    </script>
@endsection