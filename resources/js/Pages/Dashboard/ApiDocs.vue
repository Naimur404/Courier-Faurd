<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/components/ui/Card.vue';
import { 
    Code, Key, Lock, Zap, Copy, Check, 
    ArrowRight, Terminal, Shield, Clock
} from 'lucide-vue-next';
import { ref } from 'vue';

const copiedCode = ref<string | null>(null);

const copyToClipboard = (text: string, id: string) => {
    navigator.clipboard.writeText(text);
    copiedCode.value = id;
    setTimeout(() => {
        copiedCode.value = null;
    }, 2000);
};

const endpoints = [
    {
        method: 'POST',
        path: '/api/v1/check',
        description: 'Check courier fraud status for a phone number',
        params: [
            { name: 'phone', type: 'string', required: true, description: 'Bangladesh mobile number (11 digits, starting with 01)' }
        ]
    },
    {
        method: 'GET',
        path: '/api/v1/status',
        description: 'Check your API key status and remaining quota',
        params: []
    }
];

const exampleRequest = `curl -X POST https://fraudshieldbd.site/api/v1/check \\
  -H "Authorization: Bearer YOUR_API_KEY" \\
  -H "Content-Type: application/json" \\
  -d '{"phone": "01700000000"}'`;

const exampleResponse = `{
  "success": true,
  "data": {
    "phone": "01700000000",
    "risk_level": "low",
    "success_ratio": 95.5,
    "total_orders": 150,
    "successful_deliveries": 143,
    "cancelled_orders": 7
  }
}`;
</script>

