@extends('layouts.app')

@section('title', 'API Documentation - Courier Fraud')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">API Documentation</h1>
            <p class="text-gray-600 mt-2">Complete guide to using our Courier Fraud Detection API</p>
        </div>

        <!-- Authentication -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Authentication</h2>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-4">All API requests require authentication using your API key. Include your API key in the request headers:</p>
                <div class="bg-gray-100 rounded-lg p-4">
                    <code class="text-sm">
                        Authorization: Bearer YOUR_API_KEY
                    </code>
                </div>
                <p class="text-sm text-gray-600 mt-2">You can generate API keys from your dashboard.</p>
            </div>
        </div>

        <!-- Base URL -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Base URL</h2>
            </div>
            <div class="p-6">
                <div class="bg-gray-100 rounded-lg p-4">
                    <code class="text-sm">
                        {{ url('/api') }}
                    </code>
                </div>
            </div>
        </div>

        <!-- Endpoints -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Available Endpoints</h2>
            </div>
            <div class="p-6 space-y-8">
                
                <!-- Check Courier -->
                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Check Courier Status</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-semibold mr-2">POST</span>
                            <code class="text-sm bg-gray-100 px-2 py-1 rounded">/api/courier-check</code>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Request Body:</h4>
                            <div class="bg-gray-100 rounded-lg p-4">
                                <pre class="text-sm"><code>{
  "phone": "01712345678"
}</code></pre>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Response:</h4>
                            <div class="bg-gray-100 rounded-lg p-4">
                                <pre class="text-sm"><code>{
  "success": true,
  "data": {
    "phone": "01712345678",
    "name": "John Doe",
    "area": "Dhaka",
    "status": "verified",
    "risk_level": "low",
    "total_deliveries": 150,
    "successful_deliveries": 145,
    "success_rate": 96.67
  },
  "message": "Courier information retrieved successfully"
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Get Customer Reviews -->
                <div class="border-l-4 border-purple-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Get Customer Reviews</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-semibold mr-2">GET</span>
                            <code class="text-sm bg-gray-100 px-2 py-1 rounded">/api/customer-reviews/{phone}</code>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Response:</h4>
                            <div class="bg-gray-100 rounded-lg p-4">
                                <pre class="text-sm"><code>{
  "success": true,
  "data": [
    {
      "id": 1,
      "phone": "01712345678",
      "commenter_name": "Jane Smith",
      "commenter_phone": "01987654321",
      "rating": 5,
      "comment": "Excellent service, very reliable",
      "created_at": "2024-01-15T10:30:00Z"
    }
  ],
  "message": "Customer reviews retrieved successfully"
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Customer Review -->
                <div class="border-l-4 border-orange-500 pl-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Submit Customer Review</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-semibold mr-2">POST</span>
                            <code class="text-sm bg-gray-100 px-2 py-1 rounded">/api/customer-review</code>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Request Body:</h4>
                            <div class="bg-gray-100 rounded-lg p-4">
                                <pre class="text-sm"><code>{
  "phone": "01712345678",
  "commenter_name": "Jane Smith",
  "commenter_phone": "01987654321",
  "rating": 5,
  "comment": "Excellent service, very reliable"
}</code></pre>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Response:</h4>
                            <div class="bg-gray-100 rounded-lg p-4">
                                <pre class="text-sm"><code>{
  "success": true,
  "data": {
    "id": 1,
    "phone": "01712345678",
    "commenter_name": "Jane Smith",
    "commenter_phone": "01987654321",
    "rating": 5,
    "comment": "Excellent service, very reliable",
    "created_at": "2024-01-15T10:30:00Z"
  },
  "message": "Review submitted successfully"
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rate Limiting -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Rate Limiting</h2>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-4">API requests are rate-limited based on your subscription plan:</p>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Daily Limit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate Limit</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Basic</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1,000 requests</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">60 requests/minute</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Professional</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">5,000 requests</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">120 requests/minute</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Enterprise</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15,000 requests</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">300 requests/minute</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Error Codes -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Error Codes</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-semibold text-red-600">401 Unauthorized</h4>
                        <p class="text-gray-700">Invalid or missing API key</p>
                        <div class="bg-gray-100 rounded p-2 mt-2">
                            <code class="text-sm">{"error": "Unauthorized", "message": "Invalid API key"}</code>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-semibold text-red-600">429 Too Many Requests</h4>
                        <p class="text-gray-700">Rate limit exceeded</p>
                        <div class="bg-gray-100 rounded p-2 mt-2">
                            <code class="text-sm">{"error": "Rate limit exceeded", "message": "Too many requests"}</code>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-semibold text-red-600">400 Bad Request</h4>
                        <p class="text-gray-700">Invalid request parameters</p>
                        <div class="bg-gray-100 rounded p-2 mt-2">
                            <code class="text-sm">{"error": "Validation failed", "message": "Phone number is required"}</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SDKs and Libraries -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Code Examples</h2>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">cURL</h3>
                        <div class="bg-gray-100 rounded-lg p-4">
                            <pre class="text-sm"><code>curl -X POST {{ url('/api/courier-check') }} \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{"phone": "01712345678"}'</code></pre>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">JavaScript (Fetch)</h3>
                        <div class="bg-gray-100 rounded-lg p-4">
                            <pre class="text-sm"><code>fetch('{{ url('/api/courier-check') }}', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer YOUR_API_KEY',
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    phone: '01712345678'
  })
})
.then(response => response.json())
.then(data => console.log(data));</code></pre>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">PHP</h3>
                        <div class="bg-gray-100 rounded-lg p-4">
                            <pre class="text-sm"><code>$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => '{{ url('/api/courier-check') }}',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(['phone' => '01712345678']),
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer YOUR_API_KEY',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection