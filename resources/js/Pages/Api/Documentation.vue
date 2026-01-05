<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import Card from '@/components/ui/Card.vue'
import Button from '@/components/ui/Button.vue'
import { ref } from 'vue'

const mobileNavOpen = ref(false)

const navLinks = [
  { href: '#quick-start', label: 'Quick Start' },
  { href: '#authentication', label: 'Authentication' },
  { href: '#endpoints', label: 'API Endpoints' },
  { href: '#rate-limiting', label: 'Rate Limiting' },
  { href: '#errors', label: 'Error Handling' },
  { href: '#examples', label: 'Code Examples' }
]

const codeExamples = {
  curl: `curl -X POST "https://api.fraudshield.bd/api/customer/check" \\
  -H "Authorization: Bearer YOUR_API_KEY" \\
  -H "Content-Type: application/json" \\
  -d '{"phone": "01700000000"}'`,
  php: `<?php
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.fraudshield.bd/api/customer/check',
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer YOUR_API_KEY',
        'Content-Type: application/json'
    ],
    CURLOPT_POSTFIELDS => json_encode(['phone' => '01700000000']),
    CURLOPT_RETURNTRANSFER => true
]);
$response = curl_exec($ch);
$data = json_decode($response, true);`,
  javascript: `fetch('https://api.fraudshield.bd/api/customer/check', {
    method: 'POST',
    headers: {
        'Authorization': 'Bearer YOUR_API_KEY',
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ phone: '01700000000' })
})
.then(response => response.json())
.then(data => console.log(data));`,
  python: `import requests

response = requests.post(
    'https://api.fraudshield.bd/api/customer/check',
    headers={
        'Authorization': 'Bearer YOUR_API_KEY',
        'Content-Type': 'application/json'
    },
    json={'phone': '01700000000'}
)
data = response.json()`
}

const activeTab = ref<keyof typeof codeExamples>('curl')
</script>

