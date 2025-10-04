@extends('layouts.app')

@section('title', 'Dashboard - Courier Fraud')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if(session('new_api_key'))
        <div class="mb-6 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
            <h4 class="font-bold">Your new API key (save this, it won't be shown again):</h4>
            <code class="bg-blue-200 px-2 py-1 rounded">{{ session('new_api_key') }}</code>
        </div>
    @endif

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-blue-500 bg-opacity-10">
                    <i class="fas fa-key text-blue-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">API Keys</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $apiKeys->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-green-500 bg-opacity-10">
                    <i class="fas fa-chart-line text-green-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Today's Usage</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($todayUsage) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-purple-500 bg-opacity-10">
                    <i class="fas fa-calendar text-purple-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Monthly Usage</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($monthlyUsage) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-orange-500 bg-opacity-10">
                    <i class="fas fa-crown text-orange-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Subscription</p>
                    <p class="text-lg font-bold text-gray-900">
                        @if($activeSubscription)
                            {{ $activeSubscription->plan->name }}
                        @else
                            No Plan
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- API Keys Section -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-900">API Keys</h2>
                    <button onclick="toggleModal('apiKeyModal')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                        <i class="fas fa-plus mr-2"></i>Generate New Key
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                @if($apiKeys->count() > 0)
                    <div class="space-y-4">
                        @foreach($apiKeys as $apiKey)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $apiKey->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $apiKey->masked_key }}</p>
                                        <p class="text-xs text-gray-400">
                                            Created: {{ $apiKey->created_at->format('M d, Y') }}
                                            @if($apiKey->last_used_at)
                                                | Last used: {{ $apiKey->last_used_at->diffForHumans() }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $apiKey->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $apiKey->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <form action="{{ route('dashboard.toggle-api-key', $apiKey) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm">
                                                {{ $apiKey->is_active ? 'Disable' : 'Enable' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('dashboard.delete-api-key', $apiKey) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No API keys generated yet.</p>
                @endif
            </div>
        </div>

        <!-- Subscription Section -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Subscription Status</h2>
            </div>
            
            <div class="p-6">
                @if($activeSubscription)
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $activeSubscription->plan->name }}</h3>
                        <p class="text-gray-600">{{ $activeSubscription->plan->description }}</p>
                        <div class="mt-2 text-sm text-gray-500">
                            <p>Daily Limit: {{ number_format($activeSubscription->plan->request_limit) }} requests</p>
                            <p>Expires: {{ $activeSubscription->ends_at->format('M d, Y') }}</p>
                            <p>Days Remaining: {{ $activeSubscription->days_remaining }}</p>
                        </div>
                    </div>
                    
                    @if($activeSubscription->days_remaining < 7)
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Your subscription expires soon. Consider renewing to avoid service interruption.
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-circle text-orange-500 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Active Subscription</h3>
                        <p class="text-gray-600 mb-4">Subscribe to a plan to start using our API services.</p>
                        <a href="{{ route('pricing') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                            View Plans
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="mt-8 bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Recent API Activity</h2>
        </div>
        
        <div class="p-6">
            @if($recentUsage->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Endpoint</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Response Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentUsage as $usage)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $usage->endpoint }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ $usage->method }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $usage->isSuccessful() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $usage->response_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $usage->formatted_response_time }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $usage->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No API activity yet.</p>
            @endif
        </div>
    </div>
</div>

<!-- API Key Modal -->
<div id="apiKeyModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Generate New API Key</h3>
            </div>
            
            <form action="{{ route('dashboard.generate-api-key') }}" method="POST">
                @csrf
                <div class="p-6">
                    <label for="key_name" class="block text-sm font-medium text-gray-700 mb-2">Key Name</label>
                    <input 
                        type="text" 
                        id="key_name" 
                        name="name" 
                        required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="e.g., Production API, Development Key"
                    >
                    <p class="text-sm text-gray-500 mt-1">Choose a descriptive name to identify this API key.</p>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button type="button" onclick="toggleModal('apiKeyModal')" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Generate Key
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.toggle('hidden');
}
</script>
@endsection