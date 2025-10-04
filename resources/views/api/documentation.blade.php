@extends('layouts.app')

@section('title', 'API Documentation - FraudShield')
@section('description', 'Complete API documentation for FraudShield Courier Fraud Detection System. Learn how to integrate our API into your applications.')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-code text-indigo-600 mr-3"></i>
                API Documentation
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Integrate FraudShield's powerful courier fraud detection into your applications with our RESTful API.
            </p>
            <div class="mt-6 flex flex-col sm:flex-row justify-center gap-4 sm:space-x-4">
                <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors text-center">
                    <i class="fas fa-key mr-2"></i>Get API Key
                </a>
                <a href="#quick-start" class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-6 py-3 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors text-center">
                    <i class="fas fa-rocket mr-2"></i>Quick Start
                </a>
            </div>
        </div>

        <!-- Mobile Navigation Toggle -->
        <div class="lg:hidden mb-6">
            <button id="mobile-nav-toggle" class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 flex items-center justify-between">
                <span class="text-lg font-semibold text-gray-900 dark:text-white">Documentation Menu</span>
                <i class="fas fa-chevron-down text-gray-600 dark:text-gray-300" id="mobile-nav-icon"></i>
            </button>
            <div id="mobile-nav-content" class="hidden mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
                <nav class="space-y-2">
                    <a href="#quick-start" class="block text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2 border-b border-gray-200 dark:border-gray-700">Quick Start</a>
                    <a href="#authentication" class="block text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2 border-b border-gray-200 dark:border-gray-700">Authentication</a>
                    <a href="#endpoints" class="block text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2 border-b border-gray-200 dark:border-gray-700">API Endpoints</a>
                    <a href="#rate-limiting" class="block text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2 border-b border-gray-200 dark:border-gray-700">Rate Limiting</a>
                    <a href="#errors" class="block text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2 border-b border-gray-200 dark:border-gray-700">Error Handling</a>
                    <a href="#examples" class="block text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-2">Code Examples</a>
                </nav>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Desktop Navigation Sidebar -->
            <div class="lg:col-span-1 hidden lg:block">
                <div class="sticky top-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Documentation</h3>
                    <nav class="space-y-2">
                        <a href="#quick-start" class="block text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-1">Quick Start</a>
                        <a href="#authentication" class="block text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-1">Authentication</a>
                        <a href="#endpoints" class="block text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-1">API Endpoints</a>
                        <a href="#rate-limiting" class="block text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-1">Rate Limiting</a>
                        <a href="#errors" class="block text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-1">Error Handling</a>
                        <a href="#examples" class="block text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 py-1">Code Examples</a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-span-1 lg:col-span-3 space-y-8">
                <!-- Quick Start -->
                <div id="quick-start" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-rocket text-indigo-600 mr-2"></i>Quick Start
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        Get started with the FraudShield API in minutes. Follow these simple steps to make your first API call.
                    </p>
                    
                    <div class="space-y-4">
                        <div class="border-l-4 border-indigo-500 pl-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">1. Get Your API Key</h4>
                            <p class="text-gray-600 dark:text-gray-300">Register an account and generate your API key from the dashboard.</p>
                        </div>
                        <div class="border-l-4 border-indigo-500 pl-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">2. Make Your First Request</h4>
                            <p class="text-gray-600 dark:text-gray-300">Use your API key to authenticate and check customer fraud data.</p>
                        </div>
                        <div class="border-l-4 border-indigo-500 pl-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">3. Handle the Response</h4>
                            <p class="text-gray-600 dark:text-gray-300">Process the JSON response to integrate fraud detection into your workflow.</p>
                        </div>
                    </div>
                </div>

                <!-- Authentication -->
                <div id="authentication" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-shield-alt text-indigo-600 mr-2"></i>Authentication
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        The FraudShield API uses API keys for authentication. Include your API key in every request.
                    </p>

                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Authorization Header (Recommended)</h4>
                            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                                <code class="text-green-400">Authorization: Bearer YOUR_API_KEY</code>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">X-API-Key Header</h4>
                            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                                <code class="text-green-400">X-API-Key: YOUR_API_KEY</code>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Query Parameter</h4>
                            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                                <code class="text-green-400">?api_key=YOUR_API_KEY</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- API Endpoints -->
                <div id="endpoints" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-sitemap text-indigo-600 mr-2"></i>API Endpoints
                    </h2>

                    <!-- Customer Check Endpoint -->
                    <div class="space-y-8">
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-8">
                            <div class="flex flex-col sm:flex-row sm:items-center mb-4 gap-2">
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium w-fit">POST</span>
                                <code class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200 text-sm break-all">/api/customer/check</code>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Check Customer Fraud Data</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Retrieve comprehensive fraud detection data for a customer using their phone number.
                            </p>

                            <div class="space-y-4">
                                <div>
                                    <h5 class="font-medium text-gray-900 dark:text-white mb-2">Request Body</h5>
                                    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                                        <pre class="text-green-400"><code>{
  "phone": "01700000000"
}</code></pre>
                                    </div>
                                </div>

                                <div>
                                    <h5 class="font-medium text-gray-900 dark:text-white mb-2">Response</h5>
                                    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                                        <pre class="text-green-400"><code>{
  "success": true,
  "data": {
    "phone": "01700000000",
    "total_parcels": 45,
    "successful_deliveries": 42,
    "failed_deliveries": 3,
    "success_rate": 93.33,
    "fraud_risk": "low",
    "last_delivery": "2025-10-03",
    "courier_history": [
      {
        "courier": "Steadfast",
        "total": 25,
        "successful": 24,
        "failed": 1
      }
    ]
  }
}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer List Endpoint -->
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-8">
                            <div class="flex flex-col sm:flex-row sm:items-center mb-4 gap-2">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium w-fit">GET</span>
                                <code class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200 text-sm break-all">/api/customer/list</code>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">List Customer Data</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Retrieve a paginated list of customer fraud data with filtering options.
                            </p>

                            <div class="space-y-4">
                                <div>
                                    <h5 class="font-medium text-gray-900 dark:text-white mb-2">Query Parameters</h5>
                                    <div class="space-y-2">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                            <code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-sm w-fit">page</code>
                                            <span class="text-gray-600 dark:text-gray-300 text-sm">Page number (default: 1)</span>
                                        </div>
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                            <code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-sm w-fit">limit</code>
                                            <span class="text-gray-600 dark:text-gray-300 text-sm">Items per page (default: 20, max: 100)</span>
                                        </div>
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                            <code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-sm w-fit">risk_level</code>
                                            <span class="text-gray-600 dark:text-gray-300 text-sm">Filter by risk level (low, medium, high)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Usage Stats Endpoint -->
                        <div>
                            <div class="flex flex-col sm:flex-row sm:items-center mb-4 gap-2">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium w-fit">GET</span>
                                <code class="bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded text-gray-800 dark:text-gray-200 text-sm break-all">/api/usage/stats</code>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Get Usage Statistics</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Retrieve your API usage statistics and remaining quota.
                            </p>

                            <div class="space-y-4">
                                <div>
                                    <h5 class="font-medium text-gray-900 dark:text-white mb-2">Response</h5>
                                    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                                        <pre class="text-green-400"><code>{
  "success": true,
  "data": {
    "today_usage": 25,
    "monthly_usage": 450,
    "daily_limit": 1000,
    "remaining_today": 975,
    "subscription": {
      "plan_name": "Professional",
      "expires_at": "2025-11-04T00:00:00Z",
      "days_remaining": 31
    }
  }
}</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rate Limiting -->
                <div id="rate-limiting" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-tachometer-alt text-indigo-600 mr-2"></i>Rate Limiting
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        API requests are rate-limited based on your subscription plan and API key settings.
                    </p>

                    <div class="space-y-4">
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                            <h4 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-2">Rate Limit Headers</h4>
                            <p class="text-yellow-700 dark:text-yellow-300 text-sm mb-3">Every response includes rate limit information in headers:</p>
                            <div class="space-y-1 text-sm">
                                <div><code class="bg-yellow-100 dark:bg-yellow-800 px-2 py-1 rounded">X-RateLimit-Limit</code> - Your rate limit per minute</div>
                                <div><code class="bg-yellow-100 dark:bg-yellow-800 px-2 py-1 rounded">X-RateLimit-Remaining</code> - Remaining requests in current window</div>
                                <div><code class="bg-yellow-100 dark:bg-yellow-800 px-2 py-1 rounded">X-RateLimit-Reset</code> - Time when the rate limit resets</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <h5 class="font-semibold text-gray-900 dark:text-white">Basic Plan</h5>
                                <p class="text-2xl font-bold text-indigo-600">60/min</p>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">60 requests per minute</p>
                            </div>
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <h5 class="font-semibold text-gray-900 dark:text-white">Professional</h5>
                                <p class="text-2xl font-bold text-indigo-600">300/min</p>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">300 requests per minute</p>
                            </div>
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <h5 class="font-semibold text-gray-900 dark:text-white">Enterprise</h5>
                                <p class="text-2xl font-bold text-indigo-600">1000/min</p>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">1000 requests per minute</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Error Handling -->
                <div id="errors" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-exclamation-triangle text-indigo-600 mr-2"></i>Error Handling
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        The API uses conventional HTTP response codes to indicate success or failure of requests.
                    </p>

                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-3">HTTP Status Codes</h4>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium mr-4 w-16 text-center">200</span>
                                    <span class="text-gray-600 dark:text-gray-300">Success - Request processed successfully</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium mr-4 w-16 text-center">400</span>
                                    <span class="text-gray-600 dark:text-gray-300">Bad Request - Invalid request parameters</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium mr-4 w-16 text-center">401</span>
                                    <span class="text-gray-600 dark:text-gray-300">Unauthorized - Invalid or missing API key</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium mr-4 w-16 text-center">429</span>
                                    <span class="text-gray-600 dark:text-gray-300">Rate Limit Exceeded - Too many requests</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium mr-4 w-16 text-center">500</span>
                                    <span class="text-gray-600 dark:text-gray-300">Server Error - Internal server error</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Error Response Format</h4>
                            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                                <pre class="text-red-400"><code>{
  "success": false,
  "error": "Unauthorized",
  "message": "Invalid or missing API key",
  "code": 401
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Examples -->
                <div id="examples" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-code text-indigo-600 mr-2"></i>Code Examples
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        Ready-to-use code examples in popular programming languages.
                    </p>

                    <div class="space-y-8">
                        <!-- JavaScript Example -->
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                <i class="fab fa-js-square text-yellow-500 mr-2"></i>JavaScript (Fetch API)
                            </h4>
                            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                                <pre class="text-green-400"><code>const checkCustomer = async (phone) => {
  try {
    const response = await fetch('{{ url("/api/customer/check") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer YOUR_API_KEY'
      },
      body: JSON.stringify({ phone })
    });
    
    const data = await response.json();
    
    if (data.success) {
      console.log('Customer data:', data.data);
      return data.data;
    } else {
      console.error('Error:', data.message);
    }
  } catch (error) {
    console.error('Network error:', error);
  }
};</code></pre>
                            </div>
                        </div>

                        <!-- PHP Example -->
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                <i class="fab fa-php text-blue-500 mr-2"></i>PHP (cURL)
                            </h4>
                            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                                <pre class="text-green-400"><code>function checkCustomer($phone, $apiKey) {
    $url = '{{ url("/api/customer/check") }}';
    
    $data = json_encode(['phone' => $phone]);
    
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]
    ]);
    
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
    if ($httpCode === 200) {
        return json_decode($response, true);
    } else {
        throw new Exception('API request failed: ' . $response);
    }
}</code></pre>
                            </div>
                        </div>

                        <!-- Python Example -->
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                <i class="fab fa-python text-blue-400 mr-2"></i>Python (Requests)
                            </h4>
                            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                                <pre class="text-green-400"><code>import requests