<template>
  <Head>
    <title>API Documentation - FraudShield</title>
    <meta name="description" content="Complete API documentation for FraudShield Courier Fraud Detection System. Learn how to integrate our API into your applications." />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
  </Head>

  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
          <i class="fas fa-code text-primary mr-3"></i>
          API Documentation
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
          Integrate FraudShield's powerful courier fraud detection into your applications with our RESTful API.
        </p>
        <div class="mt-6 flex flex-col sm:flex-row justify-center gap-4 sm:space-x-4">
          <Link href="/login">
            <Button class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/90 transition-colors">
              <i class="fas fa-key mr-2"></i>Get API Key
            </Button>
          </Link>
          <a href="#quick-start">
            <Button variant="outline" class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-6 py-3 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
              <i class="fas fa-rocket mr-2"></i>Quick Start
            </Button>
          </a>
        </div>
      </div>

      <!-- Mobile Navigation Toggle -->
      <div class="lg:hidden mb-6">
        <button 
          @click="mobileNavOpen = !mobileNavOpen"
          class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 flex items-center justify-between"
        >
          <span class="text-lg font-semibold text-gray-900 dark:text-white">Documentation Menu</span>
          <i :class="['fas text-gray-600 dark:text-gray-300 transition-transform', mobileNavOpen ? 'fa-chevron-up' : 'fa-chevron-down']"></i>
        </button>
        <div v-if="mobileNavOpen" class="mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
          <nav class="space-y-2">
            <a 
              v-for="link in navLinks" 
              :key="link.href"
              :href="link.href" 
              class="block text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary py-2 border-b border-gray-200 dark:border-gray-700 last:border-0"
              @click="mobileNavOpen = false"
            >
              {{ link.label }}
            </a>
          </nav>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Desktop Navigation Sidebar -->
        <div class="lg:col-span-1 hidden lg:block">
          <Card class="sticky top-8 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Documentation</h3>
            <nav class="space-y-2">
              <a 
                v-for="link in navLinks" 
                :key="link.href"
                :href="link.href" 
                class="block text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary py-1"
              >
                {{ link.label }}
              </a>
            </nav>
          </Card>
        </div>

        <!-- Main Content -->
        <div class="col-span-1 lg:col-span-3 space-y-8">
          <!-- Quick Start -->
          <Card id="quick-start" class="p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
              <i class="fas fa-rocket text-primary mr-2"></i>Quick Start
            </h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
              Get started with the FraudShield API in minutes. Follow these simple steps to make your first API call.
            </p>
            
            <div class="space-y-4">
              <div class="border-l-4 border-primary pl-4">
                <h4 class="font-semibold text-gray-900 dark:text-white">1. Get Your API Key</h4>
                <p class="text-gray-600 dark:text-gray-300">Register an account and generate your API key from the dashboard.</p>
              </div>
              <div class="border-l-4 border-primary pl-4">
                <h4 class="font-semibold text-gray-900 dark:text-white">2. Make Your First Request</h4>
                <p class="text-gray-600 dark:text-gray-300">Use your API key to authenticate and check customer fraud data.</p>
              </div>
              <div class="border-l-4 border-primary pl-4">
                <h4 class="font-semibold text-gray-900 dark:text-white">3. Handle the Response</h4>
                <p class="text-gray-600 dark:text-gray-300">Process the JSON response to integrate fraud detection into your workflow.</p>
              </div>
            </div>
          </Card>

          <!-- Authentication -->
          <Card id="authentication" class="p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
              <i class="fas fa-shield-alt text-primary mr-2"></i>Authentication
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
          </Card>

          <!-- API Endpoints -->
          <Card id="endpoints" class="p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
              <i class="fas fa-sitemap text-primary mr-2"></i>API Endpoints
            </h2>

            <div class="space-y-8">
              <!-- Customer Check Endpoint -->
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
          </Card>

          <!-- Rate Limiting -->
          <Card id="rate-limiting" class="p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
              <i class="fas fa-tachometer-alt text-primary mr-2"></i>Rate Limiting
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
                  <p class="text-2xl font-bold text-primary">60/min</p>
                  <p class="text-gray-600 dark:text-gray-300 text-sm">60 requests per minute</p>
                </div>
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                  <h5 class="font-semibold text-gray-900 dark:text-white">Professional</h5>
                  <p class="text-2xl font-bold text-primary">300/min</p>
                  <p class="text-gray-600 dark:text-gray-300 text-sm">300 requests per minute</p>
                </div>
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                  <h5 class="font-semibold text-gray-900 dark:text-white">Enterprise</h5>
                  <p class="text-2xl font-bold text-primary">1000/min</p>
                  <p class="text-gray-600 dark:text-gray-300 text-sm">1000 requests per minute</p>
                </div>
              </div>
            </div>
          </Card>

          <!-- Error Handling -->
          <Card id="errors" class="p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
              <i class="fas fa-exclamation-triangle text-primary mr-2"></i>Error Handling
            </h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
              The API uses conventional HTTP response codes to indicate success or failure of requests.
            </p>

            <div class="space-y-3">
              <div class="flex items-center flex-wrap gap-2">
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center">200</span>
                <span class="text-gray-900 dark:text-white font-medium">OK</span>
                <span class="text-gray-600 dark:text-gray-300 text-sm">- Request succeeded</span>
              </div>
              <div class="flex items-center flex-wrap gap-2">
                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center">400</span>
                <span class="text-gray-900 dark:text-white font-medium">Bad Request</span>
                <span class="text-gray-600 dark:text-gray-300 text-sm">- Invalid parameters</span>
              </div>
              <div class="flex items-center flex-wrap gap-2">
                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center">401</span>
                <span class="text-gray-900 dark:text-white font-medium">Unauthorized</span>
                <span class="text-gray-600 dark:text-gray-300 text-sm">- Invalid or missing API key</span>
              </div>
              <div class="flex items-center flex-wrap gap-2">
                <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center">429</span>
                <span class="text-gray-900 dark:text-white font-medium">Too Many Requests</span>
                <span class="text-gray-600 dark:text-gray-300 text-sm">- Rate limit exceeded</span>
              </div>
              <div class="flex items-center flex-wrap gap-2">
                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium w-16 text-center">500</span>
                <span class="text-gray-900 dark:text-white font-medium">Server Error</span>
                <span class="text-gray-600 dark:text-gray-300 text-sm">- Something went wrong on our end</span>
              </div>
            </div>
          </Card>

          <!-- Code Examples -->
          <Card id="examples" class="p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
              <i class="fas fa-code text-primary mr-2"></i>Code Examples
            </h2>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
              Copy and paste these examples to get started quickly.
            </p>

            <!-- Tabs -->
            <div class="flex flex-wrap gap-2 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
              <button 
                v-for="(_, key) in codeExamples"
                :key="key"
                @click="activeTab = key"
                :class="[
                  'px-4 py-2 rounded-lg text-sm font-medium transition-colors',
                  activeTab === key 
                    ? 'bg-primary text-white' 
                    : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'
                ]"
              >
                {{ key.charAt(0).toUpperCase() + key.slice(1) }}
              </button>
            </div>

            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
              <pre class="text-green-400 text-sm"><code>{{ codeExamples[activeTab] }}</code></pre>
            </div>
          </Card>
        </div>
      </div>

      <!-- Back to Home -->
      <div class="text-center mt-12">
        <Link href="/">
          <Button variant="outline" class="px-6 py-3">
            <i class="fas fa-arrow-left mr-2"></i>Back to Home
          </Button>
        </Link>
      </div>
    </div>
  </div>
</template>