<template>
    <Head>
        <title>API Documentation | FraudShield</title>
        <meta name="description" content="FraudShield API Documentation - Integrate courier fraud detection into your application. RESTful API with simple authentication." />
        <link rel="canonical" href="https://fraudshieldbd.site/dashboard/api-docs" />
        <meta property="og:title" content="API Documentation | FraudShield" />
        <meta property="og:description" content="Integrate courier fraud detection into your application with our RESTful API." />
        <meta name="robots" content="noindex, nofollow" />
    </Head>
    
    <AppLayout>
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4">
            <div class="max-w-5xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4 flex items-center justify-center gap-3">
                        <Code class="w-10 h-10 text-indigo-600" />
                        API ডকুমেন্টেশন
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-400">
                        FraudShield API ব্যবহার করে আপনার অ্যাপ্লিকেশনে কুরিয়ার ফ্রড ডিটেকশন ইন্টিগ্রেট করুন
                    </p>
                </div>
                
                <!-- Quick Start -->
                <Card class="p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <Zap class="w-6 h-6 text-yellow-500" />
                        Quick Start
                    </h2>
                    
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="flex items-start gap-3">
                            <div class="bg-indigo-100 dark:bg-indigo-900/30 rounded-full p-2">
                                <Key class="w-5 h-5 text-indigo-600" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-white">১. API Key নিন</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Dashboard থেকে আপনার API Key জেনারেট করুন</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="bg-green-100 dark:bg-green-900/30 rounded-full p-2">
                                <Lock class="w-5 h-5 text-green-600" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-white">২. Authenticate করুন</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Bearer token হিসেবে API Key পাঠান</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="bg-purple-100 dark:bg-purple-900/30 rounded-full p-2">
                                <Terminal class="w-5 h-5 text-purple-600" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-white">৩. API Call করুন</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Endpoints ব্যবহার করে ডাটা পান</p>
                            </div>
                        </div>
                    </div>
                </Card>
                
                <!-- Authentication -->
                <Card class="p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <Shield class="w-6 h-6 text-green-500" />
                        Authentication
                    </h2>
                    
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        সব API request-এ Authorization header-এ Bearer token হিসেবে আপনার API Key পাঠাতে হবে:
                    </p>
                    
                    <div class="bg-gray-900 rounded-lg p-4 relative">
                        <code class="text-green-400 text-sm">
                            Authorization: Bearer YOUR_API_KEY
                        </code>
                        <button 
                            @click="copyToClipboard('Authorization: Bearer YOUR_API_KEY', 'auth')"
                            class="absolute top-2 right-2 p-2 hover:bg-gray-700 rounded transition-colors"
                        >
                            <Check v-if="copiedCode === 'auth'" class="w-4 h-4 text-green-400" />
                            <Copy v-else class="w-4 h-4 text-gray-400" />
                        </button>
                    </div>
                </Card>
                
                <!-- Base URL -->
                <Card class="p-6 mb-8">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Base URL</h2>
                    <div class="bg-gray-900 rounded-lg p-4">
                        <code class="text-blue-400">https://fraudshieldbd.site/api/v1</code>
                    </div>
                </Card>
                
                <!-- Endpoints -->
                <Card class="p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                        <ArrowRight class="w-6 h-6 text-indigo-500" />
                        Endpoints
                    </h2>
                    
                    <div class="space-y-6">
                        <div v-for="endpoint in endpoints" :key="endpoint.path" class="border dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <span :class="[
                                    'px-3 py-1 rounded text-sm font-bold',
                                    endpoint.method === 'POST' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400'
                                ]">
                                    {{ endpoint.method }}
                                </span>
                                <code class="text-gray-800 dark:text-gray-200 font-mono">{{ endpoint.path }}</code>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 mb-3">{{ endpoint.description }}</p>
                            
                            <div v-if="endpoint.params.length > 0" class="mt-4">
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Parameters:</h4>
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b dark:border-gray-700">
                                            <th class="text-left py-2 text-gray-600 dark:text-gray-400">Name</th>
                                            <th class="text-left py-2 text-gray-600 dark:text-gray-400">Type</th>
                                            <th class="text-left py-2 text-gray-600 dark:text-gray-400">Required</th>
                                            <th class="text-left py-2 text-gray-600 dark:text-gray-400">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="param in endpoint.params" :key="param.name">
                                            <td class="py-2 font-mono text-indigo-600 dark:text-indigo-400">{{ param.name }}</td>
                                            <td class="py-2 text-gray-600 dark:text-gray-400">{{ param.type }}</td>
                                            <td class="py-2">
                                                <span :class="param.required ? 'text-red-500' : 'text-gray-500'">
                                                    {{ param.required ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                            <td class="py-2 text-gray-600 dark:text-gray-400">{{ param.description }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </Card>
                
                <!-- Example Request -->
                <Card class="p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Example Request</h2>
                    <div class="bg-gray-900 rounded-lg p-4 relative overflow-x-auto">
                        <pre class="text-green-400 text-sm whitespace-pre-wrap">{{ exampleRequest }}</pre>
                        <button 
                            @click="copyToClipboard(exampleRequest, 'request')"
                            class="absolute top-2 right-2 p-2 hover:bg-gray-700 rounded transition-colors"
                        >
                            <Check v-if="copiedCode === 'request'" class="w-4 h-4 text-green-400" />
                            <Copy v-else class="w-4 h-4 text-gray-400" />
                        </button>
                    </div>
                </Card>
                
                <!-- Example Response -->
                <Card class="p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Example Response</h2>
                    <div class="bg-gray-900 rounded-lg p-4 relative overflow-x-auto">
                        <pre class="text-blue-400 text-sm whitespace-pre-wrap">{{ exampleResponse }}</pre>
                        <button 
                            @click="copyToClipboard(exampleResponse, 'response')"
                            class="absolute top-2 right-2 p-2 hover:bg-gray-700 rounded transition-colors"
                        >
                            <Check v-if="copiedCode === 'response'" class="w-4 h-4 text-green-400" />
                            <Copy v-else class="w-4 h-4 text-gray-400" />
                        </button>
                    </div>
                </Card>
                
                <!-- Rate Limiting -->
                <Card class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <Clock class="w-6 h-6 text-orange-500" />
                        Rate Limiting
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        API requests আপনার সাবস্ক্রিপশন প্ল্যান অনুযায়ী লিমিটেড। Rate limit exceed করলে 
                        <code class="bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">429 Too Many Requests</code> 
                        response পাবেন।
                    </p>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
