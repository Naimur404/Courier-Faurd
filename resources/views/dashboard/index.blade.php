@extends('layouts.app')

@section('title', 'Dashboard - FraudShield API')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">Welcome back, {{ auth()->user()->name }}!</p>
                </div>
                <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('api.documentation') }}" target="_blank" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors text-center">
                        <i class="fas fa-book mr-2"></i>API Documentation
                    </a>
                    <a href="{{ route('pricing') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors text-center">
                        <i class="fas fa-crown mr-2"></i>Upgrade Plan
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if(session('new_api_key'))
            <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 p-6 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-key text-blue-500 mr-3 mt-1"></i>
                    <div class="flex-1">
                        <h4 class="font-bold text-lg mb-2">Your new API credentials</h4>
                        <p class="text-sm mb-4 text-blue-700">Save these credentials securely. They won't be shown again!</p>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-blue-800 mb-1">API Key:</label>
                                <div class="flex items-center space-x-2">
                                    <code id="apiKeyValue" class="bg-blue-100 px-3 py-2 rounded flex-1 font-mono text-sm">{{ session('new_api_key') }}</code>
                                    <button onclick="copyToClipboard('apiKeyValue')" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm transition-colors">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            
                            @if(session('new_api_secret'))
                            <div>
                                <label class="block text-sm font-medium text-blue-800 mb-1">API Secret:</label>
                                <div class="flex items-center space-x-2">
                                    <code id="apiSecretValue" class="bg-blue-100 px-3 py-2 rounded flex-1 font-mono text-sm">{{ session('new_api_secret') }}</code>
                                    <button onclick="copyToClipboard('apiSecretValue')" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm transition-colors">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div class="mt-4 p-3 bg-blue-100 rounded">
                            <p class="text-sm text-blue-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                <strong>Important:</strong> Store these credentials securely. Use the API key for authentication and refer to our documentation for implementation details.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600">
                        <i class="fas fa-key text-white text-xl"></i>
                    </div>
                    <div class="ml-4 min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 truncate">API Keys</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $apiKeys->count() }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">{{ $apiKeys->where('is_active', true)->count() }} active</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gradient-to-r from-green-500 to-emerald-600">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <div class="ml-4 min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 truncate">Today's Usage</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($todayUsage) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">requests made</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gradient-to-r from-purple-500 to-pink-600">
                        <i class="fas fa-calendar text-white text-xl"></i>
                    </div>
                    <div class="ml-4 min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 truncate">Monthly Usage</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($monthlyUsage) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">this month</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gradient-to-r from-orange-500 to-yellow-500">
                        <i class="fas fa-crown text-white text-xl"></i>
                    </div>
                    <div class="ml-4 min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 truncate">Subscription</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white truncate">
                            @if($activeSubscription)
                                {{ $activeSubscription->plan->name }}
                            @else
                                No Plan
                            @endif
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">
                            @if($activeSubscription)
                                {{ $activeSubscription->getDaysRemainingAttribute() }} days left
                            @else
                                Inactive
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 lg:gap-8">
            <!-- API Keys Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">API Keys</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Your API authentication keys</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($apiKeys->count() > 0)
                        <div class="space-y-4">
                            @foreach($apiKeys as $apiKey)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                    <div class="flex flex-col space-y-3 sm:flex-row sm:justify-between sm:items-start sm:space-y-0">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-col space-y-2 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-3 mb-2">
                                                <h3 class="font-medium text-gray-900 dark:text-white truncate">{{ $apiKey->name }}</h3>
                                                <span class="px-2 py-1 text-xs rounded-full w-fit {{ $apiKey->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                                    {{ $apiKey->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                            
                                            <div class="flex items-center space-x-2 mb-2">
                                                <code id="key-{{ $apiKey->id }}" class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded text-sm font-mono flex-1 min-w-0 truncate">{{ $apiKey->masked_key }}</code>
                                                <button onclick="copyToClipboard('key-{{ $apiKey->id }}', '{{ $apiKey->key }}')" class="bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 px-2 py-1 rounded text-xs transition-colors flex-shrink-0">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                            
                                            <div class="flex flex-col space-y-1 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-4 text-xs text-gray-500 dark:text-gray-400">
                                                <span class="flex items-center"><i class="fas fa-calendar mr-1"></i>Created: {{ $apiKey->created_at->format('M d, Y') }}</span>
                                                @if($apiKey->last_used_at)
                                                    <span class="flex items-center"><i class="fas fa-clock mr-1"></i>Last used: {{ $apiKey->last_used_at->diffForHumans() }}</span>
                                                @else
                                                    <span class="flex items-center"><i class="fas fa-clock mr-1"></i>Never used</span>
                                                @endif
                                                <span class="flex items-center"><i class="fas fa-chart-bar mr-1"></i>{{ number_format($apiKey->usage_count) }} uses</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="mb-4">
                                <i class="fas fa-key text-gray-400 dark:text-gray-500 text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No API keys available</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">Contact administrator to get your API keys.</p>
                        </div>
                    @endif
                    
                    <!-- Quick Links -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex flex-wrap gap-3">
                            <span class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-info-circle mr-2"></i>Use these API keys to authenticate your requests
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscription Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Subscription Status</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Your current plan and usage limits</p>
                        </div>
                        @if($activeSubscription)
                            <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-3 py-1 rounded-full text-sm font-medium">
                                Active
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="p-6">
                    @if($activeSubscription)
                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">{{ $activeSubscription->plan->name }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">{{ $activeSubscription->plan->description }}</p>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 text-sm">
                                    <div class="flex items-center">
                                        <i class="fas fa-tachometer-alt text-indigo-500 mr-2 flex-shrink-0"></i>
                                        <span class="text-gray-600 dark:text-gray-400 mr-1">Daily Limit:</span>
                                        <span class="font-semibold text-gray-900 dark:text-white break-all">{{ number_format($activeSubscription->plan->request_limit) }} requests</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-indigo-500 mr-2 flex-shrink-0"></i>
                                        <span class="text-gray-600 dark:text-gray-400 mr-1">Expires:</span>
                                        <span class="font-semibold text-gray-900 dark:text-white break-all">{{ $activeSubscription->expires_at ? $activeSubscription->expires_at->format('M d, Y') : 'Never' }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-indigo-500 mr-2 flex-shrink-0"></i>
                                        <span class="text-gray-600 dark:text-gray-400 mr-1">Days Remaining:</span>
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $activeSubscription->getDaysRemainingAttribute() }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-chart-pie text-indigo-500 mr-2 flex-shrink-0"></i>
                                        <span class="text-gray-600 dark:text-gray-400 mr-1">Usage Today:</span>
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($todayUsage) }} / {{ number_format($activeSubscription->plan->request_limit) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            @if($activeSubscription->getDaysRemainingAttribute() < 7 && $activeSubscription->getDaysRemainingAttribute() > 0)
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-200 px-4 py-3 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-3 text-yellow-500"></i>
                                        <div>
                                            <p class="font-medium">Subscription Expiring Soon</p>
                                            <p class="text-sm">Your subscription expires in {{ $activeSubscription->getDaysRemainingAttribute() }} days. Consider renewing to avoid service interruption.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Usage Progress Bar -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Today's Usage</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($todayUsage) }} / {{ number_format($activeSubscription->plan->request_limit) }}</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                    @php
                                        $percentage = min(100, ($todayUsage / $activeSubscription->plan->request_limit) * 100);
                                        $colorClass = $percentage > 90 ? 'bg-red-500' : ($percentage > 70 ? 'bg-yellow-500' : 'bg-green-500');
                                    @endphp
                                    <div class="h-2 rounded-full {{ $colorClass }}" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="{{ route('pricing') }}" class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium text-center transition-all duration-200">
                                    <i class="fas fa-arrow-up mr-2"></i>Upgrade Plan
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="mb-4">
                                <i class="fas fa-exclamation-circle text-orange-400 dark:text-orange-500 text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Active Subscription</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Subscribe to a plan to start using our API services and unlock powerful fraud detection capabilities.</p>
                            <a href="{{ route('pricing') }}" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i class="fas fa-crown mr-2"></i>View Plans & Pricing
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Recent API Activity</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Monitor your latest API requests and performance</p>
            </div>
            
            <div class="p-6">
                @if($recentUsage->count() > 0)
                    <div class="overflow-x-auto -mx-6 sm:mx-0 sm:rounded-lg">
                        <div class="min-w-full inline-block align-middle">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-750">
                                    <tr>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Endpoint</th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Method</th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Response Time</th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Time</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($recentUsage as $usage)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                            <td class="px-4 sm:px-6 py-4 text-sm text-gray-900 dark:text-gray-100 font-mono">
                                                <div class="max-w-xs truncate" title="{{ $usage->endpoint }}">{{ $usage->endpoint }}</div>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 font-medium">{{ $usage->method }}</span>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs rounded-full font-medium {{ $usage->isSuccessful() ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                                    {{ $usage->response_status }}
                                                </span>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 hidden sm:table-cell">{{ $usage->formatted_response_time }}</td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $usage->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="mb-4">
                            <i class="fas fa-chart-line text-gray-400 dark:text-gray-500 text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No API activity yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Once you start making API requests, they'll appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(elementId, fullKey = null) {
    const element = document.getElementById(elementId);
    const textToCopy = fullKey || element.textContent;
    
    navigator.clipboard.writeText(textToCopy).then(function() {
        // Show success feedback
        const button = element.nextElementSibling;
        const originalIcon = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check text-green-600"></i>';
        button.className = button.className.replace('bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500', 'bg-green-200 dark:bg-green-600');
        
        setTimeout(function() {
            button.innerHTML = originalIcon;
            button.className = button.className.replace('bg-green-200 dark:bg-green-600', 'bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500');
        }, 2000);
    }, function(err) {
        console.error('Could not copy text: ', err);
    });
}
</script>
@endsection