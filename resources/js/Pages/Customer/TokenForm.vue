<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/components/ui/Card.vue';
import Button from '@/components/ui/Button.vue';
import { ref } from 'vue';
import { Search, Users, Shield } from 'lucide-vue-next';

const token = ref('');
const isLoading = ref(false);
const customers = ref<any[]>([]);
const error = ref<string | null>(null);

const searchCustomers = async () => {
    if (!token.value) {
        error.value = 'Please enter a valid token';
        return;
    }
    
    isLoading.value = true;
    error.value = null;
    
    try {
        const response = await fetch('/customer-data', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            },
            body: JSON.stringify({ token: token.value }),
        });
        
        const data = await response.json();
        
        if (data.success) {
            customers.value = data.data || [];
        } else {
            error.value = data.message || 'Failed to fetch customer data';
        }
    } catch (err) {
        error.value = 'An error occurred while fetching data';
    } finally {
        isLoading.value = false;
    }
};
</script>

<template>
    <Head>
        <title>Customer Portal | FraudShield</title>
        <meta name="robots" content="noindex, nofollow" />
    </Head>
    
    <AppLayout>
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center justify-center gap-3">
                        <Users class="w-8 h-8 text-indigo-600" />
                        Customer Portal
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        Access customer delivery data with your authentication token
                    </p>
                </div>
                
                <!-- Token Input -->
                <Card class="p-6 mb-8">
                    <form @submit.prevent="searchCustomers" class="flex gap-4">
                        <div class="flex-1">
                            <input 
                                type="text" 
                                v-model="token"
                                placeholder="Enter your authentication token"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                            />
                        </div>
                        <Button 
                            type="submit"
                            :disabled="isLoading"
                            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg flex items-center gap-2"
                        >
                            <Search class="w-4 h-4" />
                            <span v-if="isLoading">Loading...</span>
                            <span v-else>Search</span>
                        </Button>
                    </form>
                    
                    <p v-if="error" class="mt-3 text-red-500 text-sm">{{ error }}</p>
                </Card>
                
                <!-- Results -->
                <Card v-if="customers.length > 0" class="p-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">
                        Customer Data ({{ customers.length }} records)
                    </h2>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b dark:border-gray-700">
                                    <th class="text-left py-3 px-4 text-gray-600 dark:text-gray-400">Phone</th>
                                    <th class="text-left py-3 px-4 text-gray-600 dark:text-gray-400">Status</th>
                                    <th class="text-left py-3 px-4 text-gray-600 dark:text-gray-400">Orders</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="customer in customers" :key="customer.id" class="border-b dark:border-gray-700">
                                    <td class="py-3 px-4 text-gray-800 dark:text-gray-200">{{ customer.phone }}</td>
                                    <td class="py-3 px-4">
                                        <span :class="[
                                            'px-2 py-1 rounded text-xs font-medium',
                                            customer.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'
                                        ]">
                                            {{ customer.status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-800 dark:text-gray-200">{{ customer.orders_count }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </Card>
                
                <!-- Empty State -->
                <Card v-else-if="!isLoading && token" class="p-8 text-center">
                    <Shield class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" />
                    <p class="text-gray-600 dark:text-gray-400">
                        No customer data found. Please check your token.
                    </p>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