import json

def check_customer(phone, api_key):
    url = '{{ url("/api/customer/check") }}'
    
    headers = {
        'Content-Type': 'application/json',
        'Authorization': f'Bearer {api_key}'
    }
    
    data = {'phone': phone}
    
    try:
        response = requests.post(url, headers=headers, json=data)
        response.raise_for_status()
        
        return response.json()
    except requests.exceptions.RequestException as e:
        print(f'API request failed: {e}')
        return None

# Usage
result = check_customer('01700000000', 'YOUR_API_KEY')
if result and result['success']:
    print('Customer data:', result['data'])
else:
    print('Failed to fetch customer data')</code></pre>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Support -->
                <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-lg p-8">
                    <h2 class="text-2xl font-bold text-indigo-900 dark:text-indigo-100 mb-4">
                        <i class="fas fa-life-ring text-indigo-600 mr-2"></i>Need Help?
                    </h2>
                    <p class="text-indigo-700 dark:text-indigo-300 mb-6">
                        Our support team is here to help you integrate the FraudShield API successfully.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="mailto:support@fraudshield.com" class="flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-200">
                            <i class="fas fa-envelope mr-2"></i>support@fraudshield.com
                        </a>
                        <a href="{{ route('dashboard') }}" class="flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-200">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard & API Keys
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Mobile navigation toggle
document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('mobile-nav-toggle');
    const navContent = document.getElementById('mobile-nav-content');
    const navIcon = document.getElementById('mobile-nav-icon');
    
    if (toggleButton && navContent && navIcon) {
        toggleButton.addEventListener('click', function() {
            navContent.classList.toggle('hidden');
            navIcon.classList.toggle('fa-chevron-down');
            navIcon.classList.toggle('fa-chevron-up');
        });
        
        // Close mobile nav when clicking on a link
        navContent.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                navContent.classList.add('hidden');
                navIcon.classList.remove('fa-chevron-up');
                navIcon.classList.add('fa-chevron-down');
            });
        });
    }
});

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Copy code functionality
document.querySelectorAll('code').forEach(codeBlock => {
    if (codeBlock.parentElement.tagName === 'PRE') {
        codeBlock.parentElement.style.position = 'relative';
        
        // Make code blocks horizontally scrollable on mobile
        codeBlock.parentElement.style.overflowX = 'auto';
        codeBlock.style.whiteSpace = 'pre';
        codeBlock.style.minWidth = 'max-content';
        
        const copyButton = document.createElement('button');
        copyButton.innerHTML = '<i class="fas fa-copy"></i>';
        copyButton.className = 'absolute top-2 right-2 bg-gray-700 text-white px-2 py-1 rounded text-xs hover:bg-gray-600 z-10';
        copyButton.style.fontSize = '12px';
        
        copyButton.addEventListener('click', () => {
            navigator.clipboard.writeText(codeBlock.textContent).then(() => {
                copyButton.innerHTML = '<i class="fas fa-check"></i>';
                setTimeout(() => {
                    copyButton.innerHTML = '<i class="fas fa-copy"></i>';
                }, 2000);
            });
        });
        
        codeBlock.parentElement.appendChild(copyButton);
    }
});
</script>
@endsection