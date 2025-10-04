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
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">পেমেন্ট মেথড</label>
                        <div class="bg-pink-50 dark:bg-pink-900/20 border border-pink-200 dark:border-pink-800 rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <div class="bg-pink-600 text-white rounded-lg px-3 py-1 text-sm font-bold mr-3">bKash</div>
                                <span class="text-gray-700 dark:text-gray-300 font-medium">পেমেন্ট নম্বর</span>
                            </div>
                            <div class="bg-white dark:bg-gray-700 border rounded-lg p-3 mb-3">
                                <div class="flex items-center justify-between">
                                    <span class="font-mono text-lg font-bold text-gray-900 dark:text-white">01309092748</span>
                                    <button type="button" onclick="copyNumber()" class="bg-pink-100 hover:bg-pink-200 dark:bg-pink-800 dark:hover:bg-pink-700 text-pink-700 dark:text-pink-200 px-3 py-1 rounded text-sm font-medium transition-colors">
                                        <i class="fas fa-copy mr-1"></i> কপি
                                    </button>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <p class="mb-2"><strong>পেমেন্ট প্রক্রিয়া:</strong></p>
                                <ol class="list-decimal list-inside space-y-1 text-xs">
                                    <li>উপরের নম্বরে bKash Send Money করুন</li>
                                    <li>ট্রানজেকশন সম্পন্ন হলে ট্রানজেকশন আইডি নিচে লিখুন</li>
                                    <li>সাবস্ক্রাইব বাটনে ক্লিক করুন</li>
                                </ol>
                            </div>
                        </div>
                        <input type="hidden" name="payment_method" value="bkash">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ট্রানজেকশন আইডি *</label>
                        <input type="text" name="transaction_id" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="bKash ট্রানজেকশন আইডি লিখুন" required>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">পেমেন্ট সম্পন্ন হওয়ার পর যে আইডি পাবেন তা এখানে লিখুন</p>
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
    <!-- Nice Alert CSS -->
    <style>
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            min-width: 300px;
            max-width: 500px;
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            transform: translateX(400px);
            transition: all 0.3s ease-in-out;
            backdrop-filter: blur(10px);
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification.success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-left: 4px solid #047857;
        }
        
        .notification.error {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-left: 4px solid #b91c1c;
        }
        
        .notification.info {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border-left: 4px solid #1d4ed8;
        }
        
        .notification .notification-content {
            display: flex;
            align-items: center;
        }
        
        .notification .notification-icon {
            margin-right: 12px;
            font-size: 20px;
        }
        
        .notification .notification-text {
            flex: 1;
        }
        
        .notification .notification-title {
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .notification .notification-message {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .notification .notification-close {
            background: none;
            border: none;
            color: currentColor;
            font-size: 18px;
            cursor: pointer;
            padding: 0;
            margin-left: 12px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        
        .notification .notification-close:hover {
            opacity: 1;
        }
    </style>
    
    <script>
        const plans = @json($plans);

        // Nice notification function
        function showNotification(title, message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            
            const iconMap = {
                success: 'fas fa-check-circle',
                error: 'fas fa-exclamation-circle',
                info: 'fas fa-info-circle'
            };
            
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="${iconMap[type]} notification-icon"></i>
                    <div class="notification-text">
                        <div class="notification-title">${title}</div>
                        <div class="notification-message">${message}</div>
                    </div>
                    <button class="notification-close" onclick="closeNotification(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            // Auto close after 5 seconds
            setTimeout(() => {
                closeNotification(notification.querySelector('.notification-close'));
            }, 5000);
        }
        
        function closeNotification(button) {
            const notification = button.closest('.notification');
            notification.classList.remove('show');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }
        
        // Copy bKash number function
        function copyNumber() {
            const number = '01309092748';
            navigator.clipboard.writeText(number).then(() => {
                showNotification(
                    'নম্বর কপি হয়েছে!', 
                    'bKash নম্বর ক্লিপবোর্ডে কপি হয়েছে', 
                    'success'
                );
            }).catch(() => {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = number;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showNotification(
                    'নম্বর কপি হয়েছে!', 
                    'bKash নম্বর ক্লিপবোর্ডে কপি হয়েছে', 
                    'success'
                );
            });
        }

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
            const transactionId = formData.get('transaction_id');
            
            if (!transactionId || transactionId.trim() === '') {
                showNotification(
                    'ট্রানজেকশন আইডি প্রয়োজন', 
                    'অনুগ্রহ করে bKash ট্রানজেকশন আইডি প্রদান করুন', 
                    'error'
                );
                return;
            }
            
            try {
                const response = await fetch(`/website-subscriptions/subscribe/${planType}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        payment_method: formData.get('payment_method'),
                        transaction_id: transactionId,
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(
                        'সাবস্ক্রিপশন সফল!', 
                        'আপনার সাবস্ক্রিপশন সফলভাবে সক্রিয় হয়েছে। অ্যাডমিনের অনুমোদনের অপেক্ষায় রয়েছে।', 
                        'success'
                    );
                    closeSubscriptionModal();
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    showNotification(
                        'সাবস্ক্রিপশন ব্যর্থ', 
                        result.message || 'সাবস্ক্রিপশন প্রক্রিয়ায় সমস্যা হয়েছে।', 
                        'error'
                    );
                }
            } catch (error) {
                showNotification(
                    'নেটওয়ার্ক ত্রুটি', 
                    'সাবস্ক্রিপশন প্রক্রিয়ায় সমস্যা হয়েছে। আবার চেষ্টা করুন।', 
                    'error'
                );
            }
            
            closeSubscriptionModal();
        });
    </script>
@endsection